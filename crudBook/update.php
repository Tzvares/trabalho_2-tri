<h1>Editar livro</h1>

<?php
require_once '../Source/admin.php';
$sql = "SELECT * FROM livros";
$result = mysqli_query($conexao, $sql);
$hasLivros = mysqli_num_rows($result) > 0;
?>


<?php if ($hasLivros): ?>
  <form method="post" enctype="multipart/form-data">
    <label for="titulo">Selecione o livro:</label>
    <select name="titulo" id="titulo">
      <?php while ($livro = mysqli_fetch_assoc($result)): ?>
        <option value="<?php echo $livro['titulo']; ?>"><?php echo $livro['titulo']; ?></option>
      <?php endwhile; ?>
    </select>
    <br>
    <label for="novo_titulo">Novo título:</label>
    <input type="text" name="novo_titulo" id="novo_titulo">
    <br>
    <label for="autor">Autor:</label>
    <input type="text" name="autor" id="autor">
    <br>
    <label for="ano">Ano:</label>
    <input type="text" name="ano" id="ano">
    <br>
    <label for="foto">Foto de capa:</label>
    <input type="file" name="foto" id="foto">
    <br>
    <input type="submit" value="Atualizar">
  </form>

  <?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST["titulo"];
    $novo_titulo = $_POST["novo_titulo"];
    $autor = $_POST["autor"];
    $ano = $_POST["ano"];

    // Define o foto antes que ele seja selecionado
    if (isset($_FILES["foto"])) {
      $foto = $_FILES["foto"];
      $target_dir = "../uploads/";
      $target_file = $target_dir . basename($foto["name"]);

      if (move_uploaded_file($foto["tmp_name"], $target_file)) {
        $sql = "UPDATE livros SET titulo = '$novo_titulo', autor = '$autor', ano = '$ano', foto = '$target_file' WHERE titulo = '$titulo'";
        $result = mysqli_query($conexao, $sql);

        if ($result) {
          echo "Livro atualizado com sucesso!";
        } else {
          echo "Erro ao atualizar livro: " . mysqli_error($conexao);
        }
      }
    } else {
      $sql = "UPDATE livros SET titulo = '$novo_titulo', autor = '$autor', ano = '$ano' WHERE titulo = '$titulo'";
      $result = mysqli_query($conexao, $sql);

      if ($result) {
        echo "Livro atualizado com sucesso!";
      } else {
        echo "Erro ao atualizar livro: " . mysqli_error($conexao);
      }
    }
  }
?>
<?php else: ?>
  <p>Nenhum livro cadastrado.</p>
<?php endif;?>

<p><a href='../Source/index.php'>Voltar à página inicial</a></p>