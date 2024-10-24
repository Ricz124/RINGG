<?php
session_start();
$host = 'sql103.byethost7.com';
$db = 'b7_37575800_gerenciador_tarefas';
$user = 'b7_37575800'; // seu usuário
$pass = 'asdf1234ert'; // sua senha

$pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
$userId = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT * FROM tasks WHERE user_id = ?");
$stmt->execute([$userId]);
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($tasks);
