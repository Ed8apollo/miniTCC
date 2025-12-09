<?php
require 'config.php';


if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nome = trim($_POST['nome']);
    
    if(!empty($nome)) {
        $sql = "UPDATE categorias SET nome = '$nome' WHERE id = $id";
        
        if($conn->query($sql) === TRUE){
            header("Location: telacategadmin.php");
            exit();
        } else {
            $erro = "Erro ao atualizar categoria: " . $conn->error;
        }
    } else {
        $erro = "O nome da categoria é obrigatório!";
    }
}


if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM categorias WHERE id=$id";
    $result = $conn->query($sql);
    
    if($result->num_rows > 0) {
        $categoria = $result->fetch_assoc();
    } else {
        header("Location: telacategadmin.php");
        exit();
    }
} else {
    header("Location: telacategadmin.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <!--<link rel="stylesheet" href="css/edit.css"> -->
    <title>Editar Categoria - Estoque HiTech</title>
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
    max-width: 1000px;
    display: flex;
}
.welcome-section {
    background: linear-gradient(135deg, #2842b6, #752da5);
    color: white;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    flex: 1;           
    height: 500px;   
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
                        <h3 class="mb-3">Editar Categoria</h3>
                        <p class="mb-0">Atualize as informações da categoria</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-7">
                <div class="menu-section">
                    <h3 class="text-center mb-4 text-dark">Editar Dados da Categoria</h3>
                    
                    <?php if(isset($erro)): ?>
                        <div class="alert alert-danger text-center">
                            <?php echo $erro; ?>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST" action="">
                        <input type="hidden" name="id" value="<?= $categoria['id'] ?>">
                        
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Nome da Categoria</label>
                                <input type="text" name="nome" value="<?= $categoria['nome'] ?>" 
                                    class="form-control mb-3" placeholder="Nome da Categoria" required>
                            </div>
                            
                            <div class="col-12 mt-4">
                                <button type="submit" class="menu-btn btn-lg">
                                    Salvar Alterações
                                </button>
                            </div>
                        </div>
                    </form>
                    
                    <div class="row g-3 mt-4">
                        <div class="col-12 text-center mt-3">
                            <a href="telacategadmin.php" class="btn btn-outline-secondary">
                            ← Voltar à Lista de Categorias
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