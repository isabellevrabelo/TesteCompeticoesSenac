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

$id_evento = (int) $_POST['id_evento'];
$consulta = $conexao->prepare("SELECT * FROM eventos WHERE id = ?");
$consulta->bind_param("i",$id_evento);

if (!$consulta->execute()) {

    echo"<script>
    alert('Erro inesperado.Tente novamente mais tarde.');
    window.location.href = 'aEventos.php';
    </script>";
    exit();
}

$resultado = $consulta->get_result();
$consulta->close();

$evento = $resultado->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta name="description" content="Página de edição de eventos do painel administrador">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Início - Administrador</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="shortcut icon" href="../assets/img/gerenciamento-de-projetos.png" type="image/x-icon">
</head>

<body>
    <header>

        <nav class="navbar navbar-expand-lg shadow-sm rounded-bottom-4">
            <div class="container-fluid">

                <div class="d-flex flex-column">
                    <h1>Edição de Eventos</h1>
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
        <form action="../backend/editarEvento.php" class="form d-flex justify-content-center my-5" method="post">

            <input type="hidden" name="id_evento" value="<?= htmlspecialchars($evento['id'])?>">
        <fieldset>

            <legend class="fw-semibold">Formulário de Edição do evento:</legend>
                <span class="fw-bold fs-4 text-success"><?= htmlspecialchars($evento['titulo'])?></span>

            <div class="my-3">
                    <label for="titulo" class="form-label">Título:</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Digite o novo o título do evento para editar."
                    value="<?= htmlspecialchars($evento['titulo']) ?>">
                </div>

                <div class="mb-3">
                    <label for="descricao" class="form-label">Descrição:</label>
                    <textarea name="descricao" id="descricao"
                    class="form-control" rows="5" placeholder="Digite a nova descrição do evento para editar."><?= htmlspecialchars($evento['descricao']) ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="vagas" class="form-label">Vagas:</label>
                    <input type="number" class="form-control" id="vagas" name="vagas" placeholder="Digite a nova quantidade de vagas disponíveis para editar." 
                    value="<?=(string) htmlspecialchars($evento['vagas']) ?>">
                </div>

                <div class="mb-3">
                    <label for="data_evento" class="form-label">Data do Evento:</label>
                    <input type="datetime-local" name="data_evento" class="form-control" id="data_evento" placeholder="Digite a nova data do evento para editar."
                    value="<?= htmlspecialchars($evento['data_evento']) ?>">
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