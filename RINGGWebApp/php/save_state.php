<?php
session_start();
require 'db.php'; // Certifique-se de que este arquivo contém a conexão ao banco de dados

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Content-Type: application/json");

// Verifica se o usuário está autenticado
if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Usuário não autenticado.'
    ]);
    exit;
}

// Obtém o ID do usuário da sessão
$userId = $_SESSION['user_id'];

// Recebe os dados do quadro via POST
$inputData = file_get_contents('php://input');
$data = json_decode($inputData, true);

// Debug: Verifica se os dados foram recebidos corretamente
if ($data === null) {
    // Registra no log o conteúdo recebido
    error_log("JSON recebido (raw): " . $inputData); // Verifique o JSON bruto
    echo json_encode([
        'success' => false,
        'message' => 'Dados inválidos recebidos ou JSON malformado.'
    ]);
    exit;
}

try {
    // Começa uma transação para garantir a integridade dos dados
    $pdo->beginTransaction();

    // Limpa as colunas e cartões existentes do usuário antes de salvar o novo estado
    $clearColumnsQuery = "DELETE FROM columns WHERE user_id = :userId";
    $clearColumnsStmt = $pdo->prepare($clearColumnsQuery);
    $clearColumnsStmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $clearColumnsStmt->execute();

    // Insere novas colunas e seus cartões
    foreach ($data['columns'] as $column) { // Verifica se "columns" existe em $data
        // Insere a coluna
        $insertColumnQuery = "INSERT INTO columns (user_id, title) VALUES (:userId, :title)";
        $insertColumnStmt = $pdo->prepare($insertColumnQuery);
        $insertColumnStmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $insertColumnStmt->bindParam(':title', $column['title'], PDO::PARAM_STR);
        $insertColumnStmt->execute();
        $columnId = $pdo->lastInsertId(); // Obtém o ID da coluna recém-inserida

        // Insere os cartões associados a essa coluna
        foreach ($column['cards'] as $card) {
            $insertCardQuery = "INSERT INTO cards (column_id, title, due_date, color, tasks) VALUES (:columnId, :title, :dueDate, :color, :tasks)";
            $insertCardStmt = $pdo->prepare($insertCardQuery);
            $insertCardStmt->bindParam(':columnId', $columnId, PDO::PARAM_INT);
            $insertCardStmt->bindParam(':title', $card['title'], PDO::PARAM_STR);
            $insertCardStmt->bindParam(':dueDate', $card['dueDate'], PDO::PARAM_STR);
            $insertCardStmt->bindParam(':color', $card['color'], PDO::PARAM_STR);
            $insertCardStmt->bindParam(':tasks', json_encode($card['tasks']), PDO::PARAM_STR); // Armazena as tarefas como JSON
            $insertCardStmt->execute();
        }
    }

    // Confirma a transação
    $pdo->commit();

    echo json_encode(['success' => true, 'message' => 'Estado salvo com sucesso.']);
} catch (PDOException $e) {
    // Em caso de erro, reverte a transação
    $pdo->rollBack();
    error_log("Erro ao salvar estado: " . $e->getMessage()); // Registra o erro no log
    echo json_encode([
        'success' => false,
        'message' => "Erro ao salvar o estado: " . $e->getMessage()
    ]);
}
?>
