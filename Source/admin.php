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
    die("Erro ao conectar ao banco de dados: " . mysqli_connect_error());
}
?>