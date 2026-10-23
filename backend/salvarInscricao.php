<?php
session_start();
require_once("conexao.php");

if (!isset($_SESSION['email'])) {
    session_destroy();
    header("Location: /teste/index.php");
    exit();
}

if (!isset($_SESSION['tipo']) || ($_SESSION['tipo']) !== 'comum') {
    session_destroy();
    header("Location: /teste/index.php");
    exit();
}

$id_usuario = $_SESSION['id'];
$id_evento = $_POST['id_evento'];

$conexao->begin_transaction();


try {

    $verificar = $conexao->prepare("SELECT titulo,vagas FROM eventos WHERE id = ?");
    $verificar->bind_param("i",$id_evento);

    if (!$verificar->execute()) {
        throw new Exception("Erro inesperado tente novamente mais tarde.");
    }

    $verificarR = $verificar->get_result();

    if ((int)$verificarR->num_rows <= 0 ) {
        $conexao->rollback();
        
        echo"<script>
            alert('Evento não encontrado');
            window.location.href = '../comum/cInicio.php';
        </script>";

        exit();
    }

    $vagas = $verificarR->fetch_assoc();

    if ((int)$vagas['vagas'] === 0) {
        
    echo"<script>
        alert('Vagas esgotadas.');
        window.location.href = '../comum/cInicio.php';
    </script>";

    exit();
    }

    $verificar->close();

    $consulta = $conexao->prepare("SELECT inscricoes.id
                                FROM inscricoes
                                INNER JOIN eventos
                                    ON eventos.id = inscricoes.id_evento
                                WHERE inscricoes.id_usuario = ?
                                AND eventos.data_evento = (
                                    SELECT data_evento
                                    FROM eventos WHERE id = ?
                                )    
                                ");

    $consulta->bind_param("ii",$id_usuario,$id_evento);

    if (!$consulta->execute()) {
        throw new Exception("Erro inesperado tente novamente mais tarde.");
    }


    $resultado = $consulta->get_result();

    if ($resultado->num_rows > 0) {
        $conexao->rollback();

        echo"<script>
            alert('Você já está inscrito(a) em outro evento com mesma data ou já possuí inscrição nesse evento.');
            window.location.href = '../comum/cInicio.php';
        </script>";

        exit();
    }

    $consulta->close();
    

    $atualizar = $conexao->prepare("UPDATE eventos SET vagas = vagas -1 WHERE id = ? AND vagas > 0");
    $atualizar->bind_param("i",$id_evento);

    if (!$atualizar->execute()) {
        throw new Exception("Erro inesperado tente novamente mais tarde.");
    }

    if ($atualizar->affected_rows === 0 ) {
        throw new Exception("Vagas esgotadas.");
        
    }


    $atualizar->close();

    $envio = $conexao->prepare("INSERT INTO inscricoes(id_usuario,id_evento) VALUES (?,?)");
    $envio->bind_param("ii",$id_usuario,$id_evento);

    if (!$envio->execute()) {
        throw new Exception("Erro inesperado tente novamente mais tarde.");
    }
    
    $envio->close();

    $conexao->commit();

    echo"<script>
        alert('Inscrição feita com sucesso!');
        window.location.href = '../comum/cInicio.php';
        </script>";
    exit();

} catch (Throwable $e) {
    
    $conexao->rollback();

    if ($e->getCode() === 1062) {
        
        echo"<script>
            alert('Você já está inscrito(a) nesse evento.');
            window.location.href = '../comum/cInicio.php';
        </script>";

        exit();


    } else {

        error_log("Erro ao inserir: " . $e->getMessage());
        // echo("Erro ao inserir: " . $e->getMessage());
        // echo("Erro ao inserir: " . $e->getCode());

        echo "<script>
                alert('Erro ao realizar inscrição. Tente novamente mais tarde.');
                window.location.href = '../comum/cInicio.php';
            </script>";
        exit();

    }

}
$conexao->close();