<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../session_start.php';
require 'db_connections.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    print_r($data); // Para ver o que está sendo recebido

    if (json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode([
            "status" => "error",
            "message" => "JSON inválido."
        ]);
        exit;
    }

    $sectionId = $data['sectionId'] ?? null;

    if ($sectionId) {
        $query = "DELETE FROM sections WHERE id = ?";
        $stmt = $conn->prepare($query);

        if ($stmt === false) {
            echo json_encode([
                "status" => "error",
                "message" => "Erro na preparação da consulta: " . $conn->error
            ]);
            exit;
        }

        if ($stmt->execute()) {
            // Código para sucesso
        } else {
            http_response_code(500); // Código de erro interno
            echo json_encode([
                "status" => "error",
                "message" => "Erro ao remover a seção: " . $stmt->error
            ]);
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
                "message" => "Erro ao remover a seção: " . $stmt->error
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
