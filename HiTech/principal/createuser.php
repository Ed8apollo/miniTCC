<?php session_start();
require 'config.php'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/create.css"> 
    <title>Cadastrar Produto - Estoque HiTech</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="main-card">
        <div class="row g-0">
           
            <div class="col-md-5">
                <div class="welcome-section">
                    <div class="text-center">
             
                        <h3 class="mb-3">Cadastrar Produto</h3>
                        <p class="mb-0">Adicione novos produtos ao estoque</p>
                    </div>
                </div>
            </div>
            
           
            <div class="col-md-7">
                <div class="form-section">
                    <h4 class="text-center mb-4 text-dark">Preencha os dados do produto</h4>
                    
                    <form method="POST" action="salvar_user.php">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Nome do Produto</label>
                                <input type="text" name="nome" class="form-control" 
                                    required>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Preço (R$)</label>
                                <input type="number" name="preco" class="form-control" 
                                   required>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Quantidade</label>
                                <input type="number" name="quantidade" class="form-control" 
                                 required>
                            </div>
                            
                            <div class="col-12">
                                <label class="form-label">Categoria</label>
                                <select name="categoria_id" class="form-control" required>
                                    <option value="">Selecione uma categoria</option>
                                    <?php
                                  
                                    $sql_categorias = "SELECT * FROM categorias ORDER BY nome";
                                    $result_categorias = $conn->query($sql_categorias);
                                    
                                    if($result_categorias->num_rows > 0) {
                                        while($categoria = $result_categorias->fetch_assoc()) {
                                            echo "<option value='{$categoria['id']}'>{$categoria['nome']}</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            
                            <div class="col-12">
                                <label class="form-label">Descrição</label>
                                <textarea name="descricao" class="form-control" 
                                    placeholder="Descreva o produto..." rows="3"></textarea>
                            </div>
                            
                            <div class="col-12 mt-4">
                                <button href="listapro_usuario.php" type="submit" class="menu-btn btn-lg">
                                     Cadastrar Produto
                                </button>
                            </div>
                            
                            <div class="col-12 text-center mt-3">
                                <a href="painel_usuario.php" class="btn btn-outline-secondary">
                                    ← Voltar para a tela do Usuário
                                </a>
                              
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