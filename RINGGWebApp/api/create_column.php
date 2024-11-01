<?php
require 'config.php';
session_start();

$data = json_decode(file_get_contents("php://input"));

if (isset($data->name)) {
    $stmt = $pdo->prepare("INSERT INTO columns (user_id, name) VALUES (?, ?)");
    $stmt->execute([$_SESSION['user_id'], $data->name]);
    echo json_encode(['success' => true, 'columnId' => $pdo->lastInsertId()]);
} else {
    echo json_encode(['success' => false, 'message' => 'Nome da coluna é necessário']);
}
?>
