<?php
$host = 'localhost';
$db = 'gerenciador_tarefas';
$user = 'root'; // seu usuário
$pass = ''; // sua senha

$pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);

$data = json_decode(file_get_contents("php://input"));
$id = $data->id;

$stmt = $pdo->prepare("DELETE FROM tasks WHERE id = ?");
$stmt->execute([$id]);

echo json_encode(['success' => true]);
?>
