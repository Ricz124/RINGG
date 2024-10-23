<?php
include '../session_start.php';
require 'db_connections.php'; // Conexão com o banco de dados

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

// Obtém e limpa o ID da seção
$sectionId = trim($data['sectionId']);
if (empty($sectionId)) {
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'ID da seção não pode estar vazio.']);
    exit;
}

// Prepare a remoção no banco de dados
$userId = $_SESSION['user_id'];
$stmt = $pdo->prepare("DELETE FROM sections WHERE id = ? AND user_id = ?");

try {
    // Executa a consulta
    $stmt->execute([$sectionId, $userId]);

    // Verifica se alguma linha foi afetada
    if ($stmt->rowCount() > 0) {
        echo json_encode(['status' => 'success', 'message' => 'Seção removida com sucesso.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Seção não encontrada ou não pertence ao usuário.']);
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Houve um erro ao processar: ' . $e->getMessage()]);
}
?>
