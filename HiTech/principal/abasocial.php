<?php
session_start();
if (!isset($_SESSION['logado']) || $_SESSION['nivel'] != 'usuario') {
    header("Location: login.php");
    exit;
}

require 'config.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Aba Social - HiTech</title>
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
            max-width: 1100px;
            max-height: 680px;
            display: flex;
        }
        .welcome-section {
            background: linear-gradient(135deg, #2842b6, #752da5);
            color: white;
            padding: 65px;
            height: 680px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            flex: 1;           
            min-height: 100%;   
            min-width: 300px;   
            box-sizing: border-box;
        }
        .menu-section {
            padding: 40px;
            flex: 2;
            min-width: 350px;
            box-sizing: border-box;
        }
        .chat-box {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 12px;
            height: 300px;
            min-width: 600px;
            overflow-y: auto;
            border-left: 4px solid #2842b6;
            border-bottom: 4px solid #2842b6;
        }
        .chat-input {
            margin-top: 20px;
        }
        .chat-input input {
            width: 100%;
            padding: 12px;
            border-radius: 12px;
            border: 1px solid #ccc;
        }
        .chat-input button {
            width: 100%;
            margin-top: 10px;
            background: linear-gradient(135deg, #2842b6, #752da5);
            border: none;
            color: white;
            padding: 12px;
            border-radius: 12px;
        }
        .msg-usuario {
            background: #e3f2fd;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 10px;
            max-width: 80%;
            float: right;
            clear: both;
        }
        .msg-admin {
            background: #d4edda;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 10px;
            max-width: 80%;
            float: left;
            clear: both;
        }
        .msg-info {
            font-size: 11px;
            color: #666;
            margin-top: 5px;
            text-align: right;
        }
        .social-title {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="main-card">
    <div class="row g-0 align-items-start">
        <div class="col-md-4">
            <div class="welcome-section">
                <div class="text-center">
                    <h4 class="mb-3">Aba Social</h4>
                    <p class="mb-0">Chat com Administrador</p>
                    <p class="mb-0 mt-3"><small>Usuário: <?= $_SESSION['nome']; ?></small></p>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="menu-section">
                <h3 class="social-title">Chat Social</h3>

                <!-- CHAT -->
                <div class="chat-box" id="chatBox">
                    <p><strong>Sistema:</strong> Bem-vindo ao chat social da HiTech! Digite sua mensagem
                    abaixo para falar com um Administrador.</p>
                </div>

                <div class="chat-input">
                    <input type="text" id="msgInput" placeholder="Digite sua mensagem..." onkeypress="if(event.key === 'Enter') enviarMensagem()">
                    <button onclick="enviarMensagem()">Enviar</button>
                </div>

                <div class="col-12 text-center mt-3">
                    <a href="painel_usuario.php" class="btn btn-outline-secondary">
                        ← Voltar para a tela do Usuário
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let ultimaMensagemId = 0;
    const usuarioId = <?= $_SESSION['id']; ?>;

    function enviarMensagem() {
        const input = document.getElementById('msgInput');
        const mensagem = input.value.trim();
        
        if (!mensagem) return;
      
        const hora = new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
        adicionarMensagem(mensagem, 'usuario', hora);
        input.value = '';
        
   
        fetch('chatback.php', {
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
        fetch(`chatback.php?action=receber&usuario_id=${usuarioId}&ultimo_id=${ultimaMensagemId}`)
            .then(response => response.json())
            .then(data => {
                if (data.mensagens && data.mensagens.length > 0) {
                    data.mensagens.forEach(msg => {
                        adicionarMensagem(msg.mensagem, msg.remetente, msg.hora);
                        ultimaMensagemId = Math.max(ultimaMensagemId, msg.id);
                    });
                    rolarParaBaixo();
                    
             
                    if (data.mensagens.some(msg => msg.remetente === 'admin')) {
                        fetch('chatback.php', {
                            method: 'POST',
                            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                            body: `action=marcar_lida&usuario_id=${usuarioId}`
                        });
                    }
                }
            })
            .catch(error => console.error('Erro:', error));
    }

    function adicionarMensagem(texto, remetente, hora) {
        const chatBox = document.getElementById('chatBox');
        const div = document.createElement('div');
        
        if (remetente === 'usuario') {
            div.className = 'msg-usuario';
            div.innerHTML = `
                <div><strong>Você:</strong> ${texto}</div>
                <div class="msg-info">${hora}</div>
            `;
        } else if (remetente === 'admin') {
            div.className = 'msg-admin';
            div.innerHTML = `
                <div><strong>Admin:</strong> ${texto}</div>
                <div class="msg-info">${hora}</div>
            `;
        }
        
        chatBox.appendChild(div);
    }

    function rolarParaBaixo() {
        const chatBox = document.getElementById('chatBox');
        chatBox.scrollTop = chatBox.scrollHeight;
    }

  
   
    
   
    carregarMensagens();
</script>
</body>
</html>