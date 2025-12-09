<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/categoria.css"> 
    <title>Cadastrar Produto - Estoque HiTech</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
    <div class="main-card">
        <div class="row g-0">
           
            <div class="col-md-5">
                <div class="welcome-section">
                    <div class="text-center">
                        
                        <h3 class="mb-3">Adicionar Categoria</h3>
                        <p class="mb-0">Adicione novas categorias </p>
                    </div>
                </div>
            </div>
            
           
            <div class="col-md-7">
                <div class="form-section">
                    <h4 class="text-center mb-4 text-dark">Preencha os dados</h4>
                    <br>
                                <br>
                    <form method="POST" action="salvarcategoria.php">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Nome da Categoria</label>
                                <input type="text" name="nome" class="form-control" 
                                    required>
                            </div>
                            
                            <div class="col-12 mt-4">
                                <button type="submit" class="menu-btn btn-lg">
                                     Adicionar nova categoria
                                </button>
                            </div>
                            <br>
                                <br>   <br>
                                <br>   <br>
                                <br>   <br>
                                <br>   <br>
                                <br>   <br>
                                <br>
                            <div class="col-12 text-center mt-3">
                            <a href="painel_admin.php" class="btn btn-outline-secondary">
                                ←  Voltar para a tela do Administrador
                            </a>
                        </div>
                             
                               
                            </div>
                        </div>
                    </form>
                    
                    <?php if(isset($_SESSION['mensagem'])): ?>
                        <div class="alert alert-success mt-3 text-center">
                            <?php 
                            echo $_SESSION['mensagem']; 
                            unset($_SESSION['mensagem']);
                            ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if(isset($_SESSION['erro'])): ?>
                        <div class="alert alert-danger mt-3 text-center">
                            <?php 
                            echo $_SESSION['erro']; 
                            unset($_SESSION['erro']);
                            ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>