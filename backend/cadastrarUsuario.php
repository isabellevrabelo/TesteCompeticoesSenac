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


$nome = $_POST['nome'];
$email = $_POST['email'];
$telefone = $_POST['telefone'];
$senha = $_POST['senha'];
$senhaHash = password_hash($senha,PASSWORD_DEFAULT);
$tipo = $_POST['tipo'];


$conexao->begin_transaction();

try {
    
    $envio = $conexao->prepare("INSERT INTO usuarios(nome,email,telefone,senha,tipo) VALUES(?,?,?,?,?)");
    $envio->bind_param("sssss",$nome,$email,$telefone,$senhaHash,$tipo);

    $envio->execute();
    $conexao->commit();

    echo"<script>
    alert('Usuário cadastrado com sucesso!');
    window.location.href = '../admin/aInicio.php';
    </script>";

    exit();

} catch (mysqli_sql_exception $e) {
    
    $conexao->rollback();

    if ($e->getCode() === 1062) {
        
        echo"<script>
            alert('Email já cadastrado.');
            window.location.href = '../admin/aCadastroU.php';
        </script>";
        exit();

    } else {

        error_log("Erro ao inserir: " . $e->getMessage());
        // echo("Erro ao inserir: " . $e->getCode());
        echo "<script>
                alert('Erro ao cadastrar usuário. Tente novamente mais tarde.');
                window.location.href = '../admin/aCadastroU.php';
            </script>";
        exit();

    }

}
