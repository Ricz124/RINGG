<?php
header('Content-Type: application/json');

// Receber dados da requisição
$data = json_decode(file_get_contents('php://input'), true);

$cardId = $data['cardId'];
$tasks = $data['tasks'];

// Caminho para o arquivo JSON ou conexão com o banco de dados
$filePath = 'data/tasks.json';
$jsonData = [];

// Carregar dados JSON existentes, se houver
if (file_exists($filePath)) {
    $jsonData = json_decode(file_get_contents($filePath), true);
}

// Atualizar dados do card específico
$jsonData[$cardId] = $tasks;

// Salvar os dados atualizados no arquivo JSON
if (file_put_contents($filePath, json_encode($jsonData, JSON_PRETTY_PRINT))) {
    echo json_encode(['success' => true, 'message' => 'Tarefas salvas com sucesso']);
} else {
    echo json_encode(['success' => false, 'message' => 'Erro ao salvar tarefas']);
}
?>
