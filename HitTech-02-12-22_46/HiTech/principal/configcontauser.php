<?php
session_start();
if (!isset($_SESSION['logado']) || $_SESSION['nivel'] != 'usuario') {
    header("Location: login.php");
    exit();
}

require 'config.php';

$mensagem = '';
$tipo_mensagem = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $mensagem = "Token de segurança inválido!";
        $tipo_mensagem = "error";
    } else {
       
        if (isset($_POST['atualizar_nome'])) {
            $novo_nome = trim($_POST['novo_nome']);
            $id = (int)$_SESSION['id'];
            
            if (!empty($novo_nome) && strlen($novo_nome) <= 100) {
                
                $novo_nome = strip_tags($novo_nome);
                $novo_nome = htmlspecialchars($novo_nome, ENT_QUOTES, 'UTF-8');
                
                $sql = "UPDATE usuarios SET nome = ? WHERE id = ?";
                $stmt = $conn->prepare($sql);
                if ($stmt) {
                    $stmt->bind_param("si", $novo_nome, $id);
                    
                    if ($stmt->execute()) {
                        $_SESSION['nome'] = $novo_nome;
                        $mensagem = "Nome atualizado com sucesso!";
                        $tipo_mensagem = "success";
                    } else {
                        $mensagem = "Erro ao atualizar nome!";
                        $tipo_mensagem = "error";
                    }
                    $stmt->close();
                }
            } else {
                $mensagem = "Nome inválido!";
                $tipo_mensagem = "error";
            }
        }
        
       
     if (isset($_POST['atualizar_senha'])) {
    $senha_atual = $_POST['senha_atual'];
    $nova_senha = $_POST['nova_senha'];
    $confirmar_senha = $_POST['confirmar_senha'];
    $id = (int)$_SESSION['id'];

    
    if (empty($senha_atual) || empty($nova_senha) || empty($confirmar_senha)) {
        $mensagem = "Preencha todos os campos!";
        $tipo_mensagem = "error";
    } 
    elseif ($nova_senha !== $confirmar_senha) {
        $mensagem = "A nova senha e a confirmação não coincidem!";
        $tipo_mensagem = "error";
    } 
    else {
 
        $sql = "SELECT senha FROM usuarios WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            $usuario = $resultado->fetch_assoc();
            $hash_salvo = $usuario['senha'];

            $senha_confere = false;

    
            if (password_verify($senha_atual, $hash_salvo)) {
                $senha_confere = true;
            }

       
            elseif (md5($senha_atual) === $hash_salvo) {
                $hash_moderno = password_hash($senha_atual, PASSWORD_DEFAULT);

                $sqlUpdate = "UPDATE usuarios SET senha = ? WHERE id = ?";
                $stmt2 = $conn->prepare($sqlUpdate);
                $stmt2->bind_param("si", $hash_moderno, $id);
                $stmt2->execute();
                $stmt2->close();

                $senha_confere = true;
            }

            if ($senha_confere) {

                $nova_hash = password_hash($nova_senha, PASSWORD_DEFAULT);

                $sqlUpdate2 = "UPDATE usuarios SET senha = ? WHERE id = ?";
                $stmt3 = $conn->prepare($sqlUpdate2);
                $stmt3->bind_param("si", $nova_hash, $id);

                if ($stmt3->execute()) {
                    $mensagem = "Senha atualizada com sucesso!";
                    $tipo_mensagem = "success";
                } else {
                    $mensagem = "Erro ao atualizar senha!";
                    $tipo_mensagem = "error";
                }

                $stmt3->close();

            } else {
                $mensagem = "Senha atual incorreta!";
                $tipo_mensagem = "error";
            }

        } else {
            $mensagem = "Usuário não encontrado!";
            $tipo_mensagem = "error";
        }

        $stmt->close();
    }
}
        
       
        if (isset($_FILES['foto_usuario']) && $_FILES['foto_usuario']['error'] == UPLOAD_ERR_OK) {
            $id = (int)$_SESSION['id'];
            $diretorio_upload = "uploads/usuarios/";
            
            
            if (!is_dir($diretorio_upload)) {
                if (!mkdir($diretorio_upload, 0755, true)) {
                    $mensagem = "Erro ao criar diretório de upload!";
                    $tipo_mensagem = "error";
                }
            }
            
           
            $nome_arquivo = $_FILES['foto_usuario']['name'];
            $tamanho_arquivo = $_FILES['foto_usuario']['size'];
            $arquivo_tmp = $_FILES['foto_usuario']['tmp_name'];
            
            
            $info_imagem = @getimagesize($arquivo_tmp);
            if ($info_imagem === false) {
                $mensagem = "O arquivo não é uma imagem válida!";
                $tipo_mensagem = "error";
            } else {
               
                if ($tamanho_arquivo > 2097152) {
                    $mensagem = "A imagem deve ter no máximo 2MB!";
                    $tipo_mensagem = "error";
                } else {
                    
                    $extensoes_permitidas = ['jpg', 'jpeg', 'png', 'gif'];
                    $extensao = strtolower(pathinfo($nome_arquivo, PATHINFO_EXTENSION));
                    
                    if (!in_array($extensao, $extensoes_permitidas)) {
                        $mensagem = "Formato de arquivo não permitido! Use JPG, JPEG, PNG ou GIF.";
                        $tipo_mensagem = "error";
                    } else {
                      
                        $novo_nome_arquivo = "usuario_" . $id . "_" . time() . "." . $extensao;
                        $caminho_completo = $diretorio_upload . $novo_nome_arquivo;
                        
                      
                        if (move_uploaded_file($arquivo_tmp, $caminho_completo)) {
                            
                            if (isset($_SESSION['foto']) && !empty($_SESSION['foto'])) {
                                $foto_antiga = $diretorio_upload . $_SESSION['foto'];
                                if (file_exists($foto_antiga) && is_file($foto_antiga)) {
                                    @unlink($foto_antiga);
                                }
                            }
                            
                            
                            $sql = "UPDATE usuarios SET foto = ? WHERE id = ?";
                            $stmt = $conn->prepare($sql);
                            if ($stmt) {
                                $stmt->bind_param("si", $novo_nome_arquivo, $id);
                                
                                if ($stmt->execute()) {
                                    $_SESSION['foto'] = $novo_nome_arquivo;
                                    $mensagem = "Foto atualizada com sucesso!";
                                    $tipo_mensagem = "success";
                                } else {
                                    $mensagem = "Erro ao atualizar foto no banco de dados!";
                                    $tipo_mensagem = "error";
                                    
                                    @unlink($caminho_completo);
                                }
                                $stmt->close();
                            }
                        } else {
                            $mensagem = "Erro ao fazer upload da imagem!";
                            $tipo_mensagem = "error";
                        }
                    }
                }
            }
        }
    }
}


