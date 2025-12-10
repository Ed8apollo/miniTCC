<?php
session_start();
require 'config.php';

$email = $_POST['email'];
$senha_digitada = $_POST['senha'];


$sql = "SELECT * FROM usuarios WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {

    $usuario = $result->fetch_assoc();
    $hash_no_banco = $usuario['senha'];

    $senha_confere = false;

 
    if (password_verify($senha_digitada, $hash_no_banco)) {
        $senha_confere = true;
    }

 
    elseif (md5($senha_digitada) === $hash_no_banco) {

        
        $novo_hash = password_hash($senha_digitada, PASSWORD_DEFAULT);

        $sqlUp = "UPDATE usuarios SET senha = ? WHERE id = ?";
        $stmt2 = $conn->prepare($sqlUp);
        $stmt2->bind_param("si", $novo_hash, $usuario['id']);
        $stmt2->execute();
        $stmt2->close();

        $senha_confere = true;
    }

  
    if ($senha_confere) {

        $_SESSION['logado'] = true;
        $_SESSION['id'] = $usuario['id'];
        $_SESSION['nome'] = $usuario['nome'];
        $_SESSION['nivel'] = $usuario['nivel'];
        $_SESSION['foto'] = $usuario['foto'];

        if ($usuario['nivel'] == 'admin') {
            header("Location: painel_admin.php");
        } else {
            header("Location: painel_usuario.php");
        }
        exit;
    }

}

// Se não encontrou ou senha não bateu
$_SESSION['erro'] = "Usuário ou senha inválidos!";
header("Location: login.php");
exit;
?>