<?php
$conexao = mysqli_connect("localhost", "seu_usuario", "sua_senha", "seu_banco_de_dados");

if (!$conexao) {
    die("Erro ao conectar ao banco de dados: " . mysqli_connect_error());
}
?>