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

// código para adicionar nova coluna
$sql = "INSERT INTO columns (user_id, title, order_index, is_deleted) VALUES (?, ?, ?, 0)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$userId, $title, $orderIndex]);


echo json_encode(['status' => 'success']);
?>
