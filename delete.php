<?php
require_once 'admin.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST["titulo"];

    $sql = "DELETE FROM livros WHERE titulo = '$titulo'";
    mysqli_query($conexao, $sql);

    echo "<p>Livro deletado com sucesso!</p>";
} else {
    ?>
    <h1>Deletar livro</h1>
    <form method="post">
        <label for="titulo">Nome do livro:</label>
        <input type="text" id="titulo" name="titulo"><br><br>
        <input type="submit" value="Deletar">
    </form>
    <?php
}

echo "<p><a href='index.php'>Voltar à página inicial</a></p>";

?>