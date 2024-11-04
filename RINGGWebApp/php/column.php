<?php
include '../config.php';
session_start();
$user_id = $_SESSION['user_id'];

// Criar coluna
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])) {
    $name = $_POST['name'];
    $stmt = $conn->prepare("INSERT INTO columns (user_id, name) VALUES (?, ?)");
    $stmt->bind_param("is", $user_id, $name);
    $stmt->execute();
}

// Deletar coluna
if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM columns WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $id, $user_id);
    $stmt->execute();
}
?>
