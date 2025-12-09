<?php
session_start();
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');

require 'config.php';

// Verificar se usuário está logado
if (!isset($_SESSION['logado'])) {
    echo json_encode(['error' => 'Não autorizado']);
    exit;
}

$action = $_GET['action'] ?? $_POST['action'] ?? '';

switch($action) {
    case 'enviar':
        enviarMensagem($conn);
        break;
    case 'receber':
        receberMensagens($conn);
        break;
    case 'marcar_lida':
        marcarComoLida($conn);
        break;
    case 'listar_usuarios':
        listarUsuarios($conn);
        break;
    default:
        echo json_encode(['error' => 'Ação não especificada']);
}

function enviarMensagem($conn) {
    $mensagem = $_POST['mensagem'] ?? '';
    $remetente = $_POST['remetente'] ?? 'admin';
    $usuario_id = $_POST['usuario_id'] ?? 0;
    
    if (empty($mensagem)) {
        echo json_encode(['error' => 'Mensagem vazia']);
        return;
    }
    
    $mensagem = trim($mensagem);
    $mensagem = htmlspecialchars($mensagem, ENT_QUOTES, 'UTF-8');
    
    if ($usuario_id == 0) {
        echo json_encode(['error' => 'Usuário não selecionado']);
        return;
    }
    
    $stmt = $conn->prepare("INSERT INTO mensagens_chat (usuario_id, mensagem, remetente) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $usuario_id, $mensagem, $remetente);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'id' => $stmt->insert_id]);
    } else {
        // Se a tabela não existir, criar automaticamente
        if ($conn->errno == 1146) { // Table doesn't exist
            criarTabelaMensagens($conn);
            // Tentar novamente
            $stmt = $conn->prepare("INSERT INTO mensagens_chat (usuario_id, mensagem, remetente) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $usuario_id, $mensagem, $remetente);
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'id' => $stmt->insert_id]);
            } else {
                echo json_encode(['error' => 'Erro ao enviar mensagem: ' . $conn->error]);
            }
        } else {
            echo json_encode(['error' => 'Erro ao enviar mensagem: ' . $conn->error]);
        }
    }
}

function receberMensagens($conn) {
    $usuario_id = $_GET['usuario_id'] ?? 0;
    $ultimo_id = $_GET['ultimo_id'] ?? 0;
    
    if ($usuario_id == 0) {
        echo json_encode(['error' => 'Usuário não selecionado']);
        return;
    }
    
    // Verificar se a tabela existe
    $table_check = $conn->query("SHOW TABLES LIKE 'mensagens_chat'");
    if ($table_check->num_rows == 0) {
        criarTabelaMensagens($conn);
        echo json_encode(['mensagens' => []]);
        return;
    }
    
    $stmt = $conn->prepare("
        SELECT id, mensagem, remetente, DATE_FORMAT(data_envio, '%H:%i') as hora 
        FROM mensagens_chat 
        WHERE usuario_id = ? AND id > ? 
        ORDER BY data_envio ASC
    ");
    
    if (!$stmt) {
        echo json_encode(['error' => 'Erro na preparação da query: ' . $conn->error]);
        return;
    }
    
    $stmt->bind_param("ii", $usuario_id, $ultimo_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $mensagens = [];
    while ($row = $result->fetch_assoc()) {
        $mensagens[] = $row;
    }
    
    echo json_encode(['mensagens' => $mensagens]);
}

function marcarComoLida($conn) {
    $usuario_id = $_POST['usuario_id'] ?? 0;
    
    if ($usuario_id == 0) return;
    
    $stmt = $conn->prepare("UPDATE mensagens_chat SET lida = TRUE WHERE usuario_id = ? AND remetente = 'usuario'");
    
    if (!$stmt) {
        echo json_encode(['error' => 'Erro na preparação da query']);
        return;
    }
    
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    
    echo json_encode(['success' => true]);
}

function listarUsuarios($conn) {
  
    if (!isset($_SESSION['nivel']) || $_SESSION['nivel'] != 'admin') {
        echo json_encode(['error' => 'Acesso negado']);
        return;
    }
    
    try {
        $admin_id = $_SESSION['id'] ?? 0;
        
        $table_check = $conn->query("SHOW TABLES LIKE 'usuarios'");
        if ($table_check->num_rows == 0) {
            echo json_encode(['error' => 'Tabela de usuários não encontrada']);
            return;
        }
        
        
        $column_check = $conn->query("SHOW COLUMNS FROM usuarios LIKE 'nivel'");
        $has_nivel = $column_check->num_rows > 0;
        
       
        $email_check = $conn->query("SHOW COLUMNS FROM usuarios LIKE 'email'");
        $has_email = $email_check->num_rows > 0;
        
        if ($has_nivel) {
            
            if ($has_email) {
                $query = "SELECT id, nome, email FROM usuarios WHERE nivel = 'usuario' AND id != ? ORDER BY nome";
            } else {
                $query = "SELECT id, nome, '' as email FROM usuarios WHERE nivel = 'usuario' AND id != ? ORDER BY nome";
            }
        } else {
       
            if ($has_email) {
                $query = "SELECT id, nome, email FROM usuarios WHERE id != ? ORDER BY nome";
            } else {
                $query = "SELECT id, nome, '' as email FROM usuarios WHERE id != ? ORDER BY nome";
            }
        }
        
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            echo json_encode(['error' => 'Erro na preparação: ' . $conn->error]);
            return;
        }
        
        $stmt->bind_param("i", $admin_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $usuarios = [];
        while ($row = $result->fetch_assoc()) {
           
            $nao_lidas = 0;
            $count_stmt = $conn->prepare("SELECT COUNT(*) as total FROM mensagens_chat WHERE usuario_id = ? AND remetente = 'usuario' AND lida = FALSE");
            if ($count_stmt) {
                $count_stmt->bind_param("i", $row['id']);
                $count_stmt->execute();
                $count_result = $count_stmt->get_result();
                if ($count_row = $count_result->fetch_assoc()) {
                    $nao_lidas = $count_row['total'];
                }
            }
            
            $usuarios[] = [
                'id' => $row['id'],
                'nome' => $row['nome'],
                'email' => $row['email'] ?: 'Sem email',
                'nao_lidas' => intval($nao_lidas)
            ];
        }
        
        echo json_encode(['usuarios' => $usuarios]);
        
    } catch (Exception $e) {
        echo json_encode(['error' => 'Erro: ' . $e->getMessage()]);
    }
}

function criarTabelaMensagens($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS mensagens_chat (
        id INT PRIMARY KEY AUTO_INCREMENT,
        usuario_id INT NOT NULL,
        mensagem TEXT NOT NULL,
        remetente ENUM('usuario', 'admin') NOT NULL,
        lida BOOLEAN DEFAULT FALSE,
        data_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    return $conn->query($sql);
}

$conn->close();
?>