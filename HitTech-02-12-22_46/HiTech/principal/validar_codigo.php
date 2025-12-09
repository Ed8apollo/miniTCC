<?php
session_start();
header("Content-Type: application/json");

error_log("=== VALIDAR CÓDIGO CHAMADO ===");

$codigo_digitado = $_POST['codigo'] ?? '';

error_log("Código digitado: " . $codigo_digitado);

if (empty($codigo_digitado)) {
    echo json_encode(["status" => "error", "message" => "Digite o código"]);
    exit;
}


if (!isset($_SESSION['codigo_recuperacao'])) {
    error_log("ERRO: Sessão não encontrada");
    echo json_encode(["status" => "error", "message" => "Sessão expirada. Reenvie o código."]);
    exit;
}

error_log("Código na sessão: " . $_SESSION['codigo_recuperacao']);
error_log("E-mail na sessão: " . ($_SESSION['email_recuperacao'] ?? 'não encontrado'));


if (time() > ($_SESSION['codigo_expira'] ?? 0)) {
    error_log("ERRO: Código expirado");
    echo json_encode(["status" => "error", "message" => "Código expirado. Reenvie o código."]);
    exit;
}


if ($codigo_digitado != $_SESSION['codigo_recuperacao']) {
    error_log("ERRO: Código inválido. Digitado: $codigo_digitado, Esperado: " . $_SESSION['codigo_recuperacao']);
    echo json_encode(["status" => "error", "message" => "Código inválido"]);
    exit;
}

error_log("✅ Código validado com sucesso!");
echo json_encode([
    "status" => "ok",
    "message" => "Código validado com sucesso!"
]);
?>