<?php
require 'config.php';
session_start();

$data = json_decode(file_get_contents("php://input"));

if (isset($data->email) && isset($data->password)) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$data->email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($data->password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        echo json_encode(['success' => true, 'message' => 'Login bem-sucedido']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Email ou senha incorretos']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Email e senha são necessários']);
}
?>
