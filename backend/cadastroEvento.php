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
    $url = "../admin/aCadastroE.php";
} else {
    $url = "../organizador/oCadastroE.php";

}


$titulo = $_POST['titulo'];
$descricao = $_POST['descricao'];
$vagas = $_POST['vagas'];
$data_evento = $_POST['data_evento'];

if ($vagas <= 0) {

    echo"<script>
    alert('Não é possível cadastrar eventos com zero vagas.');
    window.location.href = '$url';
    </script>";

    exit();

}

$conexao->begin_transaction();

try {
    
    $envio = $conexao->prepare("INSERT INTO eventos(titulo,descricao,vagas,data_evento) VALUES(?,?,?,?)");
    $envio->bind_param("ssis",$titulo,$descricao,$vagas,$data_evento);

    $envio->execute();

    $envio->close();

    $conexao->commit();

    echo"<script>
    alert('Evento cadastrado com sucesso!');
    window.location.href = '$url';
    </script>";

    exit();

} catch (mysqli_sql_exception $e) {
    
    $conexao->rollback();

    if ($e->getCode() === 1062) {
        
        echo"<script>
            alert('Evento já cadastrado.');
            window.location.href = '$url';
        </script>";
        exit();

    } else {

        error_log("Erro ao inserir: " . $e->getMessage());
        // echo("Erro ao inserir: " . $e->getCode());
        echo "<script>
                alert('Erro ao cadastrar Evento. Tente novamente mais tarde.');
                window.location.href = '$url';
            </script>";
        exit();

    }

}
$conexao->close();