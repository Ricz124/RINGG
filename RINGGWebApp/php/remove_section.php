<?php
// Inicia a sessão, se necessário
include '../session_start.php'; 
require 'db_connections.php'; // Certifique-se de que este arquivo é carregado corretamente

header('Content-Type: application/json');

// Ativa a exibição de erros para depuração (remova em produção)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verifica se a requisição é do tipo POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Decodifica os dados JSON enviados na requisição
    $data = json_decode(file_get_contents("php://input"), true);
    $sectionId = $data['sectionId'] ?? null; // Obtém o ID da seção

    if ($sectionId) {
        // Conexão com o banco de dados
        $conn = new mysqli('your_host', 'your_user', 'your_password', 'your_database'); // Atualize com seus dados

        // Verifica se a conexão foi bem-sucedida
        if ($conn->connect_error) {
            echo json_encode([
                "status" => "error",
                "message" => "Erro de conexão: " . $conn->connect_error
            ]);
            exit();
        }

        // Prepara a consulta SQL para deletar a seção
        $query = "DELETE FROM sections WHERE id = ?";
        $stmt = $conn->prepare($query);

        // Verifica se a preparação da consulta foi bem-sucedida
        if ($stmt === false) {
            echo json_encode([
                "status" => "error",
                "message" => "Erro ao preparar a consulta: " . $conn->error
            ]);
            exit();
        }

        // Vincula o parâmetro e executa a consulta
        $stmt->bind_param("i", $sectionId);
        $success = $stmt->execute();

        // Verifica se a execução da consulta foi bem-sucedida
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

        // Fecha a declaração e a conexão
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
