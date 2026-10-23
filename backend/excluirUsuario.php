<?php
session_start();
require_once("conexao.php");

if (!isset($_SESSION['email'])) {
    session_destroy();
    header("Location: ../index.php"); 
    exit();
}
if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'admin') {
    session_destroy();
    header("Location: ../index.php"); 
    exit();
}

$id_usuario = $_POST['id_usuario'];

$consulta = $conexao->prepare("SELECT nome FROM usuarios WHERE id = ?");
$consulta ->bind_param("i",$id_usuario);

if (!$consulta->execute()) {
    echo"<script>
    alert('Erro ao consultar usuário.Tente novamente mais tarde!');
    window.location.href = '../admin/aInicio.php';
    </script>";
    exit();
}

$resultado = $consulta->get_result();
$consulta->close();

if ($resultado->num_rows === 0) {
    
    echo"<script>
    alert('Usuário não encontrado!');
    window.location.href = '../admin/aInicio.php';
    </script>";
    exit();
}

$conexao->begin_transaction();


try {

$consultaInscricoes = $conexao->prepare("SELECT id_evento FROM inscricoes WHERE id_usuario = ?");
$consultaInscricoes->bind_param("i",$id_usuario);

if (!$consultaInscricoes->execute()) {

    error_log("Erro de consulta: " . $consultaInscricoes->error);

    throw new Exception("Erro.Tente novamente mais tarde!");
    
    
}

$resultadoInscricoes = $consultaInscricoes->get_result();
$consultaInscricoes->close();

while ($linha = $resultadoInscricoes->fetch_assoc()) {
    $id_evento = $linha['id_evento'];

    $atualizar = $conexao->prepare("UPDATE eventos SET vagas = vagas + 1 WHERE id = ?");
    $atualizar->bind_param("i",$id_evento);

    if (!$atualizar->execute()) {

        error_log("Erro de update: " . $atualizar->error);
    
        throw new Exception("Erro.Tente novamente mais tarde!");
    
    }

    $atualizar->close();
}
    
    $excluiInscricao = $conexao->prepare("DELETE FROM inscricoes WHERE id_usuario = ?");
    $excluiInscricao->bind_param("i",$id_usuario);

    if(!$excluiInscricao->execute()) {
        throw new Exception("Erro.Tente novamente mais tarde!");
        
    }
    $excluiInscricao->close();

    $excluiUsuario = $conexao->prepare("DELETE FROM usuarios WHERE id = ?");
    $excluiUsuario->bind_param("i",$id_usuario);

    if(!$excluiUsuario->execute()) {
        throw new Exception("Erro.Tente novamente mais tarde!");       
    }

    $excluiUsuario->close();
    $conexao->commit();

    echo "<script>
    alert('Usuário excluído com sucesso!'); 
    window.location.href = '../admin/aInicio.php'; 
    </script>"; 
    exit();

} catch (Exception $erro) {
    
    $conexao->rollback();

    error_log("Erro ao excluir usuário: " . $erro->getMessage());

    echo "<script>
        alert(" . json_encode($erro->getMessage()) . ");
        window.location.href = '../admin/aInicio.php';
        </script>";
    exit();
}

$conexao->close();
?>