<?php
session_start();
require 'config.php';


if (!isset($_SESSION['logado']) || $_SESSION['nivel'] != 'admin') {
    header("Location: login.php");
    exit;
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
    if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
        $_SESSION['msg'] = "ID do usuário inválido!";
        header("Location: gerenciarmusers.php");
        exit;
    }
    
    $id = intval($_POST['id']);
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $nivel = $_POST['nivel'];
    $nova_senha = $_POST['nova_senha'] ?? '';
    
    
    if (empty($nome) || empty($email) || empty($nivel)) {
        $_SESSION['msg'] = "Por favor, preencha todos os campos obrigatórios!";
        header("Location: edituser.php?id=" . $id);
        exit;
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['msg'] = "E-mail inválido!";
        header("Location: edituser.php?id=" . $id);
        exit;
    }
    
    if (!in_array($nivel, ['usuario', 'admin'])) {
        $_SESSION['msg'] = "Nível de acesso inválido!";
        header("Location: edituser.php?id=" . $id);
        exit;
    }
    
    try {
        
        $sql_check = "SELECT id FROM usuarios WHERE email = ? AND id != ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("si", $email, $id);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
        
        if ($result_check->num_rows > 0) {
            $_SESSION['msg'] = "Este e-mail já está sendo usado por outro usuário!";
            header("Location: edituser.php?id=" . $id);
            exit;
        }
        
        
        

        
        if ($stmt->execute()) {
            $_SESSION['msg'] = "Usuário atualizado com sucesso!";
            
            
            
            if ($_SESSION['id'] == $id) {
                $_SESSION['nome'] = $nome;
                $_SESSION['email'] = $email;
                $_SESSION['nivel'] = $nivel;
            }
        } else {
            $_SESSION['msg'] = "Erro ao atualizar usuário: " . $conn->error;
        }
        
    } catch (Exception $e) {
        $_SESSION['msg'] = "Erro: " . $e->getMessage();
    }
    
    
    header("Location: edituser.php?id=" . $id);
    exit;
    
} else {
    
    header("Location: gerenciarmusers.php");
    exit;
}
?>