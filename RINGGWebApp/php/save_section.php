<?php

session_start();
include('db_connection.php');

if (!isset($_SESSION['user_id'])) {
    die("Usuário não autenticado.");
}

$data = json_decode(file_get_contents('php://input'), true);
$sectionTitle = $data['sectionTitle'];
$userId = $_SESSION['user_id'];

// Inserir seção no banco de dados
$stmt = $pdo->prepare("INSERT INTO sections (user_id, section_title) VALUES (?, ?)");
$stmt->execute([$userId, $sectionTitle]);

echo json_encode(['status' => 'success', 'sectionId' => $pdo->lastInsertId()]);


?>