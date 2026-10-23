<?php
session_start();
include("../backend/functions.php");
require_once("../backend/conexao.php");

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

$id_usuario = (int) $_POST['id_usuario'];
$consulta = $conexao->prepare("SELECT * FROM usuarios WHERE id = ?");
$consulta->bind_param("i",$id_usuario);

if (!$consulta->execute()) {

    echo"<script>
    alert('Erro inesperado.Tente novamente mais tarde.');
    window.location.href = 'aInicio.php';
    </script>";
    exit();
}

$resultado = $consulta->get_result();
$consulta->close();

$usuario = $resultado->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta name="description" content="Página de edição de usuário do painel administrador">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edição de Usuário - Administrador</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="shortcut icon" href="../assets/img/gerenciamento-de-projetos.png" type="image/x-icon">
</head>

<body>
    <header>

        <nav class="navbar navbar-expand-lg shadow-sm rounded-bottom-4">
            <div class="container-fluid">

                <div class="d-flex flex-column">
                    <h1>Edição de Usuário</h1>
                    <h2 class="h3"><?= htmlspecialchars("Bem vindo(a) " . $_SESSION['nome'] . ".") ?></h2>
                </div>

                <button class="btn-icon navbar-toggler p-1" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Botão de navegação">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse text-center" id="navbar">

                    <ul class="navbar-nav ms-auto d-flex justify-content-end">

                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="aInicio.php">Início</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="aEventos.php">Eventos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="aCadastroU.php">Cadastrar Usuário</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="aInscricoes.php">Inscrições</a>
                        </li>
                        <li class="nav-item">
                            <button id="btn-tema" class="btn btn-secondary">Tema</button>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../backend/sair.php">Sair</a>
                        </li>

                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main>
        <form action="../backend/editarUsuario.php" class="form d-flex justify-content-center my-5" method="post">
            <input type="hidden" name="id_usuario" value="<?= htmlspecialchars($usuario['id'])?>">
        <fieldset>

            <legend class="fw-semibold">Formulário de Edição do usuário:</legend>

                <span class="fw-bold fs-4 text-success"><?= htmlspecialchars($usuario['nome'])?></span>

            <div class="my-3">
                    <label for="nome" class="form-label">Nome Completo:</label>
                    <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite o novo nome completo aqui para editar."
                    value="<?= htmlspecialchars($usuario['nome']) ?>">
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Digite o novo email aqui para editar." 
                    value="<?= htmlspecialchars($usuario['email']) ?>">
                </div>

                <div class="mb-3">
                    <label for="telefone" class="form-label">Telefone:</label>
                    <input type="tel" class="form-control" id="telefone" name="telefone" placeholder="Digite o novo número de telefone aqui para editar." 
                    value="<?= htmlspecialchars($usuario['telefone']) ?>">
                </div>

                <div class="mb-3">
                    <label for="senha" class="form-label">Senha:</label>
                    <input type="password" class="form-control" id="senha" name="senha" placeholder="Deixe vazio para manter a senha atual.">
                </div>

                <div class="text-center d-flex flex-column align-items-center">
                    <button type="submit" class="btn btn-primary w-30 my-3">Enviar</button>
                    <a href="aInicio.php">Voltar</a>
                </div>
                
            </fieldset>
        </form>
    </main>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/script.js"></script>
</body>
</html>