<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca - Trucou</title> <?php // ve ai um nome ?>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="container">
            <h1>Biblioteca Trucou</h1>
        <?php
        require_once 'admin.php';
        echo  "<p>Livros: </p>";
        echo "<p><a href='../crudBook/create.php'>Cadastrar novo livro</a></p>";
        echo "<p><a href='../crudBook/read.php'>Ver todos os livros</a></p>";
        echo "<p><a href='../crudBook/delete.php'>Deletar livro</a></p>";
        echo "<p><a href='../crudBook/update.php'>Editar livro</a></p>";
        echo "<br></br>";
        echo "<p>Autores: </p>";
        echo "<p><a href='../crudAutor/createAutor.php'>Cadastrar autor</a></p>";
        echo "<p><a href='../crudAutor/readAutor.php'>Listar autores</a></p>";
        echo "<p><a href='../crudAutor/deleteAutor.php'>Deletar autor</a></p>";
        echo "<p><a href='../crudAutor/updateAutor.php'>Editar autor</a></p>";
        ?>
    </div>
</body>
</html>


