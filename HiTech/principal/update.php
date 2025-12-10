<?php
require 'config.php';

$id = $_POST['id'];
$nome = $_POST['nome'];
$preco = $_POST['preco'];
$quantidade = $_POST['quantidade'];
$descricao = $_POST['descricao'];
$categoria_id = $_POST['categoria_id']; 

$sql = "UPDATE produtos SET 
        nome = '$nome', 
        preco = '$preco', 
        quantidade = '$quantidade', 
        descricao = '$descricao',
        categorias = '$categoria_id'  
        WHERE id = $id";

if($conn->query($sql) === TRUE){
    header("Location: index.php");
} else {
    echo "Erro: " . $conn->error;
}
?>