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

// Busca todos os empréstimos
$sql = "
    SELECT e.id_emprestimo, e.nome_pessoa, e.email_pessoa, l.titulo, e.data_emprestimo, e.data_devolucao
    FROM emprestimos e
    JOIN livros l ON e.fk_id_livro = l.id_livro
    ORDER BY e.data_emprestimo DESC
";
$resultado = mysqli_query($conexao, $sql);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Listar Empréstimos</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Lista de Empréstimos</h1>

    <?php if (mysqli_num_rows($resultado) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID Empréstimo</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Título do Livro</th>
                    <th>Data de Empréstimo</th>
                    <th>Data de Devolução</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($resultado)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id_emprestimo'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($row['nome_pessoa'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($row['email_pessoa'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($row['titulo'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($row['data_emprestimo'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($row['data_devolucao'] ?? 'Não devolvido', ENT_QUOTES, 'UTF-8'); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Não há empréstimos registrados.</p>
    <?php endif; ?>

    <p><a href='../Source/index.php'>Voltar à página inicial</a></p>

<?php
mysqli_close($conexao);
?>
</body>
</html>
