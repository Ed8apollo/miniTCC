<?php session_start(); ?>
<?php require 'config.php'; ?>
<script>
// Bloqueia o botão Voltar
history.pushState(null, null, location.href);
window.onpopstate = function () {
    history.go(1);
};
</script>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/telainicial.css"> 
    <title>Sistema de Estoque - HiTech</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
   
</head>

<body>
    <div class="main-card">
        <div class="row g-0">
         
            <div class="col-md-5">
                <div class="welcome-section">
                    <div class="text-center">
                   <img src="img/logoTechbg.png" 
     alt="Imagem Login"
     style="max-width:200px; height:auto; margin-bottom:20px;">
                        <h3 class="mb-3">Estoque HiTech</h3>
                        <p class="mb-0">Sistema de controle de estoque para produtos de tecnologia</p>
                    </div>
                </div>
            </div>
            
           
            <div class="col-md-7">
                <div class="menu-section">
                    <h3 class="text-center mb-4 text-dark">Menu Principal</h3>
                    
                   
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="stats-card">
                                <h6 class="mb-1">Total de Produtos</h6>
                                <h4 class="mb-0 text-primary"><?php echo obterTotalProdutos($conn); ?></h4>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="stats-card">
                                <h6 class="mb-1">Categorias</h6>
                                <h4 class="mb-0 text-success"><?php echo obterTotalCategorias($conn); ?></h4>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="row g-3">
                        
                    <div class="col-md-6">
                            <a href="login.php" class="menu-btn">
                         Login
                            </a>
                        </div>
                    <div class="col-md-6">
                            <a href="cadastrarusuario.php" class="menu-btn">
                             Cadastrar-se
                            </a>
                        </div>
                    </div>
                    
                    <br><br><br><br><br> <br><br><br><br><br> 
                    <div class="text-center mt-4">
                        <p class="text-muted">
                            Bem-vindo ao seu sistema de estoque! 
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <?php
   function obterTotalProdutos($conn) {

    
    $sql = "SELECT SUM(quantidade) AS total FROM produtos";

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['total'] ?? 0;
    }

    return 0;
}
    
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
</body>
</html>