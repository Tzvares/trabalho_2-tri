<?php
require_once 'admin.php';

$id = $_GET['id'];
$titulo = $_POST['titulo'];
$autor = $_POST['autor'];
$ano = $_POST['ano'];

$query = "UPDATE livros SET titulo = '$titulo', autor = '$autor', ano = '$ano' WHERE id = '$id'";
mysqli_query($conexao, $query);

header('Location: index.html');
?>