<?php
include '../session_start.php';
require 'db_connections.php';

// Verifica se o método da requisição é POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lê o corpo da requisição JSON
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    // Verifica se o JSON foi decodificado corretamente e se o 'sectionId' foi fornecido
    if (isset($data['sectionId'])) {
        $sectionId = $data['sectionId'];

        // Preparar e executar a consulta SQL para remover a seção
        $query = "DELETE FROM sections WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $sectionId); // O ID deve ser um inteiro
        $success = $stmt->execute();

        if ($success) {
            // Retorna uma resposta JSON de sucesso
            echo json_encode([
                "status" => "success",
                "message" => "Seção removida com sucesso."
            ]);
        } else {
            // Retorna uma resposta JSON de erro
            echo json_encode([
                "status" => "error",
                "message" => "Erro ao remover a seção no banco de dados."
            ]);
        }
    } else {
        // Retorna erro se o 'sectionId' não for fornecido
        echo json_encode([
            "status" => "error",
            "message" => "ID da seção não fornecido."
        ]);
    }
} else {
    // Responde com erro se o método não for POST
    echo json_encode([
        "status" => "error",
        "message" => "Método HTTP inválido."
    ]);
}
?>
