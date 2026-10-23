<?php
session_start();
require_once("conexao.php");

if (!isset($_SESSION['email'])) {
    session_destroy();
    header('Location: /teste/index.php');
    exit();
}

if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'comum') {
    session_destroy();
    header('Location: /teste/index.php');
    exit();
}

$url = '../comum/cMinhasInscricoes.php';

$id_inscricao = $_POST['id_inscricao']; 
$id_usuario = $_SESSION['id'];


$conexao->begin_transaction();

try {
   

    $consulta = $conexao->prepare("SELECT id_evento FROM inscricoes WHERE id = ? AND id_usuario = ?");
    $consulta->bind_param("ii", $id_inscricao, $id_usuario);
    
    if (!$consulta->execute()) {
        throw new Exception("Erro ao consultar a inscrição.");
    }
    
    $resultado = $consulta->get_result();
    $consulta->close();

    if ($resultado->num_rows > 0) {
        $dados = $resultado->fetch_assoc();
        $id_evento = $dados['id_evento'];
    } else {
        throw new Exception("Inscrição não encontrada.");
    }

    $atualizar = $conexao->prepare("UPDATE eventos SET vagas = vagas + 1 WHERE id = ?");
    $atualizar->bind_param("i", $id_evento);
    
    if (!$atualizar->execute()) {
        throw new Exception("Erro ao atualizar as vagas do evento.");
    }
    
    if ($atualizar->affected_rows === 0) {
        throw new Exception("Nenhuma alteração feita no evento.");
    }
    $atualizar->close();

    $excluir = $conexao->prepare("DELETE FROM inscricoes WHERE id = ? AND id_usuario = ?");
    $excluir->bind_param("ii", $id_inscricao, $id_usuario);
    
    if (!$excluir->execute()) {
        throw new Exception("Erro ao excluir o registro de inscrição.");
    }
    $excluir->close();

    $conexao->commit();

    echo "<script>
            alert('Inscrição excluída com sucesso!');
            window.location.href = '$url';
          </script>";
    exit();

} catch (\Throwable $th) {
    
    $conexao->rollback();
    

    error_log("Erro no processo de cancelamento: " . $th->getMessage());
    echo("Erro no processo de cancelamento: " . $th->getMessage());

    if ($th->getMessage() === "Inscrição não encontrada.") {

            echo "<script>
            alert('Inscrição não encontrada.');
            window.location.href = '$url';
          </script>";

    exit();

    } else {

        echo "<script>
            alert('Erro inesperado. Tente novamente mais tarde.');
            window.location.href = '$url';
        </script>";
    exit();

    }
    

}

$conexao->close();
?>
