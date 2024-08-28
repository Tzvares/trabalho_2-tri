<!DOCTYPE html>
<html>
<head>
    <title>Sistema de Biblioteca</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Sistema de Biblioteca</h1>
    <form action="create.php" method="post">
        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo"><br><br>
        <label for="autor">Autor:</label>
        <input type="text" id="autor" name="autor"><br><br>
        <label for="ano">Ano:</label>
        <input type="number" id="ano" name="ano"><br><br>
        <input type="submit" value="Criar Livro">
    </form>
    <h2>Livros Cadastrados:</h2>
    <ul id="livros">
        <?php
            require_once 'read.php';
            $livros = readLivros($conexão);
            foreach ($livros as $livro) {
                echo "<li>$livro[titulo] - $livro[autor] ($livro[ano]) <a href='update.php?id=$livro[id]'>Editar</a> | <a href='delete.php?id=$livro[id]'>Excluir</a></li>";
            }
        ?>
    </ul>

    <script src="script.js"></script>
</body>
</html>