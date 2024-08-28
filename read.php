<?php
require_once 'admin.php';

$query = "SELECT * FROM livros";
$result = mysqli_query($conexao, $query);

$livros = array();
while ($row = mysqli_fetch_assoc($result)) {
    $livros[] = $row;
}


//ler livros

return $livros;

function readLivros($conexao) {
    $sql = "SELECT * FROM livros";
    $result = mysqli_query($conexao, $sql);

    // Verificar se há result
    if (mysqli_num_rows($result) > 0) {
        // Ler result
        while($row = mysqli_fetch_assoc($result)) {
            $livros[] = $row;
        }
    } else {
        $livros = array();
    }

    // Fechar conexão
    mysqli_close($conexao);

    // Retornar array de livros
    return $livros;
}
?>