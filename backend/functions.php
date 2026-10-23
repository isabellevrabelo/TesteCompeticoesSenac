<?php
require_once("conexao.php");

function getUsuarios() {
    global $conexao;

    $sql = "SELECT id,nome,email,telefone,tipo FROM usuarios WHERE id <> 1 AND email <> 'admin@gmail.com'";
    $envio = $conexao->query($sql);

    $usuarios = [];

    while ($linha = $envio->fetch_assoc()) {
        $usuarios[] = $linha;
    }

    return $usuarios;
}

function getEventos() {
    global $conexao;

    $sql = "SELECT *, DATE_FORMAT(eventos.data_evento, ' %d/%m/%Y %H:%i') AS data_evento FROM eventos";
    $envio = $conexao->query($sql);

    $eventos = [];

    while ($linha = $envio->fetch_assoc()) {
        $eventos[] = $linha;
    }

    return $eventos;
}

function getInscricoes() {
    global $conexao;

    $sql = "SELECT usuarios.id AS u_id,
                    usuarios.nome,
                    usuarios.email,
                    eventos.id AS e_id,
                    eventos.titulo,
                    DATE_FORMAT(eventos.data_evento, '%d/%m/%Y %H:%i') AS data_evento,
                    inscricoes.id AS i_id,
                    DATE_FORMAT(inscricoes.data_inscricao, '%d/%m/%Y %H:%i') AS data_inscricao
            FROM inscricoes
            INNER JOIN eventos
                ON eventos.id = inscricoes.id_evento
            INNER JOIN usuarios
                ON usuarios.id = inscricoes.id_usuario";

    $envio = $conexao->query($sql);

    $inscricoes = [];

    while ($linha = $envio->fetch_assoc()) {
        $inscricoes[] = $linha;
    }
    return $inscricoes;
}

function getMinhasInscricoes() {

    global $conexao;

    $id_usuario = $_SESSION['id'];

    $consulta = $conexao->prepare("SELECT eventos.id AS e_id,
                                            eventos.titulo,
                                            DATE_FORMAT(eventos.data_evento, '%d/%m/%Y %H:%i') AS data_evento,
                                            eventos.descricao,
                                            inscricoes.id AS i_id,
                                            DATE_FORMAT(inscricoes.data_inscricao, '%d/%m/%Y %H:%i') AS data_inscricao
                                FROM inscricoes
                                INNER JOIN eventos
                                    ON eventos.id = inscricoes.id_evento
                                WHERE inscricoes.id_usuario = ?");
    $consulta->bind_param("i",$id_usuario);

    if (!$consulta->execute()) {
        echo"<script>
        alert('Erro inesperado.Tente novamente mais tarde.');
        window.location.href = '../comum/cInicio.php';
        </script>";

        exit();
    }

    $inscricoes = [];

    $resultado = $consulta->get_result();

    $consulta->close();

    while ($linha = $resultado->fetch_assoc()) {
        $inscricoes[] = $linha;
    }

    return $inscricoes;

}

?>