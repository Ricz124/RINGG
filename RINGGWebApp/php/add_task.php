<?php
$host = 'localhost';
$db = 'gerenciador_tarefas';
$user = 'root'; // seu usuário
$pass = ''; // sua senha

$pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);

$data = json_decode(file_get_contents("php://input"));

$title = $data->title;
$checkboxTitle = $data->checkboxTitle;
$priority = $data->priority;
$startDate = $data->startDate;
$endDate = $data->endDate;

$stmt = $pdo->prepare("INSERT INTO tasks (title, checkbox_title, priority, start_date, end_date) VALUES (?, ?, ?, ?, ?)");
$stmt->execute([$title, $checkboxTitle, $priority, $startDate, $endDate]);

echo json_encode(['success' => true]);
?>
