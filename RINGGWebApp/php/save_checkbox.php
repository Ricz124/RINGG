<?php

include '../session_start.php';
include('db_connections.php');

if (!isset($_SESSION['user_id'])) {
    die("Usuário não autenticado.");
}

$data = json_decode(file_get_contents('php://input'), true);



if (json_last_error() !== JSON_ERROR_NONE) {
    die("Erro ao decodificar JSON: " . json_last_error_msg());
}

$sectionId = $data['sectionId'] ?? null;
$label = trim($data['label'] ?? '');
$checked = isset($data['checked']) ? ($data['checked'] ? 1 : 0) : 0;

// Validações
if (is_null($sectionId) || !is_numeric($sectionId)) {
    die("ID da seção inválido.");
}

if (empty($label)) {
    die("Rótulo do checkbox não pode estar vazio.");
}

// Inserir checkbox no banco de dados
$stmt = $pdo->prepare("INSERT INTO checkboxes (section_id, checkbox_label, checkbox_state) VALUES (?, ?, ?)");

try {
    $stmt->execute([$sectionId, $label, $checked]);
    echo json_encode(['status' => 'success']);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

?>
