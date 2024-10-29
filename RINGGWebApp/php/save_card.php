<?php
session_start();
require 'db.php';

$data = json_decode(file_get_contents('php://input'), true);
$title = trim($data['title']);
$userId = $data['userId'];
$columnId = $data['columnId'];
$dueDate = $data['dueDate'];
$color = $data['color'];
$tasks = json_encode($data['tasks']);

if (empty($title) || empty($userId) || empty($columnId)) {
    echo json_encode(['status' => 'error', 'message' => 'Dados obrigatórios faltando.']);
    exit;
}

$sql = "INSERT INTO cards (user_id, column_id, title, due_date, color, tasks) VALUES (:user_id, :column_id, :title, :due_date, :color, :tasks)";
$stmt = $conn->prepare($sql);
$stmt->execute([
    ':user_id' => $userId,
    ':column_id' => $columnId,
    ':title' => $title,
    ':due_date' => $dueDate,
    ':color' => $color,
    ':tasks' => $tasks
]);

echo json_encode(['status' => 'success']);
?>
