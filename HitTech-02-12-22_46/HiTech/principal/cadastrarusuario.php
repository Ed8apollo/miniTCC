<?php
session_start();
require 'config.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = md5($_POST['senha']);
    

    $sql = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', '$senha')";
    if ($conn->query($sql)) {
        $msg = "Usuário cadastrado com sucesso!";
    } else {
        $msg = "Erro ao cadastrar: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Usuário - Estoque HiTech</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }
        .main-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            overflow: hidden;
            width: 90%;
            max-width: 1000px;
        }
        .welcome-section {
            background: linear-gradient(135deg, #2842b6, #752da5);
            color: white;
            padding: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            height: 100%;
        }
        .form-section {
            padding: 50px;
        }
        .menu-btn {
            background: linear-gradient(135deg, #2842b6, #752da5);
            border: none;
            color: white;
            padding: 12px 25px;
            border-radius: 12px;
            transition: all 0.3s ease;
            text-align: center;
            text-decoration: none;
            display: block;
            width: 100%;
        }
        .menu-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            color: white;
        }
        .form-control, .form-select {
            border-radius: 10px;
            padding: 12px;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }
        .form-control:focus, .form-select:focus {
            border-color: #2842b6;
            box-shadow: 0 0 0 0.2rem rgba(40, 66, 182, 0.25);
        }
        .alert {
            border-radius: 10px;
            border: none;
        }
    </style>
</head>
<body>
    <div class="main-card">
        <div class="row g-0">
      
            <div class="col-md-5">
                <div class="welcome-section">
                    <div class="text-center">
                       
                        <h3 class="mb-3">Cadastrar Usuário</h3>
                        <p class="mb-0">Crie sua conta!</p>
                    </div>
                </div>
            </div>
            
            
            <div class="col-md-7">
                <div class="form-section">
                    <h4 class="text-center mb-4 text-dark">Dados do Usuário</h4>
                    
                    <form method="POST">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Nome Completo</label>
                                <input type="text" name="nome" class="form-control" 
                                    placeholder="Digite o nome completo" required>
                            </div>
                            
                            <div class="col-12">
                                <label class="form-label">E-mail</label>
                                <input type="email" name="email" class="form-control" 
                                    placeholder="exemplo@email.com" required>
                            </div>
                            
                            <div class="col-12">
                                <label class="form-label">Senha</label>
                                <input type="password" name="senha" class="form-control" 
                                    placeholder="Digite uma senha segura" required>
                            </div>
                            
                            
                            <div class="col-12 mt-4">
                                <button type="submit" class="menu-btn btn-lg">
                                    Cadastrar-se
                                </button>
                            </div>
                            
                            <div class="col-12 text-center mt-3">
                                <a href="telainicial.php" class="btn btn-outline-secondary">
                                    ← Voltar ao Inicio
                                </a>
                            </div>
                        </div>
                    </form>
                    
                    <?php if(isset($msg)): ?>
                        <div class="alert alert-info text-center mt-3">
                            <?= $msg; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>