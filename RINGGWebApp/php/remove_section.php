<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../session_start.php';
require 'db_connections.php';

// Obtenha os dados do corpo da requisição
$input = file_get_contents("php://input");
$data = json_decode($input, true);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($data['sectionId'])) {
    $sectionId = $data['sectionId'];

    // Prepare a consulta SQL
    $query = "DELETE FROM sections WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $sectionId);
    
    if ($stmt->execute()) {
        // Responda com JSON se a remoção for bem-sucedida
        echo json_encode([
            "status" => "success",
            "message" => "Seção removida com sucesso."
        ]);
    } else {
        // Responda com erro se a remoção falhar
        http_response_code(500);
        echo json_encode([
            "status" => "error",
            "message" => "Erro ao remover a seção: " . $stmt->error
        ]);
    }
} else {
    // Responda com erro se o método não for POST ou o ID não estiver especificado
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "Método HTTP inválido ou ID não especificado."
    ]);
}
?>
