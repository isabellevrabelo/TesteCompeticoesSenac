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
    <meta name="description" content="Página inicial do teste">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Início - Teste</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="shortcut icon" href="../assets/img/gerenciamento-de-projetos.png" type="image/x-icon">
</head>

<body>
    <header>

        <nav class="navbar navbar-expand-lg shadow-sm rounded-bottom-4">
            <div class="container-fluid">

                <div class="d-flex flex-column">
                    <h1>Início/Eventos</h1>
                    <h2 class="h3"><?= htmlspecialchars("Bem vindo(a) " . $_SESSION['nome'] . ".") ?></h2>
                </div>

                <button class="btn-icon navbar-toggler p-1" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Botão de navegação">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse text-center" id="navbar">

                    <ul class="navbar-nav ms-auto d-flex justify-content-end">

                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="cInicio.php">Início</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="cMinhasInscricoes.php">Minhas Inscrições</a>
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
    <div class="container table-responsive border rounded mt-5">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Título</th>
                    <th scope="col">Descrição</th>
                    <th scope="col">Vagas Disponíveis</th>
                    <th scope="col">Data do Evento</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $eventos = getEventos();

                if (empty($eventos)) {
                ?>
                    <tr>
                        <td colspan="5" class="text-center">
                            Nenhum evento encontrado.
                        </td>
                    </tr>
                <?php
                } else {
                    foreach ($eventos as $evento) {
                        $vagasEsgotadas = (int) $evento['vagas'] <= 0;
                ?>
                        <tr>
                            <td>
                                <?= htmlspecialchars($evento['titulo']) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($evento['descricao']) ?>
                            </td>

                            <td>
                                <?php if ($vagasEsgotadas) { ?>
                                    <span class="text-danger fw-bold">
                                        Vagas esgotadas
                                    </span>
                                <?php } else { ?>
                                    <?= (int) $evento['vagas'] ?>
                                <?php } ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($evento['data_evento']) ?>
                            </td>

                            <td>
                                <?php if ($vagasEsgotadas) { ?>

                                    <span class="text-danger d-inline-flex align-items-center gap-1"
                                          title="Não há vagas disponíveis">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             width="20"
                                             height="20"
                                             fill="currentColor"
                                             class="bi bi-slash-circle-fill"
                                             viewBox="0 0 16 16"
                                             aria-hidden="true">

                                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0ZM4.646 4.646a.5.5 0 0 0 0 .708l6 6a.5.5 0 0 0 .708-.708l-6-6a.5.5 0 0 0-.708 0Z"/>
                                        </svg>

                                        <span class="fw-bold">Esgotado</span>
                                    </span>

                                <?php } else { ?>

                                    <form action="../backend/salvarInscricao.php"
                                          method="post">

                                        <input type="hidden"
                                               name="id_evento"
                                               value="<?= (int) $evento['id'] ?>">

                                        <button type="submit"
                                                class="btn btn-success w-100">
                                            Inscrever-se
                                        </button>

                                    </form>

                                <?php } ?>
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