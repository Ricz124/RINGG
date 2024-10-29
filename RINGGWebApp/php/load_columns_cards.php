<?php
session_start();
require 'db.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Content-Type: application/json");

$userId = $_SESSION['user_id'];

try {
    $query = "SELECT * FROM columns WHERE user_id = :userId ORDER BY order_index";
    $stmt = $conn->prepare($query); // Alterado para $conn
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($columns as &$column) {
        $columnId = $column['id'];
        $cardQuery = "SELECT * FROM cards WHERE column_id = :columnId ORDER BY id";
        $cardStmt = $conn->prepare($cardQuery); // Alterado para $conn
        $cardStmt->bindParam(':columnId', $columnId, PDO::PARAM_INT);
        $cardStmt->execute();
        $cards = $cardStmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($cards as &$card) {
            $card['tasks'] = json_decode($card['tasks']);
        }

        $column['cards'] = $cards;
    }

    echo json_encode(['success' => true, 'columns' => $columns]);
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => "Erro ao carregar dados: " . $e->getMessage()
    ]);
}
?>
