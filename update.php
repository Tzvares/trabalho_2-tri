<h1>Editar livro</h1>
    <form method="post">
        <label for="titulo">
<?php
require_once 'admin.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $titulo = $_POST["titulo"];
    $autor = $_POST["autor"];
    $ano = $_POST["ano"];

    $sql = "UPDATE livros SET titulo = '$titulo', autor = '$autor', ano = '$ano' WHERE id = '$id'";
    mysqli_query($conexao, $sql);

    echo "<p>Livro atualizado com sucesso!</p>";
    echo "<p><a href='index.php'>Voltar à página inicial</a></p>";
} else {
    $id = $_GET["id"];
    $sql = "SELECT * FROM livros WHERE id = '$id'";
    $result = mysqli_query($conexao, $sql);
    $row = mysqli_fetch_assoc($result);
}
    ?>
   