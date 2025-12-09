<?php require 'config.php'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
     <link rel="stylesheet" href="css/style_index.css"> 
    <title>Gerenciar Produtos - Estoque HiTech</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
 
    <div class="main-card">
        <div class="row g-0">
           
            <div class="col-md-4">
                <div class="welcome-section">
                    <div class="text-center">
                        
                        <h4 class="mb-3">Listagem de Produtos</h4>
                        <p class="mb-0">Controle completo do estoque</p>
                    </div>
                </div>
            </div>
            
            
            <div class="col-md-8">
                <div class="menu-section">
                    <h3 class="text-center mb-4 text-dark">Lista de Produtos</h3>
                    
                    
                    <div class="text-center mb-4">
                        <a href="create.php" class="menu-btn btn-lg">
                             Cadastrar Novo Produto
                        </a>
                    </div>

                    
                    


                    <div class="table-container">
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nome do Produto</th>
                    <th>Preço</th>
                    <th>Quantidade</th>
                    <th>Categoria</th>
                    <th>Descrição</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                
            <?php

$sql = "SELECT 
            p.id,
            p.nome,
            p.preco,
            p.quantidade,
            c.nome AS categorias,
            p.descricao
        FROM produtos p
        LEFT JOIN categorias c ON p.categorias = c.id
        ORDER BY p.id";
            $resultado = $conn->query($sql);

            if($resultado->num_rows > 0){
                while ($row = $resultado->fetch_assoc()){
                    echo "
                    <tr>
                        <td>{$row['id']}</td>
                        <td>{$row['nome']}</td>
                        <td>{$row['preco']}</td>
                        <td>{$row['quantidade']}</td>
                        <td>{$row['categorias']}</td>
                        <td>{$row['descricao']}</td>
                        <td>
                           
                            <a href='delete.php?id={$row['id']}' class='btn btn-sm btn-danger'>Excluir</a>
                        </td>
                    </tr>
                    ";
                }
            } else {
                echo "<tr><td colspan='7' class='text-center'>Nenhum produto cadastrado</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

        
                    
<div class="row g-3 mt-4">
                    <div class="col-12 text-center mt-3">
                            <a href="painel_usuario.php" class="btn btn-outline-secondary">
                            ← Voltar para a tela do Usuario
                            </a>
                        </div>
                        
                  
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>
</html>