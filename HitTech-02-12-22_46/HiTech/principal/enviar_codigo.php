<?php
session_start();
header("Content-Type: application/json");


error_log("=== DEBUG ENVIAR_CODIGO INICIADO ===");
error_log("Método: " . $_SERVER['REQUEST_METHOD']);
error_log("POST recebido: " . print_r($_POST, true));
error_log("GET recebido: " . print_r($_GET, true));
error_log("Headers: " . print_r(getallheaders(), true));


$rawInput = file_get_contents("php://input");
error_log("Input bruto: " . $rawInput);


$data = json_decode($rawInput, true);
if ($data) {
    error_log("JSON decodificado: " . print_r($data, true));
    $_POST = array_merge($_POST, $data);
}


$email = '';
if (isset($_POST['email'])) {
    $email = trim($_POST['email']);
} elseif (isset($_GET['email'])) {
    $email = trim($_GET['email']);
} elseif ($rawInput && strpos($rawInput, 'email=') !== false) {
   
    parse_str($rawInput, $parsed);
    $email = isset($parsed['email']) ? trim($parsed['email']) : '';
}

error_log("E-mail extraído: '$email'");
error_log("E-mail válido? " . (filter_var($email, FILTER_VALIDATE_EMAIL) ? 'SIM' : 'NÃO'));


if (empty($email)) {
    error_log("ERRO: E-mail vazio");
    echo json_encode([
        "status" => "error", 
        "message" => "E-mail não recebido",
        "debug" => [
            "post" => $_POST,
            "get" => $_GET,
            "input" => $rawInput,
            "email_recebido" => $email
        ]
    ]);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    error_log("ERRO: E-mail inválido: $email");
    echo json_encode([
        "status" => "error", 
        "message" => "Formato de e-mail inválido: $email",
        "debug" => "E-mail recebido: '$email'"
    ]);
    exit;
}


$codigo = rand(100000, 999999);


$_SESSION['codigo_recuperacao'] = $codigo;
$_SESSION['email_recuperacao'] = $email;
$_SESSION['codigo_expira'] = time() + 600;

error_log("SUCESSO: Código $codigo gerado para $email");


echo json_encode([
    "status" => "ok",
    "codigo" => $codigo,
    "message" => "Código gerado com sucesso!",
    "email" => $email,
    "debug" => [
        "session_id" => session_id(),
        "timestamp" => date('H:i:s')
    ]
]);

error_log("=== DEBUG ENVIAR_CODIGO FINALIZADO ===");
?>