<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../session_start.php'; // Verifique se a sessão está iniciada corretamente
require 'db_connections.php'; // Certifique-se de que a conexão com o banco de dados esteja funcionando

// Obtenha os dados do corpo da requisição
$input = file_get_contents("php://input");
$data = json_decode($input, true);

// remove_section.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $sectionId = $data['sectionId'] ?? null; // Obtem o ID da seção, ou null se não existir

    if ($sectionId) {
        // Lógica para remover a seção
        $query = "DELETE FROM sections WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $sectionId); // O ID deve ser um inteiro
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
        "message" => "Método HTTP inválido."
    ]);
}

?>
