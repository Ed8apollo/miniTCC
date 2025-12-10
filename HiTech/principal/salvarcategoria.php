<?php
require 'config.php';

$nome= $_POST['nome'];


$sql = "INSERT INTO categorias(nome) VALUES ('$nome')";
if($conn->query($sql)===TRUE){
    header("Location:categorias.php");
}else{
    echo "Erro:" . $conn->error;
}