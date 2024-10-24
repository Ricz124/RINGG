<?php
session_start();
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

$userId = $_SESSION['user_id']; // Assumindo que o ID do usuário está na sessão

$stmt = $pdo->prepare("INSERT INTO tasks (user_id, title, checkbox_title, priority, start_date, end_date) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->execute([$userId, $title, $checkboxTitle, $priority, $startDate, $endDate]);

echo json_encode(['success' => true]);
?>
