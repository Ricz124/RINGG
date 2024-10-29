<?php
session_start();
require 'db.php';

$data = json_decode(file_get_contents('php://input'), true);
$title = trim($data['title']);
$userId = $data['userId'];
$orderIndex = $data['orderIndex'];

if (empty($title) || empty($userId)) {
    echo json_encode(['status' => 'error', 'message' => 'Título ou ID de usuário vazio.']);
    exit;
}

$sql = "INSERT INTO columns (user_id, title, order_index) VALUES (:user_id, :title, :order_index)";
$stmt = $conn->prepare($sql);
$stmt->execute([':user_id' => $userId, ':title' => $title, ':order_index' => $orderIndex]);

echo json_encode(['status' => 'success']);
?>
