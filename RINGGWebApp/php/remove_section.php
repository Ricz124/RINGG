<?php
// Incluir o arquivo de conexão com o banco de dados
include '../session_start.php';
require 'db_connections.php';

// Verificar se o usuário está autenticado
if (!isset($_SESSION['user_id'])) {
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'Usuário não autenticado.']);
    exit();
}

// Definir o cabeçalho para o tipo de conteúdo JSON
header('Content-Type: application/json');

// Captura a entrada JSON
$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['sectionId'])) {
    $sectionId = $input['sectionId'];

    try {
        // Conectar ao banco de dados
        $pdo = getDBConnection();

        // Consulta para remover a seção
        $stmt = $pdo->prepare("DELETE FROM sections WHERE id = :id");
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

exit();  // Certifique-se de que não há mais saída
?>
