<?php
include '../session_start.php';
require 'db_connections.php';

// Verifique se o método da requisição é DELETE
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $post_vars); // Para obter dados do corpo da requisição
    $id = $post_vars['id']; // Obtenha o ID da seção

    // Verifique se o ID está definido
    if (isset($id)) {
        // Execute sua lógica de remoção, como uma consulta SQL para remover a seção
        $query = "DELETE FROM sections WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id); // O ID deve ser um inteiro
        $success = $stmt->execute();

        if ($success) {
            // Responda com sucesso
            echo json_encode([
                "status" => "success",
                "message" => "Seção removida com sucesso."
            ]);
        } else {
            // Responda com erro
            echo json_encode([
                "status" => "error",
                "message" => "Erro ao remover a seção."
            ]);
        }
    } else {
        // Responda com erro se o ID não estiver definido
        echo json_encode([
            "status" => "error",
            "message" => "ID não especificado."
        ]);
    }
} else {
    // Responda com erro se o método não for DELETE
    echo json_encode([
        "status" => "error",
        "message" => "Método HTTP inválido."
    ]);
}
?>
