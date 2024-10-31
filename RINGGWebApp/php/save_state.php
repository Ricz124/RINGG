<?php
session_start();
require 'db.php';

header("Content-Type: application/json");

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Usuário não autenticado.']);
    exit;
}

$userId = $_SESSION['user_id'];
$inputData = file_get_contents('php://input');
$data = json_decode($inputData, true);

if ($data === null) {
    error_log("JSON recebido (raw): " . $inputData);
    echo json_encode(['success' => false, 'message' => 'Dados inválidos recebidos ou JSON malformado.']);
    exit;
}

try {
    $pdo->beginTransaction();

    // Array para armazenar IDs das colunas enviadas pelo frontend
    $columnIds = array_column($data['columns'], 'id');

    // Exclui colunas que não estão mais presentes
    $deleteQuery = "DELETE FROM columns WHERE user_id = :userId AND id NOT IN (" . implode(',', $columnIds) . ")";
    $deleteStmt = $pdo->prepare($deleteQuery);
    $deleteStmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $deleteStmt->execute();

    foreach ($data['columns'] as $column) {
        if (isset($column['id'])) {
            // Atualiza coluna existente
            $updateColumnQuery = "UPDATE columns SET title = :title WHERE id = :id AND user_id = :userId";
            $updateColumnStmt = $pdo->prepare($updateColumnQuery);
            $updateColumnStmt->bindParam(':title', $column['title']);
            $updateColumnStmt->bindParam(':id', $column['id']);
            $updateColumnStmt->bindParam(':userId', $userId);
            $updateColumnStmt->execute();
            $columnId = $column['id'];
        } else {
            // Insere nova coluna
            $insertColumnQuery = "INSERT INTO columns (user_id, title) VALUES (:userId, :title)";
            $insertColumnStmt = $pdo->prepare($insertColumnQuery);
            $insertColumnStmt->bindParam(':userId', $userId);
            $insertColumnStmt->bindParam(':title', $column['title']);
            $insertColumnStmt->execute();
            $columnId = $pdo->lastInsertId();
        }

        // Processa cartões da coluna
        foreach ($column['cards'] as $card) {
            $insertCardQuery = "INSERT INTO cards (column_id, title, due_date, color, tasks) VALUES (:columnId, :title, :dueDate, :color, :tasks)";
            $insertCardStmt = $pdo->prepare($insertCardQuery);
            $insertCardStmt->bindParam(':columnId', $columnId);
            $insertCardStmt->bindParam(':title', $card['title']);
            $insertCardStmt->bindParam(':dueDate', $card['dueDate']);
            $insertCardStmt->bindParam(':color', $card['color']);
            $insertCardStmt->bindParam(':tasks', json_encode($card['tasks']));
            $insertCardStmt->execute();
        }
    }

    $pdo->commit();
    echo json_encode(['success' => true, 'message' => 'Estado salvo com sucesso.']);
} catch (PDOException $e) {
    $pdo->rollBack();
    error_log("Erro ao salvar estado: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => "Erro ao salvar o estado: " . $e->getMessage()]);
}
?>
