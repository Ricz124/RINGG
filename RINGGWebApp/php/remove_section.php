<?php
include '../session_start.php'; // Certifique-se de que a sessão está sendo iniciada corretamente
require 'db_connections.php';  // Certifique-se de que a conexão está configurada corretamente

// Verifique se o método da requisição é DELETE
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $post_vars); // Para obter dados do corpo da requisição
    $id = isset($post_vars['id']) ? intval($post_vars['id']) : null; // Verifique e converta o ID para inteiro

    // Verifique se o ID está definido e é um valor válido
    if ($id) {
        // Execute a lógica de remoção, como uma consulta SQL para remover a seção
        $query = "DELETE FROM sections WHERE id = ?";
        $stmt = $conn->prepare($query);
        
        if ($stmt) { // Verifique se a consulta foi preparada corretamente
            $stmt->bind_param("i", $id); // O ID deve ser um inteiro
            $success = $stmt->execute();

            if ($success) {
                // Responda com sucesso
                echo json_encode([
                    "status" => "success",
                    "message" => "Seção removida com sucesso."
                ]);
            } else {
                // Se a execução falhar, responda com erro
                echo json_encode([
                    "status" => "error",
                    "message" => "Erro ao remover a seção: " . $stmt->error // Inclua a mensagem de erro do banco de dados
                ]);
            }
            
            $stmt->close(); // Feche a declaração
        } else {
            // Se a preparação da consulta falhar, responda com erro
            echo json_encode([
                "status" => "error",
                "message" => "Erro ao preparar a consulta: " . $conn->error
            ]);
        }
    } else {
        // Responda com erro se o ID não estiver definido ou for inválido
        echo json_encode([
            "status" => "error",
            "message" => "ID não especificado ou inválido."
        ]);
    }
} else {
    // Responda com erro se o método não for DELETE
    echo json_encode([
        "status" => "error",
        "message" => "Método HTTP inválido."
    ]);
}

$conn->close(); // Feche a conexão com o banco de dados
?>
