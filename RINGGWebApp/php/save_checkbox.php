<?php

session_start();
include('db_connection.php');

if (!isset($_SESSION['user_id'])) {
    die("Usuário não autenticado.");
}

$data = json_decode(file_get_contents('php://input'), true);
$sectionId = $data['sectionId'];
$label = $data['label'];
$checked = $data['checked'] ? 1 : 0;

// Inserir checkbox no banco de dados
$stmt = $pdo->prepare("INSERT INTO checkboxes (section_id, checkbox_label, checkbox_state) VALUES (?, ?, ?)");
$stmt->execute([$sectionId, $label, $checked]);

echo json_encode(['status' => 'success']);


?>