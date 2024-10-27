<?php
session_start();
require 'db.php'; // Conexão com o banco de dados

$data = json_decode(file_get_contents('php://input'), true);

$title = $data['title'];
$userId = $data['userId'];
$orderIndex = $data['orderIndex'];

$sql = "INSERT INTO columns (user_id, title, order_index) VALUES (:user_id, :title, :order_index)";
$stmt = $conn->prepare($sql);
$stmt->execute([':user_id' => $userId, ':title' => $title, ':order_index' => $orderIndex]);

echo json_encode(['status' => 'success']);
?>
