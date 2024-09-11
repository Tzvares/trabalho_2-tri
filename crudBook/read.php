<link rel="stylesheet" href="styleBook.css?v=<?php echo time(); ?>">
<div class="container">
<?php
require_once '../Source/admin.php';

$sql = "SELECT * FROM livros";
$result = mysqli_query($conexao, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<h1>Livros cadastrados</h1>";
    echo "<ul>";
    while($row = mysqli_fetch_assoc($result)) {
        echo "<li><img src='" . $row["foto"] . "' alt='Foto do livro' width='50' height='50'> Titulo: " . $row["titulo"] . " - Autor: " . $row["autor"] . " - Ano: " . $row["ano"] . "</li>";
    }
    echo "</ul>";
} else {
    echo "<p>Nenhum livro cadastrado.</p>";
}

echo "<p><a href='../Source/index.php'>Voltar à página inicial</a></p>";

?>
</div>