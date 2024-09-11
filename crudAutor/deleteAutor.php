<link rel="stylesheet" href="styleAutor.css?v=<?php echo time(); ?>">
<div class="container">
<?php
require_once '../Source/admin.php';

// Conexão com o servidor
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "biblioteca";

$conexao = mysqli_connect($servername, $username, $password, $dbname);

if (!$conexao) {
    die("Erro ao conectar ao servidor MySQL: " . mysqli_connect_error());
}

// Busca todos os autores da base de dados
$sql = "SELECT id_autor, nome FROM autores";
$result = mysqli_query($conexao, $sql);
$hasAutores = mysqli_num_rows($result) > 0;
?>

<?php if ($hasAutores): ?>
  <h1>Deletar Autor</h1>
  <form method="post">
    <label for="autor">Selecione o autor:</label>
    <select name="autor" id="autor">
      <?php
      while ($row = mysqli_fetch_assoc($result)) {
        echo "<option value='" . htmlspecialchars($row["id_autor"], ENT_QUOTES, 'UTF-8') . "'>" . htmlspecialchars($row["nome"], ENT_QUOTES, 'UTF-8') . "</option>";
      }
      ?>
    </select>
    <br>
    <input type="submit" value="Deletar">
  </form>

  <?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_autor = mysqli_real_escape_string($conexao, $_POST["autor"]);

    // Busca o nome do autor selecionado
    $nome_autor_query = "SELECT nome FROM autores WHERE id_autor = '$id_autor'";
    $resultado_nome_autor = mysqli_query($conexao, $nome_autor_query);
    $nome_autor = null;

    if ($resultado_nome_autor && $row_nome_autor = mysqli_fetch_assoc($resultado_nome_autor)) {
        $nome_autor = $row_nome_autor['nome'];
    } else {
        echo "Autor não encontrado.";
        mysqli_close($conexao);
        exit();
    }

    // Verifica se o autor tem livros emprestados
    $verificar_livros_emprestados_query = "
        SELECT COUNT(*) AS total
        FROM livros
        WHERE autor = '$nome_autor' 
          AND id_livro IN (SELECT fk_id_livro FROM emprestimos WHERE data_devolucao IS NULL)
    ";
    $resultado_verificar = mysqli_query($conexao, $verificar_livros_emprestados_query);
    $livros_emprestados = false;

    if ($resultado_verificar && $row_verificar = mysqli_fetch_assoc($resultado_verificar)) {
        if ($row_verificar['total'] > 0) {
            $livros_emprestados = true;
        }
    }

    if ($livros_emprestados) {
        echo "<p>O autor não pode ser deletado porque há livros emprestados associados a ele.</p>";
    } else {
        // Deletar o autor
        $sql = "DELETE FROM autores WHERE id_autor = '$id_autor'";
        if (mysqli_query($conexao, $sql)) {
            echo "<p>Autor deletado com sucesso!</p>";
        } else {
            echo "<p>Erro ao deletar o autor: " . mysqli_error($conexao) . "</p>";
        }
    }
  }
  ?>

<?php else: ?>
  <p>Nenhum autor cadastrado.</p>
<?php endif;?>

<p><a href='../Source/index.php'>Voltar à página inicial</a></p>

<?php
mysqli_close($conexao);
?>
