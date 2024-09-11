<link rel="stylesheet" href="styleBook.css?v=<?php echo time(); ?>">
<div class="container">
<?php
require_once '../Source/admin.php';

// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST["titulo"];
    $autor = $_POST["autor"];
    $ano = $_POST["ano"];
    $foto = $_FILES["foto"];

    $erros = array();
    
    if (empty($titulo)) {
        $erros[] = "Título do livro é obrigatório";
    }
    if (empty($ano)) {
        $erros[] = "Ano do livro é obrigatório";
    }
    if (!isset($foto) || $foto["size"] == 0) {
        $erros[] = "Foto de capa é obrigatória";
    }

    // Verifica se o autor existe
    if (empty($autor)) {
        $erros[] = "Autor é obrigatório";
    } else {
        $autor = mysqli_real_escape_string($conexao, $autor);
        $sql_autor = "SELECT id_autor FROM autores WHERE nome = '$autor'";
        $result_autor = mysqli_query($conexao, $sql_autor);

        if (!$result_autor || mysqli_num_rows($result_autor) == 0) {
            $erros[] = "Autor não encontrado.";
        }
    }

    if (count($erros) > 0) {
        echo "<p>Erro:</p><ul>";
        foreach ($erros as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";
    } else {
        $titulo = mysqli_real_escape_string($conexao, $titulo);
        $ano = mysqli_real_escape_string($conexao, $ano);
        $autor = mysqli_real_escape_string($conexao, $autor);

        // Adicionar no upload aa foto
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($foto["name"]);

        if (move_uploaded_file($foto["tmp_name"], $target_file)) {
            // Inserir o livro na tabela
            $sql_livro = "INSERT INTO livros (titulo, autor, ano, foto) VALUES ('$titulo', '$autor', '$ano', '$target_file')";
            if (mysqli_query($conexao, $sql_livro)) {
                echo "<p>Livro cadastrado com sucesso!</p>";
            } else {
                echo "<p>Erro ao cadastrar livro: " . mysqli_error($conexao) . "</p>";
            }
        } else {
            echo "<p>Erro ao fazer upload da foto.</p>";
        }
    }
} else {
    ?>
    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Cadastrar Novo Livro</title>
        <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    </head>
    <body>
        <h1>Cadastrar Novo Livro</h1>
        <form method="post" enctype="multipart/form-data"> 
            <label for="autor">Autor do Livro:</label>
            <select id="autor" name="autor" required>
                <option value="">Selecione um autor</option>
                <?php
                $sql = "SELECT nome FROM autores";
                $result = mysqli_query($conexao, $sql);
                if (!$result) {
                    echo "<p>Erro: " . mysqli_error($conexao) . "</p>";
                } else {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='" . htmlspecialchars($row['nome'], ENT_QUOTES, 'UTF-8') . "'>" . htmlspecialchars($row['nome'], ENT_QUOTES, 'UTF-8') . "</option>";
                    }
                }
                ?>
            </select><br><br>
            <label for="titulo">Título do Livro:</label>
            <input type="text" id="titulo" name="titulo" required><br><br>
            <label for="ano">Ano do Livro:</label>
            <input type="date" id="ano" name="ano" required><br><br>
            <label for="foto">Foto de Capa:</label>
            <input type="file" id="foto" name="foto" required><br><br>
            <input type="submit" value="Cadastrar">
        </form>
        <p><a href='../Source/index.php'>Voltar à página inicial</a></p>
    </body>
    </html>
    <?php
}
?>

</div>