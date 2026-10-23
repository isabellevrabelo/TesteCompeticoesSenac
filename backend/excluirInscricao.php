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
    $url = "../admin/aInscricoes.php";
} else {
    $url = "../organizador/oInscricoes.php";

}

$id_inscricao = $_POST['id_inscricao'];


$conexao->begin_transaction();

try {
    
    $consulta = $conexao->prepare("SELECT id_evento FROM inscricoes WHERE id = ?");
    $consulta->bind_param("i",$id_inscricao);

    if (!$consulta->execute()) {
        throw new Exception("Erro ao consultar");
    }
    
    $resultado = $consulta->get_result();
    $consulta->close();

    if ($resultado->num_rows > 0) {

        $dados = $resultado->fetch_assoc();
        $id_evento = $dados['id_evento'];

    } else {

        echo"<script>
        alert('Inscrição não encontrada.');
        window.location.href = '$url';
        </script>";
    
        exit();
    }

    $atualizar = $conexao->prepare("UPDATE eventos SET vagas = vagas + 1 WHERE id = ?");
    $atualizar->bind_param("i",$id_evento);

    if (!$atualizar->execute()) {
        throw new Exception("Erro ao atualizar");
    }

    if ($atualizar->affected_rows === 0) {
        throw new Exception("Erro ao atualizar");
    }

    $atualizar->close();

    $excluir = $conexao->prepare("DELETE FROM inscricoes WHERE id = ?");
    $excluir->bind_param("i",$id_inscricao);

    if (!$excluir->execute()) {
        throw new Exception("Erro ao excluir");
    }

    $excluir->close();
    $conexao->commit();

    echo"<script>
    alert('Inscrição excluída com sucesso!');
    window.location.href = '$url';
    </script>";

    exit();

} catch (\Throwable $th) {
    
    $conexao->rollback();

    error_log("Erro ao: " . $th->getMessage());
    // echo("Erro ao: " . $th->getMessage());

    echo"<script>
    alert('Erro inesperado.Tente novamente mais tarde.');
    window.location.href = '$url';
    </script>";

    exit();
}   
$conexao->close();
?>