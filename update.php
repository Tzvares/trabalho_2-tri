<h1>Editar livro</h1>
<form method="post">
    <label for="id">Selecione o livro:</label>
    <select name="id" id="id">
        <?php
        require_once 'admin.php';
        $sql = "SELECT * FROM livros";
        $result = mysqli_query($conexao, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row["id"] . "'>" . $row["titulo"] . " - " . $row["autor"] . " - " . $row["ano"] . "</option>";
            }
        } else {
            echo "<option value=''>Nenhum livro cadastrado.</option>";
        }
        ?>
    </select>
    <br>
    <label for="titulo">Título:</label>
    <input type="text" name="titulo" id="titulo">
    <br>
    <label for="autor">Autor:</label>
    <input type="text" name="autor" id="autor">
    <br>
    <label for="ano">Ano:</label>
    <input type="text" name="ano" id="ano">
    <br>
    <input type="submit" value="Atualizar">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $titulo = $_POST["titulo"];
    $autor = $_POST["autor"];
    $ano = $_POST["ano"];

    $sql = "UPDATE livros SET titulo = '$titulo', autor = '$autor', ano = '$ano' WHERE id = '$id'";
    $result = mysqli_query($conexao, $sql);

    if ($result) {
        echo "Livro atualizado com sucesso!";
    } else {
        echo "Erro ao atualizar livro: " . mysqli_error($conexao);
    }
}

echo "<p><a href='index.php'>Voltar à página inicial</a></p>";

?>
