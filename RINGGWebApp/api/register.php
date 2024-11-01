<?php
require 'config.php';

$data = json_decode(file_get_contents("php://input"));

if (isset($data->name) && isset($data->email) && isset($data->password)) {
    $hashedPassword = password_hash($data->password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$data->name, $data->email, $hashedPassword]);
    echo json_encode(['success' => true, 'message' => 'Usuário registrado com sucesso!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Todos os campos são necessários']);
}
?>
