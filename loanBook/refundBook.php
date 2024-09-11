<?php
require_once '../Source/admin.php';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "biblioteca";

$conexao = mysqli_connect($servername, $username, $password, $dbname);

if (!$conexao) {
    die("Erro ao conectar ao servidor MySQL: " . mysqli_connect_error());
}

// Variável para armazenar a lista de livros
$livros = [];

// Busca todos os livros da base de dados
$livro_query = "SELECT id_livro, titulo FROM livros";
$resultado = mysqli_query($conexao, $livro_query);

if ($resultado) {
    while ($row = mysqli_fetch_assoc($resultado)) {
        $livros[] = $row;
    }
} else {
    echo "Erro ao buscar livros: " . mysqli_error($conexao);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = mysqli_real_escape_string($conexao, $_POST["titulo"] ?? '');
    $data_devolucao = mysqli_real_escape_string($conexao, $_POST["data_devolucao"] ?? '');

    // Verifica se a data de devolução é válida
    if (empty($data_devolucao)) {
        echo "Data de devolução é obrigatória.";
        echo "<p><a href='../Source/index.php'>Voltar à página inicial</a></p>";
        exit();
    }

    // Busca ID do livro com base no título
    $id_livro_query = "SELECT id_livro FROM livros WHERE titulo = '$titulo'";
    $resultado_id_livro = mysqli_query($conexao, $id_livro_query);
    $id_livro = null;

    if ($resultado_id_livro && $row_id_livro = mysqli_fetch_assoc($resultado_id_livro)) {
        $id_livro = $row_id_livro['id_livro'];
    } else {
        echo "Livro não encontrado.";
        mysqli_close($conexao);
        exit();
    }

    // Verifica se o livro está emprestado e obter o empréstimo correspondente
    $verificar_emprestimo_query = "
        SELECT id_emprestimo, data_emprestimo
        FROM emprestimos
        WHERE fk_id_livro = $id_livro
          AND data_devolucao IS NULL
    ";
    $resultado_verificar = mysqli_query($conexao, $verificar_emprestimo_query);
    $emprestimo_id = null;
    $data_emprestimo = null;

    if ($resultado_verificar && $row_verificar = mysqli_fetch_assoc($resultado_verificar)) {
        $emprestimo_id = $row_verificar['id_emprestimo'];
        $data_emprestimo = $row_verificar['data_emprestimo'];
    } else {
        echo "O livro não está emprestado ou não há um empréstimo ativo para este livro.";
        mysqli_close($conexao);
        exit();
    }

    // Verifica se a data de devolução não é anterior a data de empréstimo
    if ($data_devolucao < $data_emprestimo) {
        echo "A data de devolução não pode ser anterior à data de empréstimo.";
        mysqli_close($conexao);
        exit();
    }

    // Atualizar a data de devolução
    $sql = "UPDATE emprestimos 
            SET data_devolucao = '$data_devolucao'
            WHERE id_emprestimo = $emprestimo_id";

    if (mysqli_query($conexao, $sql)) {
        echo "Devolução registrada com sucesso!";
    } else {
        echo "Erro ao registrar a devolução: " . mysqli_error($conexao);
    }
}

mysqli_close($conexao);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Devolução de Livro</title>
</head>
<body>
    <h1>Devolução de Livro</h1>
    <form action="refundBook.php" method="post">
        <label for="titulo">Título do Livro:</label>
        <select id="titulo" name="titulo" required>
            <option value="">Selecione um livro</option>
            <?php foreach ($livros as $livro): ?>
                <option value="<?php echo htmlspecialchars($livro['titulo'], ENT_QUOTES, 'UTF-8'); ?>">
                    <?php echo htmlspecialchars($livro['titulo'], ENT_QUOTES, 'UTF-8'); ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="data_devolucao">Data de Devolução:</label>
        <input type="date" id="data_devolucao" name="data_devolucao" required><br><br>

        <input type="submit" value="Devolver">
    </form>
</body>
</html>

<p><a href='../Source/index.php'>Voltar à página inicial</a></p>
