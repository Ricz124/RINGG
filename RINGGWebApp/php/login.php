<?php
session_start();
$host = 'sql103.byethost7.com';
$db = 'b7_37575800_gerenciador_tarefas';
$user = 'b7_37575800'; // seu usuário
$pass = 'asdf1234ert'; // sua senha

$pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);

$data = json_decode(file_get_contents("php://input"));
$username = $data->username;
$password = $data->password;

$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id']; // Armazena o ID do usuário na sessão
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Credenciais inválidas']);
}
?>
