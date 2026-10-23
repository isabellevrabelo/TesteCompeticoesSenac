<?php
session_start();
require_once("conexao.php");

if (!isset($_SESSION['id'], $_SESSION['email'], $_SESSION['tipo'])) {
    header("Location: /teste/index.php");
    exit();
}

if (!in_array($_SESSION['tipo'], ['admin', 'organizador'], true)) {
    header("Location: /teste/index.php");
    exit();
}


if ($_SESSION['tipo'] === 'admin') {
    $url = "../admin/aEventos.php";
} else {
    $url = "../organizador/oEventos.php";
}

$id_evento = $_POST['id_evento'];

try {

    $conexao->begin_transaction();

    $consulta = $conexao->prepare(
        "SELECT id FROM eventos WHERE id = ?"
    );

    $consulta->bind_param("i", $id_evento);
    $consulta->execute();

    $resultado = $consulta->get_result();

    if ($resultado->num_rows === 0) {
        $consulta->close();
        throw new Exception("evento_nao_encontrado");
    }

    $consulta->close();

    $consulta = $conexao->prepare(
        "SELECT id FROM inscricoes WHERE id_evento = ?"
    );

    $consulta->bind_param("i", $id_evento);
    $consulta->execute();

    $resultado = $consulta->get_result();
    $possuiInscricoes = $resultado->num_rows > 0;

    $consulta->close();

    if ($possuiInscricoes) {
        throw new Exception("evento_com_inscricoes");
    }

    $excluir = $conexao->prepare(
        "DELETE FROM eventos WHERE id = ?"
    );

    $excluir->bind_param("i", $id_evento);
    $excluir->execute();

    if ($excluir->affected_rows !== 1) {
        $excluir->close();
        throw new Exception("evento_nao_excluido");
    }

    $excluir->close();

    $conexao->commit();

    echo "<script>
        alert('Evento excluído com sucesso!');
        window.location.href = " . json_encode($url) . ";
    </script>";

    exit();

} catch (Throwable $th) {

    try {
        $conexao->rollback();
    } catch (Throwable $erroRollback) {
        error_log("Erro no rollback: " . $erroRollback->getMessage());
    }

    if ($th->getMessage() === "evento_com_inscricoes") {

        $mensagem = "Esse evento possui inscrições. Não será possível excluí-lo.";

    } elseif ($th->getMessage() === "evento_nao_encontrado") {

        $mensagem = "Evento não encontrado.";

    } else {

        error_log(
            "Erro ao excluir evento: " . $th->getMessage()
        );

        $mensagem = "Erro inesperado. Tente novamente mais tarde.";
    }

    echo "<script>
        alert(" . json_encode($mensagem) . ");
        window.location.href = " . json_encode($url) . ";
    </script>";

    exit();

} finally {

    $conexao->close();

}
?>
