<link rel="stylesheet" href="styleAutor.css?v=<?php echo time(); ?>">
<div class="container">
<?php
require_once '../Source/admin.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];

    $nome = mysqli_real_escape_string($conexao, $nome);

    // Verificar se o nome do autor já existe
    $sql_check = "SELECT COUNT(*) AS count FROM autores WHERE nome = '$nome'";
    $result_check = mysqli_query($conexao, $sql_check);
    $row_check = mysqli_fetch_assoc($result_check);

    if ($row_check['count'] > 0) {
        echo "<p>O autor '$nome' já existe!</p>";
    } else {
        $sql = "INSERT INTO autores (nome) VALUES ('$nome')";
        if (mysqli_query($conexao, $sql)) {
            echo "<p>Autor cadastrado com sucesso!</p>";
        } else {
            echo "<p>Erro ao cadastrar autor: " . mysqli_error($conexao) . "</p>";
        }
    }
} else {
    ?>
    <h1>Cadastrar novo autor</h1>
    <form method="post">
        <label for="titulo">Nome do autor:</label>
        <input type="text" id="nome" name="nome"><br><br>
        <input type="submit" value="Cadastrar">
    </form>
    <?php
}
echo "<p><a href='../Source/index.php'>Voltar à página inicial</a></p>";
?>
</div>