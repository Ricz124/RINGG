<?php
include '../session_start.php'; // Inclua o arquivo de sessão
include('db_connections.php'); // Conexão com o banco de dados

// Habilita a exibição de erros
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verifica se o usuário está autenticado
if (!isset($_SESSION['user_id'])) {
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'Usuário não autenticado.']);
    exit;
}

// Obtém o ID do usuário da sessão
$userId = $_SESSION['user_id'];

// Conectar ao banco de dados
try {
    $pdo = getDBConnection(); // Supondo que essa função retorna a conexão PDO

    // Prepara a consulta SQL para buscar as seções do usuário
    $stmt = $pdo->prepare("SELECT * FROM sections WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();

    // Obtém os resultados
    $sections = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Retorna os resultados em formato JSON
    header('Content-Type: application/json');
    echo json_encode(['status' => 'success', 'sections' => $sections]);

} catch (PDOException $e) {
    // Retorna erro se houver uma exceção
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'Erro ao acessar o banco de dados: ' . $e->getMessage()]);
}
?>
