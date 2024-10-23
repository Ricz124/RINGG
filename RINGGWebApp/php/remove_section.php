<?php
ini_set('display_errors', 0);
error_reporting(0);

// Incluir o arquivo de conexão com o banco de dados
include '../session_start.php';
require 'db_connections.php';

// Verificar se o usuário está autenticado
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Usuário não autenticado.']);
    exit;
}

// Definir o cabeçalho para o tipo de conteúdo JSON
header('Content-Type: application/json');

// Captura a entrada JSON
$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['sectionId'])) {
    $sectionId = $input['sectionId'];

    try {
        // Conectar ao banco de dados
        $pdo = getDBConnection(); // Supondo que getDBConnection() seja a função que retorna a conexão

        // Consulta para remover a seção
        $stmt = $pdo->prepare("DELETE FROM sections WHERE id = :id"); // Substitua 'sections' pelo nome da sua tabela
        $stmt->bindParam(':id', $sectionId, PDO::PARAM_INT);
        $stmt->execute();

        // Verificar se a seção foi removida
        if ($stmt->rowCount() > 0) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Seção removida com sucesso.'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Nenhuma seção encontrada para remover.'
            ]);
        }
    } catch (PDOException $e) {
        // Retornar erro se houver uma exceção
        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'ID da seção não fornecido.'
    ]);
}
?>
