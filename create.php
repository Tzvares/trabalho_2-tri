<?php
require_once 'admin.php';

$titulo = $_POST['titulo'];
$autor = $_POST['autor'];
$ano = $_POST['ano'];

$query = "INSERT INTO livros (titulo, autor, ano) VALUES ('$titulo', '$autor', '$ano')";
mysqli_query($conexao, $query);

header('Location: index.html');
?>