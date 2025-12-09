<?php require 'config.php'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <!--<link rel="stylesheet" href="css/gerenciamentousuario.css">-->
    <title>Gerenciar Usuários - Estoque HiTech</title>
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
    padding: 20px 0;
}
.main-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    overflow: hidden;
    width: 95%;
    max-width: 1400px;
}
.welcome-section {
    background: linear-gradient(135deg, #2842b6, #752da5);
    color: white;
    padding: 40px;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    text-align: center;
}
.menu-section {
    padding: 40px;
}
.btn-gradient {
    background: linear-gradient(135deg, #2842b6, #752da5);
    border: none;
    color: white;
    padding: 12px 25px;
    border-radius: 10px;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-weight: 500;
}
.btn-gradient:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(40, 66, 182, 0.3);
    color: white;
}
.table-container {
    background: #f8f9fa;
    border-radius: 15px;
    width: 102%;
    margin: 25px 0;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}
.table-custom {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}
.table-custom thead {
    background: linear-gradient(135deg, #2842b6, #752da5);
    color: white;
}
.table-custom th {
    border: none;
    padding: 15px 12px;
    font-weight: 600;
    text-align: center;
    vertical-align: middle;
}
.table-custom td {
    padding: 12px;
    vertical-align: middle;
    text-align: center;
    border-color: #f1f3f4;
}
.table-custom tbody tr {
    transition: all 0.3s ease;
}
.table-custom tbody tr:hover {
    background-color: #f8f9ff;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}
.badge-admin {
    background: linear-gradient(135deg, #dc3545, #c82333);
    color: white;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
}
.badge-user {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
}
.btn-action {
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 0.8rem;
    margin: 2px;
    transition: all 0.3s ease;
}
.btn-edit {
    background: #ffc107;
    border: none;
    color: #000;
}
.btn-edit:hover {
    background: #e0a800;
    transform: scale(1.05);
}
.btn-delete {
    background: #dc3545;
    border: none;
    color: white;
}
.btn-delete:hover {
    background: #c82333;
    transform: scale(1.05);
}
.stats-card {
    background: white;
    border-radius: 12px;
    padding: 20px;
    margin: 10px 0;
    border-left: 4px solid #2842b6;
    box-shadow: 0 3px 10px rgba(0,0,0,0.08);
    transition: transform 0.3s ease;
}
.stats-card:hover {
    transform: translateY(-3px);
}
.user-avatar {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    background: linear-gradient(135deg, #2842b6, #752da5);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
    margin: 0 auto;
}
.section-title {
    color: #2c3e50;
    font-weight: 700;
    margin-bottom: 25px;
    position: relative;
    padding-bottom: 10px;
}
.section-title:after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 3px;
    background: linear-gradient(135deg, #2842b6, #752da5);
    border-radius: 2px;
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
           
            <div class="col-md-4">
                <div class="welcome-section">
                    <div class="text-center">
                 
                        <h4 class="mb-3">Gerenciar Usuários</h4>
                        <p class="mb-0">Controle completo dos usuários</p>
                    </div>
                </div>
            </div>
            
            
            <div class="col-md-8">
                <div class="menu-section">
                    <h3 class="text-center mb-4 text-dark">Lista de Usuários</h3>
                 
                   
                    <div class="table-container">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nome</th>
                                        <th>E-mail</th>
                                        <th>Nível</th>
                                        <th>Data Cadastro</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
$sql = "SELECT * FROM usuarios ORDER BY id ";
$resultado = $conn->query($sql);
if($resultado->num_rows > 0){
    while ($row = $resultado->fetch_assoc()){
        $nivel_badge = $row['nivel'] == 'admin' ? 
            '<span class="badge-admin">👑 Administrador</span>' : 
            '<span class="badge-user">👤 Usuário</span>';
        
        echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['nome']}</td>
            <td>{$row['email']}</td>
            <td>{$nivel_badge}</td>
            <td>" . date('d/m/Y', strtotime($row['data_cadastro'])) . "</td>
            <td>
                <a href='edituser.php?id={$row['id']}' class='btn btn-sm btn-warning btn-action'>✏️ Editar</a>
                <a href='deleteuser.php?id={$row['id']}&redirect=gerenciarmusers' class='btn btn-sm btn-danger btn-action' onclick='return confirm(\"Tem certeza que deseja excluir este usuário?\")'>🗑️ Excluir</a>
            </td>
        </tr>";
    }
} else {
    echo "<tr>
        <td colspan='6' class='text-center py-4'>
            <h5 class='text-muted'>👥 Nenhum usuário cadastrado</h5>
        </td>
    </tr>";
}
?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                  
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <div class="stats-card text-center">
                                <h6 class="mb-1">Total de Usuários</h6>
                                <h4 class="mb-0 text-primary">
                                    <?php 
                                    $sql_count = "SELECT COUNT(*) as total FROM usuarios";
                                    $result_count = $conn->query($sql_count);
                                    $total = $result_count->fetch_assoc()['total'];
                                    echo $total;
                                    ?>
                                </h4>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stats-card text-center">
                                <h6 class="mb-1">Administradores</h6>
                                <h4 class="mb-0 text-danger">
                                    <?php 
                                    $sql_admin = "SELECT COUNT(*) as total FROM usuarios WHERE nivel = 'admin'";
                                    $result_admin = $conn->query($sql_admin);
                                    $admins = $result_admin->fetch_assoc()['total'];
                                    echo $admins;
                                    ?>
                                </h4>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stats-card text-center">
                                <h6 class="mb-1">Usuários Comuns</h6>
                                <h4 class="mb-0 text-success">
                                    <?php 
                                    $sql_user = "SELECT COUNT(*) as total FROM usuarios WHERE nivel = 'usuario'";
                                    $result_user = $conn->query($sql_user);
                                    $users = $result_user->fetch_assoc()['total'];
                                    echo $users;
                                    ?>
                                </h4>
                            </div>
                        </div>
                    </div>

           
                    <div class="row g-3 mt-4">
                        <div class="col-12 text-center mt-3">
                            <a href="painel_admin.php" class="btn btn-outline-secondary">
                                ←  Voltar para a tela do Administrador
                            </a>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>