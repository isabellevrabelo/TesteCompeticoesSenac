<?php
require_once("conexao.php");

$nome = $_POST['nome'];
$email = $_POST['email'];
$telefone = $_POST['telefone'];
$senha = $_POST['senha'];
$senhaHash = password_hash($senha,PASSWORD_DEFAULT);

// $envio = $conexao->prepare("INSERT INTO usuarios(nome,email,telefone,senha) VALUES(?,?,?,?)");
// $envio->bind_param("ssss",$nome,$email,$telefone,$senhaHash);

// if ($envio->execute()) {

//     echo"<script>
//     alert('Usuário cadastrado com sucesso!');
//     window.location.href = '../index.php';
//     </script>";

//     exit();
// } else {

//     if ($envio->errno === 1062) {
//         echo"<script>
//         alert('Email já cadastrado.');
//         window.location.href = '../index.php';
//         </script>";
    
//         exit();
//     } else {
//         error_log("Erro ao inserir: " . $envio->error);

//         echo"<script>
//         alert('Erro ao cadastrar usuário.Tente novamente mais tarde.!);
//         window.location.href = '../cadastro.php';
//         </script>";
    
//         exit();
//     }
// }

// $envio->close();
// $conexao->close();

$conexao->begin_transaction();

try {
    
    $envio = $conexao->prepare("INSERT INTO usuarios(nome,email,telefone,senha) VALUES(?,?,?,?)");
    $envio->bind_param("ssss",$nome,$email,$telefone,$senhaHash);

    $envio->execute();
    $conexao->commit();

    echo"<script>
    alert('Usuário cadastrado com sucesso!');
    window.location.href = '../index.php';
    </script>";

    exit();

} catch (mysqli_sql_exception $e) {
    
    $conexao->rollback();

    if ($e->getCode() === 1062) {
        
        echo"<script>
            alert('Email já cadastrado.');
            window.location.href = '../index.php';
        </script>";
        exit();

    } else {

        error_log("Erro ao inserir: " . $e->getMessage());
        // echo("Erro ao inserir: " . $e->getCode());
        echo "<script>
                alert('Erro ao cadastrar usuário. Tente novamente mais tarde.');
                window.location.href = '../index.php';
            </script>";
        exit();

    }

}
