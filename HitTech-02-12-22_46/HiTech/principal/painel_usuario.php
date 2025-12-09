<?php
session_start();
if (!isset($_SESSION['logado']) || $_SESSION['nivel'] != 'usuario') {
    header("Location: login.php");
    exit;
}

require 'config.php';

// Buscar a foto atualizada do usuário
if (isset($_SESSION['id'])) {
    $id_usuario = $_SESSION['id'];
    $sql = "SELECT foto FROM usuarios WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $usuario = $result->fetch_assoc();
            // Atualizar a foto na sessão
            $_SESSION['foto'] = $usuario['foto'];
        }
        $stmt->close();
    }
}

$foto_exibir = 'img/usuario.png'; // Padrão
if (isset($_SESSION['foto']) && !empty($_SESSION['foto'])) {
    $caminho_foto = 'uploads/usuarios/' . $_SESSION['foto'];
    if (file_exists($caminho_foto)) {
        $foto_exibir = $caminho_foto;
    }
}
?>
<script>
history.pushState(null, null, location.href);

window.onpopstate = function () {
    history.pushState(null, null, location.href);
    var myModal = new bootstrap.Modal(document.getElementById('modalSair'));
    myModal.show();
};
</script>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Painel do Usuário - Estoque HiTech</title>
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
    max-width: 1250px;
    max-height: 680px ;
}
.welcome-section {
    background: linear-gradient(135deg, #2842b6, #752da5);
    color: white;
    padding: 235px;
    height: 680px; 
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
</head>
<body>
    <div class="main-card">
        <div class="row g-0">
          
        <div class="col-md-5">
                <div class="welcome-section">
                    <div class="text-center">
                   
                    <img src="<?= $foto_exibir; ?>" 
                         alt="Imagem Login" 
                         style="width:120px; height:120px; margin-bottom:20px; border-radius: 50%; object-fit: cover; border: 3px solid white;"
                         onerror="this.src='img/usuario.png'">
                        <h3 class="text-center mb-4 text-dark">Bem-vindo, <?= $_SESSION['nome']; ?> </h3>
                        <p class="mb-0">Você esta logado como Usuário</p>
                    </div>
                </div>
            </div>
            
            
            <div class="col-md-7">
                <div class="menu-section">
                    <h3 class="text-center mb-4 text-dark">Painel do Usuário</h3>
                    
                    
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
                            <a href="telacateguser.php" class="menu-btn">
                                Categorias
                            </a>
                        </div>
                        
                        <div class="col-md-6">
                            <a href="listapro_usuario.php" class="menu-btn">
                                 Estoque
                            </a>
                        </div>

                        <div class="col-md-6">
                            <a href="configcontauser.php" class="menu-btn">
                                Configuaração da conta
                            </a>
                        </div>

                        <div class="col-md-6">
                            <a href="abasocial.php" class="menu-btn">
                            Aba social
                            </a>
                        </div>


                        <br> <br> <br> <br> <br> <br><br> <br> <br> <br>
                         <!-- Botão Sair que abre o modal -->
<a href="#" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modalSair">← Sair</a>

<!-- Modal -->
<div class="modal fade" id="modalSair" tabindex="-1" aria-hidden="true">
    
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Deseja deslogar?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Sera necessario fazer o login novamente.</p>
      </div>
      <div class="modal-footer">
      <a href="telainicial.php" class="menu-btn">Deslogar</a>
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">voltar</button>
        
      </div>
    </div>
  </div>
</div>

<!-- Certifique-se de que os scripts do Bootstrap estão incluídos -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
                    
                    <div class="text-center mt-4">
                        <p class="text-muted">Você está logado como <b>Usuário</b>.</p>
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
<script>
let ultimaMensagemId = 0;
const usuarioId = 1;

function enviarMensagem() {
    const input = document.getElementById('msgInput');
    const mensagem = input.value.trim();
    
    if (!mensagem) return;
    

    adicionarMensagem(mensagem, 'usuario', new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}));
    input.value = '';
    
 
    fetch('chat_backend.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `action=enviar&usuario_id=${usuarioId}&mensagem=${encodeURIComponent(mensagem)}&remetente=usuario`
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            console.error('Erro ao enviar:', data.error);
        }
    })
    .catch(error => console.error('Erro:', error));
}

function carregarMensagens() {
    fetch(`chat_backend.php?action=receber&usuario_id=${usuarioId}&ultimo_id=${ultimaMensagemId}`)
        .then(response => response.json())
        .then(data => {
            if (data.mensagens && data.mensagens.length > 0) {
                data.mensagens.forEach(msg => {
                    adicionarMensagem(msg.mensagem, msg.remetente, msg.hora);
                    ultimaMensagemId = Math.max(ultimaMensagemId, msg.id);
                });
                rolarParaBaixo();
                
        
                fetch('chat_backend.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    body: `action=marcar_lida&usuario_id=${usuarioId}`
                });
            }
        })
        .catch(error => console.error('Erro:', error));
}

function adicionarMensagem(texto, remetente, hora) {
    const chatBox = document.getElementById('chatBox');
    const p = document.createElement('p');
    
    if (remetente === 'sistema') {
        p.innerHTML = `<strong>Sistema:</strong> ${texto}`;
        p.style.color = '#666';
    } else {
        const prefixo = remetente === 'usuario' ? '<strong>Você:</strong>' : '<strong>Admin:</strong>';
        p.innerHTML = `${prefixo} ${texto} <span style="font-size: 11px; color: #888;">${hora}</span>`;
        p.style.background = remetente === 'usuario' ? '#e3f2fd' : '#d4edda';
        p.style.padding = '8px';
        p.style.borderRadius = '5px';
        p.style.marginBottom = '5px';
    }
    
    chatBox.appendChild(p);
}

function rolarParaBaixo() {
    const chatBox = document.getElementById('chatBox');
    chatBox.scrollTop = chatBox.scrollHeight;
}


document.getElementById('msgInput').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        enviarMensagem();
    }
});

setInterval(carregarMensagens, 2000);

carregarMensagens();
</script>
</html>