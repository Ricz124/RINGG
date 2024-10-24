<?php
session_start();
$host = 'localhost';
$db = 'gerenciador_tarefas';
$user = 'root'; // seu usuário
$pass = ''; // sua senha

$pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);

$data = json_decode(file_get_contents("php://input"));
$username = $data->username;
$password = password_hash($data->password, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
$stmt->execute([$username, $password]);

echo json_encode(['success' => true]);
?>
