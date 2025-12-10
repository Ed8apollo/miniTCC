<?php 
session_start();
require 'config.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <!--<link rel="stylesheet" href="css/categuser.css"> -->
    <title>Visualizar Categorias - Estoque HiTech</title>
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
    max-width: 900px;
    height: 600px;
    display: flex;
}
.welcome-section {
    background: linear-gradient(135deg, #2842b6, #752da5);
    color: white;
    max-width: 800px;
    height: 600px; 
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
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
    padding: 20px;
    margin: 20px auto ;
    border-left: 4px solid #2842b6;
    max-width: 200px; 
    width: 100%;
    display: block; 
}


.stats-card-fixed {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 20px;
    margin: 20px auto;
    border-left: 4px solid #2842b6;
    max-width: 200px;
    width: 100%;
}


.stats-card .card,
.stats-card-fixed .card {
    width: 100% ;
    margin: 0 ;
}


.table-container {
    background: #f8f9fa;
    border-radius: 15px;
    padding: 10px;
    margin: 10px 0;
    max-height: 400px;
    overflow-y: auto;
    max-width: 95%;
    margin-left: auto;
    margin-right: auto;
}


.table-container .table {
    margin-bottom: 0;
    font-size: 0.9rem;
    width: 100%;
}

.table-container .table th {
    padding: 8px 12px;
    font-size: 0.85rem;
    white-space: nowrap; 
}

.table-container .table td {
    padding: 6px 12px;
    vertical-align: middle;
}


.table-container .badge {
    font-size: 0.75rem;
    padding: 4px 8px;
}

.btn-action {
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 0.85rem;
}


.categories-table {
    max-width: 600px; 
    margin: 0 auto;
}

.categories-table .table {
    min-width: 400px;
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
        min-height: 600px;
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
           
            <div class="col-md-4">
                <div class="welcome-section">
                    <div class="text-center">
                        
                        <h4 class="mb-3">Listagem de Categorias</h4>
                        <p class="mb-0">Visualize todas as categorias disponíveis</p>
                    </div>
                </div>
            </div>
            
            
            <div class="col-md-8">
                <div class="menu-section">
                    <h3 class="text-center mb-4 text-dark">Categorias do Sistema</h3>
                    
                  

                    
                    <div class="table-container categories-table">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                            <thead class="table-dark">
    <tr>
        <th>ID</th>
        <th>Nome da Categoria</th>
   
        <th>Ações</th>
    </tr>
</thead>
<tbody>
<?php
$sql = "SELECT * FROM categorias ORDER BY id";
$resultado = $conn->query($sql);

if($resultado->num_rows > 0){
    while ($row = $resultado->fetch_assoc()){
        echo "<tr>
            <td>{$row['id']}</td>
            <td><strong>{$row['nome']}</strong></td>
            <!-- REMOVA ESTA LINHA: <td><span class='badge bg-success'>Ativa</span></td> -->
            <td>
    <a href='categedit.php?id={$row['id']}' class='btn btn-sm btn-warning'>Editar</a>
    <a href='#' class='btn btn-sm btn-danger delete-category' 
       data-id='{$row['id']}' 
       data-name='{$row['nome']}'>Excluir</a>
</td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='3' class='text-center'>Nenhuma categoria cadastrada</td></tr>"; 
}
?>
</tbody>
              
                            </table>
                        </div>
                    </div>

                   
                        
                    </div>
              

                 
                    <div class="row g-3 mt-4">
                        
                        <div class="col-12 text-center mt-3">
                            <a href="painel_admin.php" class="btn btn-outline-secondary">
                                ← Voltar para a tela do Admin
                            </a>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

                                        
    <?php 
                                          
                                          function obterTotalCategorias($conn) {
                                              $sql = "SELECT COUNT(*) AS total FROM categorias";
                                      
                                          $result = $conn->query($sql);
                                      
                                          if ($result && $result->num_rows > 0) {
                                              $row = $result->fetch_assoc();
                                              return $row['total'] ?? 0;
                                          }
                                      
                                          return 0;
                                          }
                          
                        ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


<div class="modal fade" id="confirmDeleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-dialog modal-dialog-centered">
                <h5 class="modal-title">⚠️ Confirmar Exclusão</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir esta categoria?</p>
                <p class="text-muted small">Esta ação não pode ser desfeita.</p>
            </div>
            <div class="modal-footer">
            <a href="#" id="confirmDeleteBtn" class="menu-btn">Sim, Excluir</a>
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="errorModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title">⚠️ Atenção</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p id="errorMessage">Não é possível excluir esta categoria pois existem produtos vinculados a ela!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Entendi</button>
            </div>
        </div>
    </div>
</div>

<script>

document.addEventListener('DOMContentLoaded', function() {
    const deleteLinks = document.querySelectorAll('.delete-category');
    
    deleteLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            const categoryId = this.getAttribute('data-id');
            const categoryName = this.getAttribute('data-name');
            

            const modalBody = document.querySelector('#confirmDeleteModal .modal-body p:first-child');
            modalBody.textContent = `Tem certeza que deseja excluir a categoria "${categoryName}"?`;
            

            const confirmBtn = document.getElementById('confirmDeleteBtn');
            confirmBtn.href = `categdelet.php?id=${categoryId}`;
            

            const modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
            modal.show();
        });
    });

    const urlParams = new URLSearchParams(window.location.search);
    if(urlParams.has('error')) {
        const errorMessage = document.getElementById('errorMessage');
        errorMessage.textContent = decodeURIComponent(urlParams.get('error'));
        
        const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
        errorModal.show();
    }
});
</script>
</body>
</html>