<?php 
require'config.php';

$id = $_GET['id'];
$sql = "DELETE FROM produtos WHERE id=$id";

if ($conn->query($sql)===true){
header("Location: listapro_usuario.php");
}else{
    echo "Erro: " .$conn->error;
}

?>