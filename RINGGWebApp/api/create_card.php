<?php
require 'config.php';
session_start();

$data = json_decode(file_get_contents("php://input"));

if (isset($data->name) && isset($data->columnId)) {
    $stmt = $pdo->prepare("INSERT INTO cards (column_id, user_id, name) VALUES (?, ?, ?)");
    $stmt->execute([$data->columnId, $_SESSION['user_id'], $data->name]);
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Nome do card e ID da coluna são necessários']);
}
?>
