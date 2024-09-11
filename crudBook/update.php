<link rel="stylesheet" href="styleBook.css?v=<?php echo time(); ?>">
<div class="container">
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
    <label for="autor">Selecione o autor:</label>
    <select id="autor" name="autor">
        <?php
        $sql = "SELECT id_autor, nome FROM autores";
        $result = mysqli_query($conexao, $sql);
        if (!$result) {
            echo "<p>Error: " . mysqli_error($conexao) . "</p>";
        } else {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row['nome'] . "'>" . $row['nome'] . "</option>";
            }
        }
        ?>
    </select><br>
    <label for="ano">Ano:</label>
    <input type="date" name="ano" id="ano">
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
    $foto = $_FILES["foto"];

    $erros = array();
    if (empty($novo_titulo)) {
        $erros[] = "Novo título do livro é obrigatório";
    }
    if (empty($ano)) {
        $erros[] = "Ano do livro é obrigatório";
    }
    if (!isset($foto) || $foto["size"] == 0) {
        $erros[] = "Foto de capa é obrigatória";
    }

    if (count($erros) > 0) {
        echo "<p>Erro: </p><ul>";
        foreach ($erros as $erro) {
            echo "<li>$erro</li>";
        }
        echo "</ul>";
    } else {
        // Checa se o autor já existe
        $sql_check_autor = "SELECT * FROM livros WHERE autor = '$autor'";
        $result_check_autor = mysqli_query($conexao, $sql_check_autor);
        $tem_autor = mysqli_num_rows($result_check_autor) > 0;

        if ($tem_autor) {
            $sql_update = "UPDATE livros SET titulo = '$novo_titulo', ano = '$ano'";
        } else {
            $sql_update = "UPDATE livros SET titulo = '$novo_titulo', autor = '$autor', ano = '$ano'";
        }

        // Define a foto antes de seleciona-la
        if (isset($_FILES["foto"])) {
            $foto = $_FILES["foto"];
            $target_dir = "../uploads/";
            $target_file = $target_dir . basename($foto["name"]);

            if (move_uploaded_file($foto["tmp_name"], $target_file)) {
                $sql_update .= ", foto = '$target_file'";
            }
        }

        $sql_update .= " WHERE titulo = '$titulo'";
        $result = mysqli_query($conexao, $sql_update);

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
</div>