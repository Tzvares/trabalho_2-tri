<?php
require_once 'admin.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST["titulo"];
    $autor = $_POST["autor"];
    $id = $_POST["id"];
    $ano = $_POST["ano"];

    $titulo = mysqli_real_escape_string($conexao, $titulo);
    $autor = mysqli_real_escape_string($conexao, $autor);

    $sql = "INSERT INTO livros (id, titulo, autor, ano) VALUES ('$id', '$titulo', '$autor', '$ano')";
    mysqli_query($conexao, $sql);

    echo "<p>Livro cadastrado com sucesso!</p>";
    echo "<p><a href='index.php'>Voltar à página inicial</a></p>";
} else {
    ?>
    <h1>Cadastrar novo livro</h1>
    <form method="post">
        <label for="titulo">titulo do livro:</label>
        <input type="text" id="titulo" name="titulo"><br><br>
        <label for="autor">Autor do livro:</label>
        <input type="text" id="autor" name="autor"><br><br>
        <label for="id">ID do livro:</label>
        <input type="number" id="id" name="id"><br><br>
        <label for="ano">Ano do livro:</label>
        <input type="number" id="ano" name="ano"><br><br>
        <input type="submit" value="Cadastrar">
    </form>
    <?php
}
?>