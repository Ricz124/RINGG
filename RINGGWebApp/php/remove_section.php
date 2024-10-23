<?php
// Incluir o arquivo de conexão com o banco de dados e iniciar a sessão
include '../session_start.php';
require 'db_connections.php';

// Verificar se o usuário está autenticado
if (!isset($_SESSION['user_id'])) {
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'Usuário não autenticado.']);
    exit;
}

// Definir o cabeçalho para JSON
header('Content-Type: application/json');

// Capturar a entrada JSON
$input = json_decode(file_get_contents('php://input'), true);

// Verificar se o JSON foi corretamente decodificado
if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Erro ao decodificar JSON: ' . json_last_error_msg()
    ]);
    exit;
}

// Verificar se o ID da seção foi enviado
if (isset($input['sectionId'])) {
    $sectionId = $input['sectionId'];

    try {
        // Conectar ao banco de dados
        $pdo = getDBConnection(); // Função definida em 'db_connections.php'

        // Preparar a consulta para remover a seção
        $stmt = $pdo->prepare("DELETE FROM sections WHERE id = :id AND user_id = :user_id");
        $stmt->bindParam(':id', $sectionId, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
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
                'message' => 'Nenhuma seção encontrada ou a seção não pertence ao usuário.'
            ]);
        }
    } catch (PDOException $e) {
        // Capturar e retornar erros de exceção no banco de dados
        echo json_encode([
            'status' => 'error',
            'message' => 'Erro ao remover a seção: ' . $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'ID da seção não fornecido.'
    ]);
}
?>
