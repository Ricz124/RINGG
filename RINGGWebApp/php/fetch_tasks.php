<?php
$host = 'localhost';
$db = 'gerenciador_tarefas';
$user = 'root'; // seu usuário
$pass = ''; // sua senha

$pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
$stmt = $pdo->query("SELECT * FROM tasks");
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($tasks);
?>
