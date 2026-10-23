<?php
session_start();
require_once("conexao.php");

if (!isset($_SESSION['email'])) {
    session_destroy();
    header("Location: /teste/index.php");
    exit();
}

if (!isset($_SESSION['tipo']) || ($_SESSION['tipo']) !== 'admin' && $_SESSION['tipo'] !== 'organizador') {
    session_destroy();
    header("Location: /teste/index.php");
    exit();
}

if ($_SESSION['tipo'] === 'admin') {
    $url = "../admin/aEventos.php";
} else {
    $url = "../organizador/oEventos.php";

}

$id_evento = $_POST['id_evento'];

$novoTitulo = $_POST['titulo'];
$novaDescricao = $_POST['descricao'];
$novaVaga = $_POST['vagas'];
$novaData = $_POST['data_evento'];

if ((int)$novaVaga <= 0) {
    
    echo"<script>
    alert('Não é possível cadastrar eventos com zero vagas.');
    window.location.href = '$url';
    </script>";

    exit();
}

$conexao->begin_transaction();

try {
    
    $consulta = $conexao->prepare("SELECT * FROM eventos WHERE id = ?");
    $consulta->bind_param("i",$id_evento);
    
    if (!$consulta->execute()) {
        throw new Exception("Erro inesperado.");
    }

    $resultado = $consulta->get_result();
    $consulta->close();

    if ($resultado->num_rows > 0) {

        $evento = $resultado->fetch_assoc();

        if ($novoTitulo === "") {
            $novoTitulo = $evento['titulo'];
        }

        if ($novaDescricao === "") {
            $novaDescricao = $evento['descricao'];
        }

        if ($novaVaga === "") {
            $novaVaga = $evento['vagas'];
        }

        if ($novaData === "") {
            $novaData = $evento['data_evento'];
        }

        $atualizar = $conexao->prepare("UPDATE eventos SET titulo = ?,descricao = ?,vagas = ?,data_evento = ? WHERE id = ?");
        $atualizar->bind_param("ssssi",$novoTitulo,$novaDescricao,$novaVaga,$novaData,$id_evento);

        if (!$atualizar->execute()) {
            throw new Exception("Erro de atualização");
        }

        if ($atualizar->affected_rows === 0) {
            throw new Exception("Erro de atualização");
        }
        
        $atualizar->close();

        $conexao->commit();

        echo"<script>
        alert('Evento atualizado com sucesso!');
        window.location.href = '$url';
        </script>";

    } else {

        $conexao->rollback();

        echo"<script>
        alert('Evento não encontrado.');
        window.location.href = '$url';
        </script>";
    
        exit();

    }
} catch (\Throwable $th) {
    
    $conexao->rollback();

    error_log("Erro ao atulizar: " . $th ->getMessage());
    // echo("Erro ao atulizar: " . $th ->getMessage());

    echo"<script>
    alert('Erro ao atualizar evento.Tente novamente mais tarde');
    window.location.href = '$url';
    </script>";

exit();
}
$conexao->close();
