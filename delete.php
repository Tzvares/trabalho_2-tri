<?php
require_once 'admin.php';

$id = $_GET['id'];

$query = "DELETE FROM livros WHERE id = '$id'";
mysqli_query($conexao, $query);

header('Location: index.html');
?>