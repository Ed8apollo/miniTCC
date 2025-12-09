<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/login.css"> 
    <title>Login - Estoque HiTech</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="main-card">
        <div class="row g-0">
            <div class="col-md-5">
                <div class="welcome-section">
                    <div class="text-center">
                        <img src="img/user.jpg" 
                             alt="Imagem Login" 
                             style="width:120px; height:120px; margin-bottom:20px;">
                        <h3 class="mb-3">Login</h3>
                        <p class="mb-0">Sistema de controle de estoque</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-7">
                <div class="menu-section">
                    <h3 class="text-center mb-4 text-dark">Acesso ao Sistema</h3>
                    
                    <form action="valida_login.php" method="post">
                        <div class="mb-3">
                            <input type="email" name="email" class="form-control" placeholder="E-mail" required>
                        </div>
                        <div class="mb-4">
                            <input type="password" name="senha" class="form-control" placeholder="Senha" required>
                        </div>
                        
                        <button type="submit" class="menu-btn btn-lg">
                            Entrar no Sistema
                        </button>

                       
                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modalRecuperarSenha">
                            Esqueci a senha
                        </button>

                        <br> <br> <br> <br> <br> 
                        <div class="row g-3 mt-4">
                            <div class="col-md-6">
                                <a href="cadastrarusuario.php" class="menu-btn">
                                    ← Cadastrar-se
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="telainicial.php" class="menu-btn">
                                    ← Voltar ao Início
                                </a>
                            </div>
                            
                            <?php if(isset($_SESSION['erro'])): ?>
                                <div class="stats-card mt-3 text-center">
                                    <h6 class="mb-1 text-danger">⚠️ Acesso Negado</h6>
                                    <p class="mb-0">
                                        <?= $_SESSION['erro']; unset($_SESSION['erro']); ?>
                                    </p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </form>
                    
                    <div class="text-center mt-4">
                        <p class="text-muted">
                            Entre com suas credenciais para acessar o sistema
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

 
    <div class="modal fade" id="modalRecuperarSenha" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Recuperar Senha</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                
                <div class="modal-body">
                   
                    <div id="etapaEmail">
                        <div class="mb-3">
                            <label class="form-label">Digite seu e-mail:</label>
                            <input type="email" id="emailRecuperacao" class="form-control" placeholder="seuemail@exemplo.com">
                        </div>
                        <button class="btn btn-primary w-100" onclick="enviarCodigo()">Enviar código</button>
                    </div>
                    
                    
                    <div id="etapaCodigo" style="display: none;">
                        <p class="mb-3">Enviamos um código para seu e-mail. Digite abaixo:</p>
                        <div class="mb-3">
                            <input type="text" id="codigoDigitado" class="form-control" maxlength="6" placeholder="000000">
                        </div>
                        <button class="btn btn-success w-100" onclick="validarCodigo()">Validar código</button>
                    </div>
                    
                    
                    <div id="etapaNovaSenha" style="display: none;">
                        <div class="mb-3">
                            <label class="form-label">Nova senha:</label>
                            <input type="password" id="novaSenha" class="form-control" placeholder="Mínimo 6 caracteres">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Confirmar senha:</label>
                            <input type="password" id="confirmarSenha" class="form-control" placeholder="Digite novamente">
                        </div>
                        <button class="btn btn-success w-100" onclick="salvarNovaSenha()">Salvar nova senha</button>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

 
    <script>
   
    function mostrarApenasEtapa(etapaId) {
       
        document.getElementById("etapaEmail").style.display = "none";
        document.getElementById("etapaCodigo").style.display = "none";
        document.getElementById("etapaNovaSenha").style.display = "none";
        
      
        document.getElementById(etapaId).style.display = "block";
    }


    function enviarCodigo() {
        const email = document.getElementById("emailRecuperacao").value.trim();
        
        if (!email || !email.includes("@")) {
            alert("Digite um e-mail válido!");
            return;
        }

       
        const btn = event.target;
        const originalText = btn.innerHTML;
        btn.innerHTML = 'Enviando...';
        btn.disabled = true;

        fetch("enviar_codigo.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "email=" + encodeURIComponent(email)
        })
        .then(response => response.json())
        .then(data => {
            btn.innerHTML = originalText;
            btn.disabled = false;
            
            if (data.status === "ok") {
                alert(`Código gerado: ${data.codigo}\n\nUse este código para continuar.`);
                mostrarApenasEtapa("etapaCodigo");
                setTimeout(() => {
                    document.getElementById("codigoDigitado").focus();
                }, 100);
            } else {
                alert("Erro: " + data.message);
            }
        })
        .catch(error => {
            console.error("Erro:", error);
            btn.innerHTML = originalText;
            btn.disabled = false;
            alert("Erro na conexão");
        });
    }


    function validarCodigo() {
        const codigo = document.getElementById("codigoDigitado").value.trim();
        
        if (!codigo || codigo.length !== 6) {
            alert("Digite o código de 6 dígitos!");
            return;
        }

        const btn = event.target;
        const originalText = btn.innerHTML;
        btn.innerHTML = 'Validando...';
        btn.disabled = true;

        fetch("validar_codigo.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "codigo=" + encodeURIComponent(codigo)
        })
        .then(response => response.json())
        .then(data => {
            btn.innerHTML = originalText;
            btn.disabled = false;
            
            if (data.status === "ok") {
                mostrarApenasEtapa("etapaNovaSenha");
                document.getElementById("novaSenha").focus();
            } else {
                alert("Erro: " + data.message);
            }
        })
        .catch(error => {
            console.error("Erro:", error);
            btn.innerHTML = originalText;
            btn.disabled = false;
            alert("Erro na conexão");
        });
    }

   
    function salvarNovaSenha() {
        const senha = document.getElementById("novaSenha").value;
        const confirmar = document.getElementById("confirmarSenha").value;

        if (!senha || !confirmar) {
            alert("Preencha todos os campos!");
            return;
        }
        if (senha !== confirmar) {
            alert("As senhas não coincidem!");
            return;
        }
        if (senha.length < 6) {
            alert("A senha deve ter pelo menos 6 caracteres!");
            return;
        }

        const btn = event.target;
        const originalText = btn.innerHTML;
        btn.innerHTML = 'Salvando...';
        btn.disabled = true;

        fetch("atualizar_senha.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "senha=" + encodeURIComponent(senha) + 
                "&confirmar=" + encodeURIComponent(confirmar)
        })
        .then(response => response.json())
        .then(data => {
            btn.innerHTML = originalText;
            btn.disabled = false;
            
            if (data.status === "ok") {
                alert(data.message);
                const modalEl = document.getElementById('modalRecuperarSenha');
                const modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) modal.hide();
                limparModal();
                mostrarApenasEtapa("etapaEmail");
            } else {
                alert("Erro: " + data.message);
            }
        })
        .catch(error => {
            console.error("Erro:", error);
            btn.innerHTML = originalText;
            btn.disabled = false;
            alert("Erro na conexão");
        });
    }

   
    function limparModal() {
        document.getElementById("emailRecuperacao").value = "";
        document.getElementById("codigoDigitado").value = "";
        document.getElementById("novaSenha").value = "";
        document.getElementById("confirmarSenha").value = "";
    }


    document.addEventListener('DOMContentLoaded', function() {
        const modalEl = document.getElementById('modalRecuperarSenha');
        
        if (modalEl) {
          
            modalEl.addEventListener('show.bs.modal', function () {
                mostrarApenasEtapa("etapaEmail");
                limparModal();
                setTimeout(() => {
                    document.getElementById("emailRecuperacao").focus();
                }, 300);
            });
            
  
            modalEl.addEventListener('hidden.bs.modal', function () {
                limparModal();
                mostrarApenasEtapa("etapaEmail");
            });
        }
    });
    </script>

</body>
</html>