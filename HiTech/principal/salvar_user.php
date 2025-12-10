<?php
session_start();
require 'config.php';

$nome = $_POST['nome'];
$preco = $_POST['preco'];
$quantidade = $_POST['quantidade'];
$descricao = $_POST['descricao'];
$categoria_id = $_POST['categoria_id']; 

$sql = "INSERT INTO produtos (nome, preco, quantidade, descricao, categorias) 
        VALUES ('$nome', '$preco', '$quantidade', '$descricao', '$categoria_id')";

if($conn->query($sql) === TRUE){
    header("Location: listapro_usuario.php");
} else {
    echo "Erro: " . $conn->error;
}

?>