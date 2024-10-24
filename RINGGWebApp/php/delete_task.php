<?php
session_start();
$host = 'sql103.byethost7.com';
$db = 'b7_37575800_gerenciador_tarefas';
$user = 'b7_37575800'; // seu usuário
$pass = 'asdf1234ert'; // sua senha

$pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);

$data = json_decode(file_get_contents("php://input"));
$id = $data->id;

$stmt = $pdo->prepare("DELETE FROM tasks WHERE id = ?");
$stmt->execute([$id]);

echo json_encode(['success' => true]);
?>