if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--<link rel="stylesheet" href="css/conta.css">--> 
    <title>Configurações da Conta</title>
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
    max-width: 1600px;
    max-height: 1450px;
}
.welcome-section {
    background: linear-gradient(135deg, #2842b6, #752da5);
    color: white;
    height: 120px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    
}
.menu-section {
    padding: 30px;
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
    margin: 10px 0;
    border-left: 4px solid #2842b6;
}
.form-control {
    border-radius: 10px;
    padding: 12px;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
}
.form-control:focus {
    border-color: #2842b6;
    box-shadow: 0 0 0 0.2rem rgba(40, 66, 182, 0.25);
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


.config-section {
    padding: 30px;
}
.config-card {
    background: #f8f9fa;
    border-radius: 15px;
    padding: 25px;
    margin-bottom: 25px;
    border-left: 4px solid #2842b6;
}
.foto-usuario {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #2842b6;
    margin-bottom: 20px;
}
.btn-custom {
    background: linear-gradient(135deg, #2842b6, #752da5);
    border: none;
    color: white;
    padding: 12px 25px;
    border-radius: 10px;
    transition: all 0.3s ease;
}
.btn-custom:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    color: white;
}
.message {
    padding: 15px;
    border-radius: 10px;
    margin-bottom: 20px;
    text-align: center;
}
.message.success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}
.message.error {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}
        </style>
</head>
<body>
    <div class="main-card">
        <div class="row g-0">
         
            <div class="col-md-5">
                <div class="welcome-section">
                    <div class="text-center">
                        <?php
                        $foto_usuario = isset($_SESSION['foto']) && !empty($_SESSION['foto']) ? 
                            'uploads/usuarios/' . $_SESSION['foto'] : 'img/admin.png';
                        ?>
                        <img src="<?= $foto_usuario; ?>" 
                             alt="Foto do Usuário" 
                             class="foto-usuario"
                             onerror="this.src='img/admin.png'">
                        <h3 class="text-center mb-4 text-white"><?= $_SESSION['nome']; ?> </h3>
                        <p class="mb-0 text-white">Administrador</p>
                        
                 
                       
                    </div>
                </div>
            </div>
            
           
            <div class="col-md-7">
                <div class="config-section">
                    <h3 class="text-center mb-4 text-dark">Configurações da Conta</h3>
                    
                    <?php if (!empty($mensagem)): ?>
                        <div class="message <?= $tipo_mensagem ?>">
                            <?= $mensagem ?>
                        </div>
                    <?php endif; ?>
                    
                   
                    <div class="config-card">
                        <h5 class="mb-3">Alterar Foto de Perfil</h5>
                        <form method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                            <div class="mb-3">
                                <label for="foto_usuario" class="form-label">Selecionar Nova Foto</label>
                                <input type="file" class="form-control" id="foto_usuario" name="foto_usuario" 
                                       accept="image/*" required>
                                <div class="form-text">Formatos permitidos: JPG, JPEG, PNG, GIF. Tamanho máximo: 2MB</div>
                            </div>
                            <button type="submit" class="btn btn-custom">Atualizar Foto</button>
                        </form>
                    </div>
                    
                   
                    <div class="config-card">
                        <h5 class="mb-3"> Alterar Nome de Usuário</h5>
                        <form method="POST">
                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                            <div class="mb-3">
                                <label for="novo_nome" class="form-label">Novo Nome</label>
                                <input type="text" class="form-control" id="novo_nome" name="novo_nome" 
                                       value="<?= $_SESSION['nome']; ?>" required>
                            </div>
                            <button type="submit" name="atualizar_nome" class="btn btn-custom">Atualizar Nome</button>
                        </form>
                    </div>
                    
                  
                    <div class="config-card">
                        <h5 class="mb-3">🔒 Alterar Senha</h5>
                        <form method="POST">
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                            <div class="mb-3">
                                <label for="senha_atual" class="form-label">Senha Atual</label>
                                <input type="password" class="form-control" id="senha_atual" name="senha_atual" required>
                            </div>
                            <div class="mb-3">
                                <label for="nova_senha" class="form-label">Nova Senha</label>
                                <input type="password" class="form-control" id="nova_senha" name="nova_senha" required>
                            </div>
                            <div class="mb-3">
                                <label for="confirmar_senha" class="form-label">Confirmar Nova Senha</label>
                                <input type="password" class="form-control" id="confirmar_senha" name="confirmar_senha" required>
                            </div>
                            <button type="submit" name="atualizar_senha" class="btn btn-custom">Atualizar Senha</button>
                        </form>
                    </div>
                    
                 
                    <div class="config-card">
                        <h5 class="mb-3">ℹ️ Informações da Conta</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Nome:</strong> <?= $_SESSION['nome']; ?></p>
                                <p><strong>Nível:</strong> <?= ucfirst($_SESSION['nivel']); ?></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Último Login:</strong> <?= date('d/m/Y H:i'); ?></p>
                                <p><strong>Status:</strong> <span class="text-success">● Ativo</span></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-center mt-4">
                        <a href="painel_usuario.php" class="btn btn-outline-secondary">
                        ← Voltar para a Tela Usuário
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
       
        document.getElementById('foto_usuario').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.querySelector('.foto-usuario').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
        
        
        document.querySelector('form[name="atualizar_senha"]').addEventListener('submit', function(e) {
            const novaSenha = document.getElementById('nova_senha').value;
            const confirmarSenha = document.getElementById('confirmar_senha').value;
            
            if (novaSenha !== confirmarSenha) {
                e.preventDefault();
                alert('As senhas não coincidem!');
                return false;
            }
            
            if (novaSenha.length < 6) {
                e.preventDefault();
                alert('A senha deve ter pelo menos 6 caracteres!');
                return false;
            }
        });
    </script>
</body>
</html>