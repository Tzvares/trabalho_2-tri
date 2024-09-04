<?php
require_once '../Source/admin.php';
$sql = "SELECT * FROM autores";
$result = mysqli_query($conexao, $sql);
$hasAutores = mysqli_num_rows($result) > 0;
?>

<?php if ($hasAutores): ?>
  <h1>Deletar autor</h1>
  <form method="post">
    <label for="nome">Selecione o autor:</label>
    <select name="nome" id="nome">
  <?php
  while ($row = mysqli_fetch_assoc($result)) {
    echo "<option value='" . $row["nome"] . "'>" . $row["nome"] . "</option>";
  }
  ?>
</select>
    <br>
    <input type="submit" value="Deletar">
  </form>

  <?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];

    $sql = "DELETE FROM autores WHERE nome = '$nome'";
    mysqli_query($conexao, $sql);

    echo "<p>Autor deletado com sucesso!</p>";
  }
  ?>
<?php else: ?>
  <p>Nenhum autor cadastrado.</p>
<?php endif;?>

<p><a href='../Source/index.php'>Voltar à página inicial</a></p>