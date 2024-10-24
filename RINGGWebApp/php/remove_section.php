<?php
include '../session_start.php';
require 'db_connections.php';

// Verifique se o método da requisição é POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém o corpo da requisição
    $input = file_get_contents('php://input');
    $data = json_decode($input, true); // Decodifica JSON em array

    // Verifica se o json_decode retornou um array
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode([
            "status" => "error",
            "message" => "JSON inválido."
        ]);
        exit;
    }

    // Obtém o ID da seção
    $sectionId = $data['sectionId'] ?? null; // Seção pode não existir

    if ($sectionId) {
        // Execute sua lógica de remoção
        $query = "DELETE FROM sections WHERE id = ?";
        $stmt = $conn->prepare($query);

        // Verifique se a preparação da consulta foi bem-sucedida
        if ($stmt === false) {
            echo json_encode([
                "status" => "error",
                "message" => "Erro na preparação da consulta."
            ]);
            exit;
        }

        $stmt->bind_param("i", $sectionId);
        $success = $stmt->execute();

        if ($success) {
            echo json_encode([
                "status" => "success",
                "message" => "Seção removida com sucesso."
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Erro ao remover a seção."
            ]);
        }
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "ID não especificado."
        ]);
    }
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Método HTTP inválido. Use POST."
    ]);
}
?>
