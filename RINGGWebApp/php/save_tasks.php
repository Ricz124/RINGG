<?php
session_start();
header('Content-Type: application/json');

// Database connection
$host = 'sql103.byethost7.com';
$dbname = 'b7_37575800_gerenciador_tarefas';
$username = 'b7_37575800'; // seu usuário
$password = 'asdf1234ert'; // sua senha

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $e->getMessage()]);
    exit;
}

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$userId = $_SESSION['user_id'];

// Read JSON input
$input = file_get_contents("php://input");
$data = json_decode($input, true);

if (isset($data['action']) && $data['action'] === 'save') {
    // Fetch all tasks for the current user
    $stmt = $pdo->prepare("SELECT * FROM tasks WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $userId);
    $stmt->execute();
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['success' => true, 'message' => 'Tasks fetched successfully', 'tasks' => $tasks]);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid action']);
}

?>
