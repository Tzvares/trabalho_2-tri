<?php
// Configurações de conexão do banco de dados
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'biblioteca';

// Conexão com o banco de dados
$conexao = new mysqli($host, $username, $password, $dbname);

// Verificar conexão
if ($conexao->connect_error) {
    die("Erro de conexão: " . $conexao->connect_error);
}
?>