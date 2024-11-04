<?php
include '../config.php';
session_start();
$user_id = $_SESSION['user_id'];

// Criar card
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name']) && isset($_POST['column_id'])) {
    $name = $_POST['name'];
    $column_id = $_POST['column_id'];
    $color = $_POST['color'] ?? '#ffffff';
    $due_date = $_POST['due_date'] ?? null;

    $stmt = $conn->prepare("INSERT INTO cards (user_id, column_id, name, color, due_date) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iisss", $user_id, $column_id, $name, $color, $due_date);
    $stmt->execute();
}
?>
