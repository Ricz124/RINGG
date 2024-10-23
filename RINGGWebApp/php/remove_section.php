<?php
include '../session_start.php';  // Iniciar sessão
require 'db_connections.php';    // Conexão com o banco de dados

// Verificar se o método é POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'Método HTTP inválido.']);
    exit;
}

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

// Verificar se o ID da seção foi enviado e não está vazio
$sectionId = isset($data['sectionId']) ? trim($data['sectionId']) : null;
if (empty($sectionId)) {
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'ID da seção não pode estar vazio.']);
    exit;
}

// Prepare a remoção da seção no banco de dados
$userId = $_SESSION['user_id'];
$stmt = $pdo->prepare("DELETE FROM sections WHERE id = :sectionId AND user_id = :userId");

try {
    // Executa a consulta
    $stmt->execute([':sectionId' => $sectionId, ':userId' => $userId]);

    // Verifica se alguma linha foi afetada (remoção bem-sucedida)
    if ($stmt->rowCount() > 0) {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'success', 'message' => 'Seção removida com sucesso.']);
    } else {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'Seção não encontrada ou não pertence ao usuário.']);
    }
} catch (PDOException $e) {
    // Tratamento de erro ao executar a consulta
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'Erro ao remover seção: ' . $e->getMessage()]);
    exit;
}
?>
