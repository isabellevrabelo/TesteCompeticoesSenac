<?php
session_start();
require_once("conexao.php");

$email = $_POST['email'];
$senha = $_POST['senha'];

$consulta = $conexao->prepare("SELECT * FROM usuarios WHERE email = ?");
$consulta->bind_param("s",$email);

if (!$consulta->execute()) {

    error_log("Erro ao consultar: " . $consulta->error);
    
    echo "<script>
            alert('Erro inesperado.Tente novamente mais tarde!');
            window.location.href = '../index.php';
        </script>";
    exit();
}

$resultado = $consulta->get_result();
// echo $resultado->num_rows;
$consulta->close();

if ($resultado->num_rows === 1) {
    
    $dados = $resultado->fetch_assoc();
    
    if (password_verify($senha,$dados['senha'])) {

        $_SESSION['id'] = $dados['id'];
        $_SESSION['nome'] = $dados['nome'];
        $_SESSION['email'] = $dados['email'];
        $_SESSION['telefone'] = $dados['telefone'];
        $_SESSION['tipo'] = $dados['tipo'];

        switch ($dados['tipo']) {
            case 'admin':
                header("Location: ../admin/aInicio.php");
                break;

                case 'organizador':
                    header("Location: ../organizador/oInicio.php");
                    break;

                    case 'comum':
                        header("Location: ../comum/cInicio.php");
                        break;
            default:
                
                echo "<script>
                alert('Usuário inválido.Cadastre-se novamente');
                window.location.href = '../cadastro.php';
                </script>";

                break;
        }
    
        
    } else {

        echo "<script>
        alert('Senha incorreta.');
        window.location.href = '../index.php';
        </script>";

    exit();
    }
    
} else {
    
        echo "<script>
        alert('Usuário não encontrado.');
        window.location.href = '../index.php';
        </script>";

    exit();

}
$conexao->close();
