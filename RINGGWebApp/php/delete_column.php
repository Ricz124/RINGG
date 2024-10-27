<?php
session_start();
require 'db.php'; // Conexão com o banco de dados

$data = json_decode(file_get_contents('php://input'), true);

$title = $data['title'];
$userId = $data['userId'];

$sql = "UPDATE columns SET is_deleted = 1 WHERE title = :title AND user_id = :user_id";
$stmt = $conn->prepare($sql);
$stmt->execute([':title' => $title, ':user_id' => $userId]);

echo json_encode(['status' => 'success']);
?>
