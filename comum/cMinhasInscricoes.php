<?php
session_start();
include("../backend/functions.php");

if (!isset($_SESSION['email'])) {
    session_destroy();
    header("Location: /teste/index.php");
    exit();
}

if (!isset($_SESSION['tipo']) || ($_SESSION['tipo']) !== 'comum') {
    session_destroy();
    header("Location: /teste/index.php");
    exit();
}
?>
<!DOCTYPE html>

<head>
    <html lang="pt-BR">
    <meta name="description" content="Página Minha Inscrições do teste">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Inscrições - Teste</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="shortcut icon" href="../assets/img/gerenciamento-de-projetos.png" type="image/x-icon">
</head>

<body>
    <header>

        <nav class="navbar navbar-expand-lg shadow-sm rounded-bottom-4">
            <div class="container-fluid">

                <div class="d-flex flex-column">
                    <h1>Minhas Inscrições</h1>
                    <h2 class="h3"><?= htmlspecialchars("Bem vindo(a) " . $_SESSION['nome'] . ".") ?></h2>
                </div>

                <button class="btn-icon navbar-toggler p-1" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Botão de navegação">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse text-center" id="navbar">

                    <ul class="navbar-nav ms-auto d-flex justify-content-end">

                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="cInicio.php">Início</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="cMinhasInscricoes.php">Minhas Inscrições</a>
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
        <div class="container  table-responsive border rounded mt-5">
            <table class="table table-hover">
                <thead class="">
                    <tr>
                        <th scope="col">Título do Evento</th>
                        <th scope="col">Data do Evento</th>
                        <th scope="col">Descrição</th>
                        <th scope="col">Data de inscrição</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    $inscricoes = getMinhasInscricoes();

                    if (empty($inscricoes)) {

                    ?>
                        <tr>
                            <td colspan="6" class="text-center">Nenhuma inscrição encontrada.</td>
                        </tr>

                        <?php
                    } else {

                        foreach ($inscricoes as $inscricao) {

                        ?>
                            <tr>
                                <td><?= htmlspecialchars($inscricao['titulo']) ?></td>
                                <td><?= htmlspecialchars($inscricao['data_evento']) ?></td>
                                <td><?= htmlspecialchars($inscricao['descricao']) ?></td>
                                <td><?= htmlspecialchars($inscricao['data_inscricao']) ?></td>
                                <td>
                                        <form action="../backend/excluirMinhaInscricao.php" method="post" onsubmit="return confirm('Deseja realmente excluir essa inscrição?');">

                                            <input type="hidden" name="id_inscricao" value="<?= htmlspecialchars((int) $inscricao['i_id']) ?>">

                                            <button type="submit" class="btn btn-danger w-100">Excluir</button>
                                        </form>
                                </td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/script.js"></script>
</body>

</html>