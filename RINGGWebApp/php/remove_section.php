<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $sectionId = $data['sectionId'] ?? null;

    if ($sectionId) {
        // Aqui você deve definir a conexão com o banco de dados
        $conn = new mysqli('host', 'user', 'password', 'database'); // Atualize com seus dados

        // Verifique a conexão
        if ($conn->connect_error) {
            echo json_encode([
                "status" => "error",
                "message" => "Erro de conexão: " . $conn->connect_error
            ]);
            exit();
        }

        $query = "DELETE FROM sections WHERE id = ?";
        $stmt = $conn->prepare($query);

        if ($stmt === false) {
            echo json_encode([
                "status" => "error",
                "message" => "Erro ao preparar a consulta: " . $conn->error
            ]);
            exit();
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
