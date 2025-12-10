<?php
session_start();
require 'config.php';


if (!isset($_SESSION['logado']) || $_SESSION['nivel'] != 'admin') {
    header("Location: login.php");
    exit;
}


if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: gerenciarmusers.php");
    exit;
}

$id = intval($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
    $id = intval($_POST['id']);
    $nome = trim($_POST['nome']);
    $nivel = $_POST['nivel'];
    
  
    if (empty($nome) || empty($nivel)) {
        $msg = "<div class='alert alert-danger'>Por favor, preencha todos os campos!</div>";
    } else {
        
        $sql = "UPDATE usuarios SET nome = ?, nivel = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $nome, $nivel, $id);
        
        if ($stmt->execute()) {
            $msg = "<div class='alert alert-success'>Usuário atualizado com sucesso!</div>";
            
            
    }
    
    $id = $id;
}
}


$sql = "SELECT * FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header("Location: gerenciarmusers.php");
    exit;
}

$usuario = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuário - Estoque HiTech</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
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
    max-width: 1250px;
    height: 660px;
    display: flex;
}
.welcome-section {
    background: linear-gradient(135deg, #2842b6, #752da5);
    color: white;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 250px 235px;  
    flex: 1;           
    height: 660px;   
    min-width: 300px;   
    box-sizing: border-box;
}
.menu-section {
    padding: 40px;
    flex: 2;
    min-width: 350px;
    box-sizing: border-box;
}
.menu-btn {
    background: linear-gradient(135deg, #2842b6, #752da5);
    border: none;
    color: white;
    padding: 15px 25px;
    border-radius: 12px;
    transition: all 0.3s ease;
    margin: 10px 0;
    width: 100%;
    text-align: center;
    text-decoration: none;
    display: block;
}
.menu-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    color: white;
}
.stats-card {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 15px;
    margin: 10px 0;
    border-left: 4px solid #2842b6;
    display:flex
}
.table-container {
    background: #f8f9fa;
    border-radius: 15px;
    padding: 20px;
    margin: 20px 0;
    display: flex;
}
.btn-action {
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 0.85rem;
}
@media (max-width: 480px) {
    body {
        padding: 10px;
    }
    
    .main-card {
        width: 100%;
        border-radius: 15px;
    }
    
    .welcome-section {
        padding: 30px 15px;
        min-height: 250px;
    }
    
    .menu-section {
        padding: 20px;
    }
    
    .menu-btn {
        padding: 12px 20px;
    }
}
@media (min-width: 992px) {
    .welcome-section {
        padding: 60px;
    }
    
    .menu-section {
        padding: 50px;
    }
}
@media (min-width: 768px) {
    .main-card {
        flex-direction: row;
    }
    
    .welcome-section {
        flex: 1;
        min-height: 500px;
        padding: 40px;
    }
    
    .menu-section {
        flex: 1;
        padding: 40px;
    }
}
@media (min-width: 992px) {
    .welcome-section {
        padding: 60px;
    }
    
    .menu-section {
        padding: 50px;
    }
}
</style>
<body>
    <div class="main-card">
        <div class="row g-0">
            <div class="col-md-5">
                <div class="welcome-section">
                    <div class="text-center">
                        <h3 class="mb-3">Editar dados do Usuário</h3>
                        <p class="mb-0">Atualize as informações do Usuário</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-7">
                <div class="menu-section">
                    <h3 class="text-center mb-4 text-dark">Editar Dados do Usuário</h3>
                    
                
                    <?php if(isset($msg)) echo $msg; ?>
                    
                    
                    <form method="POST">
                        <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
                        
                        <div class="row g-3">
                            <div class="col-12">
                                <input type="text" name="nome" value="<?= htmlspecialchars($usuario['nome']) ?>" 
                                    class="form-control mb-3" placeholder="Nome do usuario" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Nível de Acesso</label>
                                <select name="nivel" class="form-select" required>
                                    <option value="">Selecione o nível de acesso</option>
                                    <option value="usuario" <?= ($usuario['nivel'] == 'usuario') ? 'selected' : '' ?>>Usuário</option>
                                    <option value="admin" <?= ($usuario['nivel'] == 'admin') ? 'selected' : '' ?>>Administrador</option>
                                </select>
                            </div>
                            
                            <div class="col-12 mt-4">
                                <button type="submit" class="menu-btn btn-lg">
                                    Salvar Alterações
                                </button>
                            </div>
                        </div>
                    </form>
                    
                    <br> <br> <br> <br>
                    
                    <div class="row g-3 mt-4">
                        <div class="col-12 text-center mt-3">
                            <a href="gerenciarmusers.php" class="btn btn-outline-secondary">
                                ← Voltar à Lista
                            </a>
                        </div>
                        <div class="col-12 text-center mt-3">
                            <a href="painel_admin.php" class="btn btn-outline-secondary">
                                ← Voltar para a tela do Administrador
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>