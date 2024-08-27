<?php
require_once 'admin.php';

$query = "SELECT * FROM livros";
$result = mysqli_query($conexao, $query);

$livros = array();
while ($row = mysqli_fetch_assoc($result)) {
    $livros[] = $row;
}

return $livros;
?>