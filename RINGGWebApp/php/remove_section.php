<?php
header('Content-Type: application/json'); // Certifique-se de que o cabeçalho está configurado corretamente

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lê os dados do corpo da requisição
    $data = json_decode(file_get_contents("php://input"), true);
    $sectionId = $data['sectionId'] ?? null;

    if ($sectionId) {
        // Conexão com o banco de dados e remoção da seção
        // Supondo que $conn seja sua conexão com o banco de dados
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
