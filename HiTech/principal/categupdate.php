<?php
require 'config.php';

$id = $_POST['id'];
$nome = $_POST['nome'];

$sql = "UPDATE categorias SET 
        nome = '$nome'
        WHERE id = $id";

if($conn->query($sql) === TRUE){
    header("Location: categuser.php");
} else {
    echo "Erro: " . $conn->error;
}
?>