<?php 
require'config.php';

$id = $_GET['id'];
$sql = "DELETE FROM usuarios WHERE id=$id";

if ($conn->query($sql)===true){
header("Location: gerenciarmusers.php");
}else{
    echo "Erro: " .$conn->error;
}

?>
