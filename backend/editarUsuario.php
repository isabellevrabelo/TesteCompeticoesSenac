<?php
session_start();
require_once("conexao.php");

if (!isset($_SESSION['email'])) {
    session_destroy();
    header("Location: /teste/index.php");
    exit();
}

if (!isset($_SESSION['tipo']) || ($_SESSION['tipo']) !== 'admin') {
    session_destroy();
    header("Location: /teste/index.php");
    exit();
}

$id_usuario = $_POST['id_usuario'];
$novoNome = $_POST['nome'];
$novoEmail =$_POST['email'];
$novoTelefone = $_POST['telefone'];
$novaSenha = $_POST['senha'];

$conexao->begin_transaction();

try {
    
    $consulta = $conexao->prepare("SELECT nome,email,telefone,senha FROM usuarios WHERE id = ? AND id <> 1");
    $consulta->bind_param("i",$id_usuario);

    if (!$consulta->execute()) {
        throw new Exception("Erro de verificação.");
    }

    $resultado = $consulta->get_result();

    $consulta->close();

    if ($resultado->num_rows > 0) {
        
        $usuario = $resultado->fetch_assoc();

        if ($novoNome === "") {
            $novoNome = $usuario['nome'];
        }

        if ($novoEmail === "") {
            $novoEmail = $usuario['email'];
        }

        if ($novoTelefone === "") {
            $novoTelefone = $usuario['telefone'];
        }

        if ($novaSenha !== "") {
            $novaSenha = password_hash($novaSenha, PASSWORD_DEFAULT);
        } else {
            $novaSenha = $usuario['senha'];
        }

        $atualizar = $conexao->prepare("UPDATE usuarios SET nome = ?,email = ?,telefone = ?,senha = ? WHERE id = ? AND id <> 1");
        $atualizar->bind_param("ssssi",$novoNome,$novoEmail,$novoTelefone,$novaSenha,$id_usuario);

        if (!$atualizar->execute()) {
            throw new Exception("Erro de atualização");
        }

        if ($atualizar->affected_rows === 0) {
            throw new Exception("Erro de atualização");
        }
        
        $atualizar->close();

        $conexao->commit();

        echo"<script>
        alert('Usuário atualizado com sucesso!');
        window.location.href = '../admin/aInicio.php';
        </script>";

    } else {
        $conexao->rollback();

        echo"<script>
        alert('Usuário não encontrado.');
        window.location.href = '../admin/aInicio.php';
        </script>";

    exit();

    }
    


} catch (\Throwable $th) {
    $conexao->rollback();

    error_log("Erro ao atulizar: " . $th ->getMessage());
    // echo("Erro ao atulizar: " . $th ->getMessage());

    echo"<script>
    alert('Erro ao atualizar usuário.Tente novamente mais tarde');
    window.location.href = '../admin/aInicio.php';
    </script>";

exit();
}
$conexao->close();