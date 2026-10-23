<?php
session_start();
require_once("../backend/conexao.php");
include("../backend/functions.php");

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

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta name="description" content="Página de cadastro de usuário do painel administrador">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário - Administrador</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="shortcut icon" href="../assets/img/gerenciamento-de-projetos.png" type="image/x-icon">
</head>

<body>
    <header>

        <nav class="navbar navbar-expand-lg shadow-sm rounded-bottom-4">
            <div class="container-fluid">


                <div class="d-flex flex-column">
                    <h1>Cadastro de Usuário</h1>
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
                            <a class="nav-link active" href="aCadastroU.php">Cadastrar Usuário</a>
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
        <form action="../backend/cadastrarUsuario.php" class="form d-flex justify-content-center my-5" method="post">

            <fieldset>
                <legend class="fw-semibold">Formulário de Cadastro de usuários</legend>

                <div class="my-3">
                    <label for="nome" class="form-label">Nome Completo:</label>
                    <input type="text" class="form-control" id="nome" name="nome" required placeholder="Digite o nome completo para usuário aqui.">
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" required placeholder="Digite o email para usuário aqui.">
                </div>

                <div class="mb-3">
                    <label for="telefone" class="form-label">Telefone:</label>
                    <input type="tel" class="form-control" id="telefone" name="telefone" required placeholder="Digite o telefone para usuário aqui.">
                </div>

                
                <div class="mb-3">
                    <label for="senha" class="form-label">Senha:</label>
                    <input type="password" class="form-control" id="senha" name="senha" required placeholder="Digite a senha para usuário aqui.">
                </div>

                <div class="mb-3">
                    <label for="tipo" class="form-label">Tipo do usuário:</label>
                    <select name="tipo" id="tipo" class="form-select">
                        <option value="admin">Administrador</option>
                        <option value="organizador">Organizador</option>
                        <option value="comum">comum</option>
                    </select>

                <div class="text-center d-flex flex-column align-items-center">
                    <button type="submit" class="btn btn-primary w-30 my-3">Enviar</button>
                    <a href="aEventos.php">Voltar</a>
                </div>

            </fieldset>
        </form>
    </main>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/script.js"></script>
</body>

</html>