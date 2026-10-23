<?php
session_start();
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
<head>
    <html lang="pt-BR">
    <meta name="description" content="Página inicial do painel administrador">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Início - Administrador</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="shortcut icon" href="../assets/img/gerenciamento-de-projetos.png" type="image/x-icon">
</head>

<body>
    <header>

        <nav class="navbar navbar-expand-lg shadow-sm rounded-bottom-4">
            <div class="container-fluid">

                <div class="d-flex flex-column">
                    <h1>Início/Usuários</h1>
                    <h2 class="h3"><?= htmlspecialchars("Bem vindo(a) " . $_SESSION['nome'] . ".") ?></h2>
                </div>

                <button class="btn-icon navbar-toggler p-1" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Botão de navegação">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse text-center" id="navbar">

                    <ul class="navbar-nav ms-auto d-flex justify-content-end">

                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="aInicio.php">Início</a>
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
        <div class="container  table-responsive border rounded mt-5">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Nome</th>
                        <th scope="col">Email</th>
                        <th scope="col">Telefone</th>
                        <th scope="col">Tipo</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    $usuarios = getUsuarios();

                    if (empty($usuarios)) {

                    ?>
                        <tr>
                            <td colspan="5" class="text-center">Nenhum usuário encontrado.</td>
                        </tr>

                        <?php
                    } else {

                        foreach ($usuarios as $usuario) {

                        ?>
                            <tr>
                                <td><?= htmlspecialchars($usuario['nome']) ?></td>
                                <td><?= htmlspecialchars($usuario['email']) ?></td>
                                <td><?= htmlspecialchars($usuario['telefone']) ?></td>
                                <td><?= htmlspecialchars($usuario['tipo']) ?></td>
                                <td>
                                    <div class="d-flex flex-column gap-2">

                                        <form action="aEditarUsuario.php" method="post">
                                            <input type="hidden" name="id_usuario" value="<?= htmlspecialchars((int) $usuario['id']) ?>">

                                            <button type="submit" class="btn btn btn-warning w-100">
                                                Editar
                                            </button>
                                        </form>

                                        <form action="../backend/excluirUsuario.php" method="post" onsubmit="return confirm('Deseja realmente excluir esse usuário?');">

                                            <input type="hidden" name="id_usuario" value="<?= htmlspecialchars((int) $usuario['id']) ?>">

                                            <button type="submit" class="btn btn-danger w-100">Excluir</button>
                                        </form>
                                    </div>
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