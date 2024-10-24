<?php
include '../session_start.php'; // Certifique-se de que isso não causa problemas
require 'db_connections.php';

header('Content-Type: application/json');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $sectionId = $data['sectionId'] ?? null;

    if ($sectionId) {
        // Conexão com o banco de dados
        $conn = new mysqli('your_host', 'your_user', 'your_password', 'your_database'); // Atualize com seus dados

        // Verifique a conexão
        if ($conn->connect_error) {
            echo json_encode([
                "status" => "error",
                "message" => "Erro de conexão: " . $conn->connect_error
            ]);
            exit();
        }

        // Preparar a consulta
        $query = "DELETE FROM sections WHERE id = ?";
        $stmt = $conn->prepare($query);

        if ($stmt === false) {
            echo json_encode([
                "status" => "error",
                "message" => "Erro ao preparar a consulta: " . $conn->error
            ]);
            exit();
        }

        // Vincular o parâmetro e executar
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

        // Fechar a declaração e a conexão
        $stmt->close();
        $conn->close();
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
