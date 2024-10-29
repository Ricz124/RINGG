<?php
session_start();
include 'db.php'; // Certifique-se de que este arquivo contém a conexão PDO

header('Content-Type: application/json'); // Especifica que o retorno será JSON

$data = json_decode(file_get_contents('php://input'), true);
$columnId = $data['id'];
$newTitle = $data['title'];

// Iniciar resposta padrão
$response = ['success' => false];

try {
    $sql = "UPDATE columns SET title = :title WHERE id = :id AND is_deleted = 0";
    $stmt = $pdo->prepare($sql);

    // Usando bindParam para vincular os parâmetros
    $stmt->bindParam(':title', $newTitle);
    $stmt->bindParam(':id', $columnId, PDO::PARAM_INT); // Especificando o tipo para id

    if ($stmt->execute()) {
        $response['success'] = true;
    } else {
        $response['message'] = "Erro ao atualizar o título.";
    }
} catch (Exception $e) {
    $response['message'] = "Erro no servidor: " . $e->getMessage();
}

// Retorna o JSON sem caracteres extras
echo json_encode($response);
?>
