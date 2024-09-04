<?php
require_once 'admin.php';

$sql = "SELECT * FROM livros";
$result = mysqli_query($conexao, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<h1>Livros cadastrados</h1>";
    echo "<ul>";
    while($row = mysqli_fetch_assoc($result)) {
        echo "<li>ID: " . $row["id"] . " - Titulo: " . $row["titulo"] . " - Autor: " . $row["autor"] . " - Ano: " . $row["ano"] . "</li>";
    }
    echo "</ul>";
} else {
    echo "<p>Nenhum livro cadastrado.</p>";
}

echo "<p><a href='index.php'>Voltar à página inicial</a></p>";

?>