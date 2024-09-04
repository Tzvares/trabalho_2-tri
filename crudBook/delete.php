<?php
require_once '../Source/admin.php';

$sql = "SELECT * FROM livros";
$result = mysqli_query($conexao, $sql);
$hasLivros = mysqli_num_rows($result) > 0; // Evita a utilização se não há livros cadastrados
?>

<?php if ($hasLivros): ?>
  <h1>Deletar livro</h1>
  <form method="post">
    <label for="titulo">Selecione o livro:</label>
    <select name="titulo" id="titulo">
  <?php
  while ($row = mysqli_fetch_assoc($result)) {
    echo "<option value='" . $row["titulo"] . "'>" . $row["titulo"] . " - " . $row["autor"] . " - " . $row["ano"] . "</option>";
  }
  ?>
</select>
    <br>
    <input type="submit" value="Deletar">
  </form>

  <?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST["titulo"];

    $sql = "DELETE FROM livros WHERE titulo = '$titulo'";
    $result = mysqli_query($conexao, $sql);

    if ($result) {
      echo "<p>Livro deletado com sucesso!</p>";
    } else {
      echo "Erro ao deletar livro: " . mysqli_error($conexao);
    }
  }
  ?>
<?php else: ?>
  <p>Nenhum livro cadastrado.</p>
<?php endif;?>

<p><a href='../Source/index.php'>Voltar à página inicial</a></p>