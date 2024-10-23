<?php
include '../session_start.php';
include 'db_connections.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json'); // Define o tipo de resposta como JSON

// Verifica se o usuário está autenticado
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Usuário não autenticado.']);
    exit;
}

// Obtém os dados da requisição
$data = json_decode(file_get_contents('php://input'), true);

// Verifica se o ID da seção foi fornecido
if (!isset($data['sectionId'])) {
    echo json_encode(['status' => 'error', 'message' => 'ID da seção não fornecido.']);
    exit;
}

// Obtém o ID da seção a ser removida
$sectionId = $data['sectionId'];
$userId = $_SESSION['user_id'];

// Verifica se a seção pertence ao usuário
$stmt = $pdo->prepare("SELECT * FROM sections WHERE id = ? AND user_id = ?");
$stmt->execute([$sectionId, $userId]);
$section = $stmt->fetch();

if (!$section) {
    echo json_encode(['status' => 'error', 'message' => 'Seção não encontrada.']);
    exit;
}

// Remove a seção do banco de dados
$stmt = $pdo->prepare("DELETE FROM sections WHERE id = ? AND user_id = ?");
$stmt->execute([$sectionId, $userId]);

// Verifica se a remoção foi bem-sucedida
if ($stmt->rowCount() > 0) {
    echo json_encode(['status' => 'success', 'message' => 'Seção removida com sucesso.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Erro ao remover a seção.']);
}
