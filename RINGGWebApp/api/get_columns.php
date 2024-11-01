<?php
require 'config.php';
session_start();

$stmt = $pdo->prepare("SELECT * FROM columns WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($columns as &$column) {
    $stmt = $pdo->prepare("SELECT * FROM cards WHERE column_id = ?");
    $stmt->execute([$column['id']]);
    $column['cards'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

echo json_encode(['columns' => $columns]);
?>
