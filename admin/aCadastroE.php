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
    <meta name="description" content="Página de cadastro de eventos do painel administrador">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Eventos - Administrador</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="shortcut icon" href="../assets/img/gerenciamento-de-projetos.png" type="image/x-icon">
</head>

<body>
    <header>

        <nav class="navbar navbar-expand-lg shadow-sm rounded-bottom-4">
            <div class="container-fluid">


                <div class="d-flex flex-column">
                    <h1>Cadastro de Eventos</h1>
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
                            <a class="nav-link active" href="aEventos.php">Eventos</a>
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
        <form action="../backend/cadastroEvento.php" class="form d-flex justify-content-center my-5" method="post">

            <fieldset>
                <legend class="fw-semibold">Formulário de Cadastro de eventos</legend>

                <div class="my-3">
                    <label for="titulo" class="form-label">Título:</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" required placeholder="Digite o Título do evento aqui.">
                </div>

                <div class="mb-3">
                    <label for="descricao" class="form-label">Descrição:</label>
                    <textarea name="descricao" id="descricao" class="form-control" rows="5" required placeholder="Digite a descrição do evento aqui."></textarea>
                </div>

                <div class="mb-3">
                    <label for="vagas" class="form-label">Vagas:</label>
                    <input type="number" class="form-control" id="vagas" name="vagas" required placeholder="Digite a quantidade de vagas disponíveis aqui.">
                </div>

                <div class="mb-3">
                    <label for="data_evento" class="form-label">Data do Evento:</label>
                    <input type="datetime-local" name="data_evento" class="form-control" id="data_evento" required placeholder="Digite a data do evento aqui.">
                </div>

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