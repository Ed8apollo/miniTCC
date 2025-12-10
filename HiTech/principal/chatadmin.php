<?php
session_start();
if (!isset($_SESSION['logado']) || $_SESSION['nivel'] != 'admin') {
    header("Location: valida_login.php");
    exit;
}

require 'config.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Chat Admin - HiTech</title>
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
            margin-top: auto;
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
            float: left;
            clear: both;
        }
        .msg-admin {
            background: #d4edda;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 10px;
            max-width: 80%;
            float: right;
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
        .user-list {
            margin-top: 20px;
            flex: 1;
            overflow-y: auto;
            max-height: 400px;
        }
        .user-item {
            padding: 10px 15px;
            margin-bottom: 8px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .user-item:hover {
            background: rgba(255, 255, 255, 0.2);
        }
        .user-item.active {
            background: rgba(255, 255, 255, 0.3);
            border-left: 4px solid white;
        }
        .user-name {
            font-weight: 500;
            color: white;
        }
        .user-email {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 0;
        }
        .badge-new {
            background: #ff6b6b;
            color: white;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 11px;
            float: right;
        }
        .user-info {
            background: #f0f8ff;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
            border-left: 4px solid #2842b6;
        }
        .no-user-selected {
            text-align: center;
            padding: 50px 20px;
            color: #666;
        }
        .loading {
            text-align: center;
            padding: 20px;
            color: rgba(255, 255, 255, 0.8);
        }
        .btn-refresh {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 8px 15px;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            margin-top: 10px;
        }
        .btn-refresh:hover {
            background: rgba(255, 255, 255, 0.3);
        }
    </style>
</head>
<body>

<div class="main-card">
    <div class="row g-0 align-items-start">
        <div class="col-md-4">
            <div class="welcome-section">
                <div class="text-center">
                    <h4 class="mb-3">Chat Admin</h4>
                    <p class="mb-0">Converse com Usuários</p>
                    <p class="mb-0 mt-3"><small>Admin: <?= $_SESSION['nome']; ?> 👑</small></p>
                </div>
                
                <div class="user-list">
                    <h6 class="text-white mb-3">Usuários Cadastrados</h6>
                    <div id="usuariosLista">
                        <div class="loading">Carregando usuários...</div>
                    </div>
                </div>
                
                <button class="btn-refresh" onclick="carregarUsuarios()">
                    ↻ Atualizar Lista
                </button>
            </div>
        </div>

        <div class="col-md-8">
            <div class="menu-section">
                <h3 class="social-title">Chat com Usuário</h3>
                
                <div id="userInfo" class="user-info" style="display: none;">
                    <h5 id="userName">Selecione um usuário</h5>
                    <p id="userEmail" class="mb-1">Email do usuário</p>
                    <small id="userNewMessages" class="text-danger"></small>
                </div>

                <div class="chat-box" id="chatBox">
                    <div class="no-user-selected" id="noUserSelected">
                        <h5>Selecione um usuário</h5>
                        <p>Escolha um usuário na lista à esquerda para começar a conversar</p>
                    </div>
                </div>

                <div class="chat-input">
                    <input type="text" id="msgInput" placeholder="Digite sua mensagem..." disabled>
                    <button onclick="enviarMensagem()" id="sendButton" disabled>Enviar</button>
                </div>

                <div class="col-12 text-center mt-3">
                    <a href="painel_admin.php" class="btn btn-outline-secondary">
                        ← Voltar para o Painel Admin
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let ultimaMensagemId = 0;
    let usuarioAtual = null;
    let usuariosLista = [];
    let intervaloAtualizacao = null;

   
    document.addEventListener('DOMContentLoaded', function() {
        carregarUsuarios();
    });

    function carregarUsuarios() {
        document.getElementById('usuariosLista').innerHTML = 
            '<div class="loading">Carregando usuários...</div>';
        
        fetch('chatback.php?action=listar_usuarios')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erro na resposta do servidor');
                }
                return response.json();
            })
            .then(data => {
                console.log('Resposta do servidor:', data);
                
                if (data.error) {
                    document.getElementById('usuariosLista').innerHTML = 
                        `<div class="loading">Erro: ${data.error}</div>`;
                    return;
                }
                
                if (data.usuarios && data.usuarios.length > 0) {
                    usuariosLista = data.usuarios;
                    preencherListaUsuarios(data.usuarios);
                    
                
                    const usuarioComMensagens = data.usuarios.find(u => u.nao_lidas > 0);
                    if (usuarioComMensagens && !usuarioAtual) {
                        selecionarUsuario(usuarioComMensagens.id);
                    } else if (!usuarioAtual && data.usuarios.length > 0) {
                       
                        selecionarUsuario(data.usuarios[0].id);
                    }
                } else {
                    document.getElementById('usuariosLista').innerHTML = 
                        `<div class="loading">Nenhum usuário cadastrado</div>`;
                }
            })
            .catch(error => {
                console.error('Erro ao carregar usuários:', error);
                document.getElementById('usuariosLista').innerHTML = 
                    `<div class="loading">Erro ao conectar com o servidor</div>`;
            });
    }

    function preencherListaUsuarios(usuarios) {
        const lista = document.getElementById('usuariosLista');
        lista.innerHTML = '';
        
        usuarios.forEach(usuario => {
            const div = document.createElement('div');
            div.className = `user-item ${usuario.id == usuarioAtual ? 'active' : ''}`;
            div.onclick = () => selecionarUsuario(usuario.id);
            
            let badge = '';
            if (usuario.nao_lidas > 0) {
                badge = `<span class="badge-new">${usuario.nao_lidas}</span>`;
            }
            
            div.innerHTML = `
                <div class="user-name">${usuario.nome} ${badge}</div>
                <p class="user-email">${usuario.email || 'Sem email'}</p>
            `;
            
            lista.appendChild(div);
        });
    }

    function selecionarUsuario(id) {
        usuarioAtual = id;
        ultimaMensagemId = 0;
        
     
        document.querySelectorAll('.user-item').forEach(item => {
            item.classList.remove('active');
        });
        document.querySelectorAll('.user-item').forEach(item => {
            if (item.onclick && item.onclick.toString().includes(id)) {
                item.classList.add('active');
            }
        });
        
       
        const usuario = usuariosLista.find(u => u.id == id);
        if (usuario) {
            document.getElementById('userInfo').style.display = 'block';
            document.getElementById('userName').textContent = `Conversando com: ${usuario.nome}`;
            document.getElementById('userEmail').textContent = usuario.email || 'Sem email cadastrado';
            
            if (usuario.nao_lidas > 0) {
                document.getElementById('userNewMessages').textContent = 
                    `${usuario.nao_lidas} mensagem(s) não lida(s)`;
            } else {
                document.getElementById('userNewMessages').textContent = '';
            }
        }
        

        document.getElementById('msgInput').disabled = false;
        document.getElementById('sendButton').disabled = false;
        document.getElementById('noUserSelected').style.display = 'none';
        

        document.getElementById('chatBox').innerHTML = '';
        carregarMensagens();
        
      
        iniciarAtualizacaoAutomatica();
    }

    function carregarMensagens() {
        if (!usuarioAtual) return;
        
        fetch(`chatback.php?action=receber&usuario_id=${usuarioAtual}&ultimo_id=${ultimaMensagemId}`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    console.error('Erro:', data.error);
                    return;
                }
                
                if (data.mensagens && data.mensagens.length > 0) {
                    data.mensagens.forEach(msg => {
                        adicionarMensagem(msg.mensagem, msg.remetente, msg.hora);
                        ultimaMensagemId = Math.max(ultimaMensagemId, msg.id);
                    });
                    rolarParaBaixo();
                    
                
                    if (data.mensagens.some(msg => msg.remetente === 'usuario')) {
                        fetch('chatback.php', {
                            method: 'POST',
                            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                            body: `action=marcar_lida&usuario_id=${usuarioAtual}`
                        }).then(() => {
                          
                            carregarUsuarios();
                        });
                    }
                }
            })
            .catch(error => console.error('Erro:', error));
    }

    function adicionarMensagem(texto, remetente, hora) {
        const chatBox = document.getElementById('chatBox');
        
    
        const noUserMsg = document.getElementById('noUserSelected');
        if (noUserMsg) {
            noUserMsg.style.display = 'none';
        }
        
        const div = document.createElement('div');
        
        if (remetente === 'usuario') {
            div.className = 'msg-usuario';
            div.innerHTML = `
                <div><strong>Usuário:</strong> ${texto}</div>
                <div class="msg-info">${hora}</div>
            `;
        } else if (remetente === 'admin') {
            div.className = 'msg-admin';
            div.innerHTML = `
                <div><strong>Você:</strong> ${texto}</div>
                <div class="msg-info">${hora}</div>
            `;
        }
        
        chatBox.appendChild(div);
    }

    function enviarMensagem() {
        if (!usuarioAtual) {
            alert('Selecione um usuário primeiro!');
            return;
        }
        
        const input = document.getElementById('msgInput');
        const mensagem = input.value.trim();
        
        if (!mensagem) return;
        
        
        const hora = new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
        adicionarMensagem(mensagem, 'admin', hora);
        input.value = '';
        
      
        fetch('chatback.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `action=enviar&usuario_id=${usuarioAtual}&mensagem=${encodeURIComponent(mensagem)}&remetente=admin`
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                console.error('Erro ao enviar:', data.error);
            }
            rolarParaBaixo();
        })
        .catch(error => console.error('Erro:', error));
    }

    function rolarParaBaixo() {
        const chatBox = document.getElementById('chatBox');
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    function iniciarAtualizacaoAutomatica() {
 
        if (intervaloAtualizacao) {
            clearInterval(intervaloAtualizacao);
        }
        
       
    }

    
    document.getElementById('msgInput').addEventListener('keypress', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            enviarMensagem();
        }
    });

</script>
</body>
</html>