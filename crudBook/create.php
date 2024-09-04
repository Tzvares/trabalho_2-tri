<?php
require_once '../Source/admin.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST["titulo"];
    $autor = $_POST["autor"];
    $ano = $_POST["ano"];
    $foto = $_FILES["foto"];

    $titulo = mysqli_real_escape_string($conexao, $titulo);
    $autor = mysqli_real_escape_string($conexao, $autor);

    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($foto["name"]);

    if (move_uploaded_file($foto["tmp_name"], $target_file)) {
        $sql = "INSERT INTO livros (titulo, autor, ano, foto) VALUES ('$titulo', '$autor', '$ano', '$target_file')";
        mysqli_query($conexao, $sql);
        echo "<p>Livro cadastrado com sucesso!</p>";
    } else {
        echo "<p>Erro ao cadastrar livro.</p>";
    }
} else {
    ?>
    <h1>Cadastrar novo livro</h1>
    <form method="post" enctype="multipart/form-data"> <?php //Enctype serve para o envio de imagens, videos e audios ?>
        <label for="titulo">Título do livro:</label>
        <input type="text" id="titulo" name="titulo"><br><br>
        <label for="autor">Autor do livro:</label>
        <input type="text" id="autor" name="autor"><br><br>
        <label for="ano">Ano do livro:</label>
        <input type="number" id="ano" name="ano"><br><br>
        <label for="foto">Foto de capa:</label>
        <input type="file" id="foto" name="foto"><br><br>
        <input type="submit" value="Cadastrar">
    </form>
    <?php
}
echo "<p><a href='../Source/index.php'>Voltar à página inicial</a></p>";
?>