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
    $nome_pessoa = mysqli_real_escape_string($conexao, $_POST["nome_pessoa"] ?? '');
    $email_pessoa = mysqli_real_escape_string($conexao, $_POST["email_pessoa"] ?? '');
    $titulo = mysqli_real_escape_string($conexao, $_POST["titulo"] ?? '');
    $data_emprestimo = date('Y-m-d'); // Data atual
    $data_devolucao = $_POST["data_devolucao"] ?? '';

    // Verifica se a data de devolução é válida
    if ($data_devolucao < $data_emprestimo) {
        echo "A data de devolução não pode ser anterior à data de empréstimo.";
        echo "<p><a href='../Source/index.php'>Voltar à página inicial</a></p>";
        exit;
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

    // Verifica se o livro esta emprestado ou se o período solicitado ultrapassa um empréstimo que já existe
    $verificar_emprestimo_query = "
        SELECT COUNT(*) AS total
        FROM emprestimos
        WHERE fk_id_livro = $id_livro
          AND (data_devolucao IS NULL OR (data_emprestimo <= '$data_devolucao' AND data_devolucao >= '$data_emprestimo'))
    ";
    $resultado_verificar = mysqli_query($conexao, $verificar_emprestimo_query);
    $livro_emprestado = false;

    if ($resultado_verificar && $row_verificar = mysqli_fetch_assoc($resultado_verificar)) {
        if ($row_verificar['total'] > 0) {
            $livro_emprestado = true;
        }
    }

    // Verifica se todos os campos foram preenchidos
    if ($nome_pessoa && $email_pessoa && $id_livro) {
        if ($livro_emprestado) {
            echo "O livro já está emprestado e não pode ser emprestado novamente até a devolução.";
        } else {
            $sql = "INSERT INTO emprestimos (nome_pessoa, email_pessoa, data_emprestimo, data_devolucao, fk_id_livro) 
                    VALUES ('$nome_pessoa', '$email_pessoa', '$data_emprestimo', '$data_devolucao', $id_livro)";

            // Executar a consulta
            if (mysqli_query($conexao, $sql)) {
                echo "Empréstimo registrado com sucesso!";
            } else {
                echo "Erro ao registrar o empréstimo: " . mysqli_error($conexao);
            }
        }
    } else {
        echo "Por favor, preencha todos os campos corretamente.";
    }
}

mysqli_close($conexao);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Emprestar Livro</title>
</head>
<body>
    <h1>Emprestar Livro</h1>
    <form action="toloanBook.php" method="post">
        <label for="nome_pessoa">Nome:</label>
        <input type="text" id="nome_pessoa" name="nome_pessoa" required><br><br>

        <label for="email_pessoa">Email:</label>
        <input type="email" id="email_pessoa" name="email_pessoa" required><br><br>

        <label for="titulo">Título do Livro:</label>
        <select id="titulo" name="titulo" required>
            <option value="">Selecione um livro</option>
            <?php foreach ($livros as $livro): ?>
                <option value="<?php echo htmlspecialchars($livro['titulo'], ENT_NOQUOTES, 'UTF-8'); ?>">
                    <?php echo htmlspecialchars($livro['titulo'], ENT_NOQUOTES, 'UTF-8'); ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="data_devolucao">Data de Devolução:</label>
        <input type="date" id="data_devolucao" name="data_devolucao" required><br><br>

        <input type="submit" value="Emprestar">
    </form>
</body>
</html>

<p><a href='../Source/index.php'>Voltar à página inicial</a></p>