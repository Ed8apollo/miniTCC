<?php 
require 'config.php';


if(!isset($_GET['id'])) {
    header("Location: telacategadmin.php");
    exit();
}

$id = $_GET['id'];


$sql_nome = "SELECT nome FROM categorias WHERE id = $id";
$result_nome = $conn->query($sql_nome);
$categoria_nome = "";
if($result_nome->num_rows > 0) {
    $row_nome = $result_nome->fetch_assoc();
    $categoria_nome = $row_nome['nome'];
}


$check_sql = "SELECT COUNT(*) as total FROM produtos WHERE categorias = $id";
$check_result = $conn->query($check_sql);
$row = $check_result->fetch_assoc();

if($row['total'] > 0) {

    $error_msg = urlencode("Não é possível excluir a categoria '$categoria_nome' pois existem {$row['total']} produto(s) vinculado(s) a ela.");
    header("Location: telacategadmin.php?error=" . $error_msg);
    exit();
}


$sql = "DELETE FROM categorias WHERE id = $id";

if ($conn->query($sql) === true){

    $success_msg = urlencode("Categoria '$categoria_nome' excluída com sucesso!");
    header("Location: telacategadmin.php?success=" . $success_msg);
    exit();
} else {
    $error_msg = urlencode("Erro ao excluir categoria: " . $conn->error);
    header("Location: telacategadmin.php?error=" . $error_msg);
    exit();
}
?>