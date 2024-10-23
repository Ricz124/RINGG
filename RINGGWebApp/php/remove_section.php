header('Content-Type: application/json');

// Verifica se o método é POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Método HTTP inválido.']);
    exit; // Garante que nada mais seja enviado
}

// Verificar se o usuário está autenticado
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Usuário não autenticado.']);
    exit;
}

// Captura e decodifica a entrada JSON
$data = json_decode(file_get_contents('php://input'), true);

if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['status' => 'error', 'message' => 'Erro ao decodificar JSON: ' . json_last_error_msg()]);
    exit;
}

// Validação do ID da seção
$sectionId = trim($data['sectionId']);
if (empty($sectionId)) {
    echo json_encode(['status' => 'error', 'message' => 'ID da seção não pode estar vazio.']);
    exit;
}

$userId = $_SESSION['user_id'];
$stmt = $pdo->prepare("DELETE FROM sections WHERE id = ? AND user_id = ?");

try {
    $stmt->execute([$sectionId, $userId]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(['status' => 'success', 'message' => 'Seção removida com sucesso.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Seção não encontrada ou não pertence ao usuário.']);
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Erro ao processar: ' . $e->getMessage()]);
}

exit; // Garante que nada mais seja enviado após a resposta
