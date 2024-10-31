<?php
session_start();
include 'db.php'; // Certifique-se de que este arquivo contém a conexão PDO

header('Content-Type: application/json'); // Especifica que o retorno será JSON

// Captura qualquer saída anterior
ob_start();

$data = json_decode(file_get_contents('php://input'), true);

// Verifique se os dados estão sendo recebidos corretamente
if (!isset($data['id']) || !isset($data['title'])) {
    echo json_encode(['success' => false, 'message' => 'ID ou título não fornecidos.']);
    exit;
}

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
ob_end_clean(); // Limpa o buffer de saída
echo json_encode($response);
?>
