<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../session_start.php';
require 'db_connections.php';

// Verifique se o método da requisição é POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recebe o corpo da requisição
    $data = json_decode(file_get_contents("php://input"), true);
    $sectionId = $data['sectionId']; // Obtenha o ID da seção

    // Verifique se o ID está definido
    if (isset($sectionId)) {
        // Execute sua lógica de remoção
        $query = "DELETE FROM sections WHERE id = ?";
        $stmt = $conn->prepare($query);
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
