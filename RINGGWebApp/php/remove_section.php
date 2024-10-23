<?php
include '../session_start.php'; // Inclua o arquivo de sessão
include('db_connections.php'); // Conexão com o banco de dados

// Verifica se o usuário está autenticado
if (!isset($_SESSION['user_id'])) {
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'Usuário não autenticado.']);
    exit;
}

// Obtém o ID do usuário da sessão
$userId = $_SESSION['user_id'];

// Lógica para remover uma seção (você deve implementar isso)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['section_id'])) {
    $sectionId = $_POST['section_id'];

    // Exemplo de consulta para remover a seção do banco de dados
    $stmt = $pdo->prepare("DELETE FROM sections WHERE id = ? AND user_id = ?");
    $result = $stmt->execute([$sectionId, $userId]);

    if ($result) {
        // Retorna uma resposta JSON indicando sucesso
        header('Content-Type: application/json');
        echo json_encode(['status' => 'success', 'message' => 'Seção removida com sucesso.']);
    } else {
        // Retorna um erro se a remoção falhar
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'Erro ao remover a seção.']);
    }
    exit; // Certifique-se de sair após retornar a resposta
}

// Se não for uma requisição de POST ou seção_id não estiver definido
header('Content-Type: application/json');
echo json_encode(['status' => 'error', 'message' => 'Requisição inválida.']);
?>
