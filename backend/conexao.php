<?php

$host = "localhost";
$user = "root";
$pass = "";
$db = "teste";
$port = 3306;

/** @var mysqli $conexao */
$conexao = mysqli_connect($host,$user,$pass,$db,$port);

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); 

if (!$conexao) {
    error_log("Erro de conexão: " . mysqli_connect_error());
    exit();
} //else {
// echo"S";
// }


?>