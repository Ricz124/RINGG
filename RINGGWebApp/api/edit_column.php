<?php
require 'config.php';
session_start();

$data = json_decode(file_get_contents("php://input"));

if (isset($data->id) && isset($data->name)) {
    $stmt = $pdo->prepare("UPDATE columns SET name = ? WHERE id = ? AND user_id = ?");
    $stmt->execute([$data->name, $data->id, $_SESSION['user_id']]);
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'ID e nome são necessários']);
}
?>
