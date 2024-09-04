<?php
require_once 'admin.php';

echo "<h1>Biblioteca</h1>";
echo  "<p>livros</p>";
echo "<p><a href='../crudBook/create.php'>Cadastrar novo livro</a></p>";
echo "<p><a href='../crudBook/read.php'>Ver todos os livros</a></p>";
echo "<p><a href='../crudBook/delete.php'>Deletar livro</a></p>";
echo "<p><a href='../crudBook/update.php'>Editar livro</a></p>";
echo "<br></br>";
echo "<p>Autores</p>";
echo "<p><a href='../crudAutor/createAutor.php'>Cadastrar autor</a></p>";
echo "<p><a href='../crudAutor/readAutor.php'>Listar autores</a></p>";
echo "<p><a href='../crudAutor/deleteAutor.php'>Deletar autor</a></p>";
echo "<p><a href='../crudAutor/updateAutor.php'>Editar autor</a></p>";

?>