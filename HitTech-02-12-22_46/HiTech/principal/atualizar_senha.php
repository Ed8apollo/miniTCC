<?php
session_start();
header("Content-Type: application/json");

error_log("=== ATUALIZAR SENHA (MD5) ===");


if (!isset($_SESSION['email_recuperacao'])) {
    echo json_encode(["status" => "error", "message" => "Sessão expirada"]);
    exit;
}

$email = $_SESSION['email_recuperacao'];
$nova_senha = $_POST['senha'] ?? '';
$confirmar_senha = $_POST['confirmar'] ?? '';

error_log("E-mail: " . $email);
error_log("Nova senha recebida: " . $nova_senha);


if (empty($nova_senha) || empty($confirmar_senha)) {
    echo json_encode(["status" => "error", "message" => "Preencha todos os campos"]);
    exit;
}

if ($nova_senha !== $confirmar_senha) {
    echo json_encode(["status" => "error", "message" => "As senhas não coincidem"]);
    exit;
}

if (strlen($nova_senha) < 6) {
    echo json_encode(["status" => "error", "message" => "Senha deve ter no mínimo 6 caracteres"]);
    exit;
}


$host = "localhost";
$dbname = "estoquehitech";  
$username = "root";          
$password = "";            

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    
    $senha_md5 = md5($nova_senha);
    error_log("Senha MD5 gerada: " . $senha_md5);
    
   
    $stmt = $pdo->prepare("UPDATE usuarios SET senha = :senha WHERE email = :email");
    $stmt->bindParam(':senha', $senha_md5);
    $stmt->bindParam(':email', $email);
    
    $result = $stmt->execute();
    
    if ($result && $stmt->rowCount() > 0) {
        error_log("✅ Senha atualizada para: " . $email);
        
    
        unset($_SESSION['codigo_recuperacao']);
        unset($_SESSION['email_recuperacao']);
        unset($_SESSION['codigo_expira']);
        
        echo json_encode([
            "status" => "ok",
            "message" => "✅ Senha alterada com sucesso! Você já pode fazer login com a nova senha."
        ]);
    } else {
        error_log("❌ Nenhum usuário encontrado: " . $email);
        echo json_encode([
            "status" => "error", 
            "message" => "❌ E-mail não encontrado no sistema."
        ]);
    }
    
} catch(PDOException $e) {
    error_log("❌ Erro no banco: " . $e->getMessage());
    echo json_encode([
        "status" => "error",
        "message" => "❌ Erro no sistema. Tente novamente mais tarde.",
        "debug" => $e->getMessage()
    ]);
}
?>