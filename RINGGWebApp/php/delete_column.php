<?php
session_start();
require 'db.php'; // Conexão com o banco de dados

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Content-Type: application/json");

// Dados recebidos do JavaScript
$data = json_decode(file_get_contents('php://input'), true);

$title = $data['title'];
$userId = $data['userId'];

try {
    $sql = "UPDATE columns SET is_deleted = 1 WHERE title = :title AND user_id = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':title' => $title, ':user_id' => $userId]);

    echo json_encode(['success' => true, 'message' => 'Coluna excluída com sucesso']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => "Erro ao excluir coluna: " . $e->getMessage()]);
}
?>
