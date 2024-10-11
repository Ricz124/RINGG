<?php
include '../session_start.php';
require 'db_connections.php';

// Verificar se o usuário está autenticado
if (!isset($_SESSION['user_id'])) {
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'Usuário não autenticado.']);
    exit;
}

// Captura e decodifica a entrada JSON
$data = json_decode(file_get_contents('php://input'), true);

// Verificar se houve erro na decodificação JSON
if (json_last_error() !== JSON_ERROR_NONE) {
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'Erro ao decodificar JSON: ' . json_last_error_msg()]);
    exit;
}

// Obtém e limpa o título da seção
$sectionTitle = trim($data['sectionTitle']);
if (empty($sectionTitle)) {
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'Título da seção não pode estar vazio.']);
    exit;
}

// Prepare a inserção no banco de dados
$userId = $_SESSION['user_id'];
$stmt = $pdo->prepare("INSERT INTO sections (user_id, section_title) VALUES (?, ?)");

try {
    $stmt->execute([$userId, $sectionTitle]);
    echo json_encode(['status' => 'success', 'message' => 'Seção salva com sucesso.', 'sectionId' => $pdo->lastInsertId()]);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Houve um erro ao processar: ' . $e->getMessage()]);
}
?>
