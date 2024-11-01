<?php
require 'config.php';
session_start();

$data = json_decode(file_get_contents("php://input"));

if (isset($data->id)) {
    // Primeiro, exclua todos os cards associados
    $stmt = $pdo->prepare("DELETE FROM cards WHERE column_id = ?");
    $stmt->execute([$data->id]);
    
    // Em seguida, exclua a coluna
    $stmt = $pdo->prepare("DELETE FROM columns WHERE id = ? AND user_id = ?");
    $stmt->execute([$data->id, $_SESSION['user_id']]);
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'ID da coluna é necessário']);
}
?>
