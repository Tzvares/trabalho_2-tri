<link rel="stylesheet" href="styleAutor.css?v=<?php echo time(); ?>">
<div class="container">
<h1>Editar livro</h1>

<?php
require_once '../Source/admin.php';
$sql = "SELECT * FROM autores";
$result = mysqli_query($conexao, $sql);
$hasAutores = mysqli_num_rows($result) > 0;
?>

<?php 
// Verifica se há autores cadastrados e esconde as opções caso não haja
if ($hasAutores): ?>
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
    <label for="novo_nome">Novo nome:</label>
    <input type="text" name="novo_nome" id="novo_nome">
    <br>
    <input type="submit" value="Editar">
  </form>

  <?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $novo_nome = $_POST["novo_nome"];

    $sql = "UPDATE autores SET nome = '$novo_nome' WHERE nome = '$nome'";
    $result = mysqli_query($conexao, $sql);

    if ($result) {
      echo "Autor atualizado com sucesso!";
    } else {
      echo "Erro ao atualizar autor: " . mysqli_error($conexao);
    }
  }
  ?>
<?php else: ?>
  <p>Nenhum autor cadastrado.</p>
<?php endif;?>

<p><a href='../Source/index.php'>Voltar à página inicial</a></p>
</div>