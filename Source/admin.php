<?php
require_once '../Source/admin.php';

// Conexão com o servidor
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "biblioteca";

// Criar conexão
$conexao = mysqli_connect($servername, $username, $password, $dbname);

// Verificar conexão
if (!$conexao) {
    die("Erro ao conectar ao servidor MySQL: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST["titulo"] ?? null;

    if ($titulo !== null) {
        $titulo = mysqli_real_escape_string($conexao, $titulo);
    }
}
?>