<?php
include '../session_start.php'; // Inclua o arquivo de sessão
include('db_connections.php'); // Conexão com o banco de dados

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'Método HTTP inválido.']);
    exit;
}

// Verifica se o usuário está autenticado
if (!isset($_SESSION['user_id'])) {
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'Usuário não autenticado.']);
    exit;
}

// Obtém o ID do usuário da sessão
$userId = $_SESSION['user_id'];

// Prepara a consulta SQL para buscar as seções do usuário
$stmt = $pdo->prepare("SELECT * FROM sections WHERE user_id = ?");
$stmt->execute([$userId]);

// Obtém os resultados
$sections = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Retorna os resultados em formato JSON
header('Content-Type: application/json');
echo json_encode(['status' => 'success', 'sections' => $sections]);
?>
