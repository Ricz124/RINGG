<?php
include '../session_start.php';
require 'db_connections.php';

// Verifique se o método da requisição é POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pegue o conteúdo do corpo da requisição
    $data = json_decode(file_get_contents("php://input"), true);

    // Verifique se o ID da seção foi fornecido
    if (isset($data['sectionId'])) {
        $sectionId = $data['sectionId'];

        // Prepara a consulta SQL para deletar a seção
        $query = "DELETE FROM sections WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $sectionId); // O ID da seção deve ser um inteiro

        // Execute a consulta
        if ($stmt->execute()) {
            // Retorna sucesso
            echo json_encode([
                "status" => "success",
                "message" => "Seção removida com sucesso."
                error_log("Iniciando remoção da seção com ID: " . $sectionId);

            ]);
        } else {
            // Erro ao executar a consulta
            http_response_code(500);
            echo json_encode([
                "status" => "error",
                "message" => "Erro ao executar a remoção no banco de dados."
                error_log("Iniciando remoção da seção com ID: " . $sectionId);

            ]);
        }
    } else {
        // ID da seção não fornecido
        http_response_code(400);
        echo json_encode([
            "status" => "error",
            "message" => "ID da seção não especificado."
            error_log("Iniciando remoção da seção com ID: " . $sectionId);

        ]);
    }
} else {
    // Método HTTP não suportado
    http_response_code(405);
    echo json_encode([
        "status" => "error",
        "message" => "Método HTTP inválido. Use POST."
        error_log("Iniciando remoção da seção com ID: " . $sectionId);

    ]);
}
?>
