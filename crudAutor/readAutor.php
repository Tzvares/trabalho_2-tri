<?php
require_once '../Source/admin.php';

$sql = "SELECT * FROM autores";
$result = mysqli_query($conexao, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<h1>Autores cadastrados</h1>";
    echo "<ul>";
    while($row = mysqli_fetch_assoc($result)) {
        echo "<li>Nome: " . $row["nome"];
    }
    echo "</ul>";
} else {
    echo "<p>Nenhum autor cadastrado.</p>";
}

echo "<p><a href='../Source/index.php'>Voltar à página inicial</a></p>";

?>