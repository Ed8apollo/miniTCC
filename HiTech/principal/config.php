<?php
$servidor = 'localhost';
$usuario = 'root';
$senha = '';
$banco = 'estoquehitech';

$conn = new mysqli($servidor, $usuario, $senha,$banco);

if ($conn -> connect_error){
    die("falha de conexão: ".$conn_>connect_error);
}
?>