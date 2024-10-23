<?php
session_start();
header('Content-Type: application/json');

// Check if the request method is DELETE
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Get the section ID from the request body
    parse_str(file_get_contents("php://input"), $_DELETE);
    $sectionId = isset($_DELETE['id']) ? $_DELETE['id'] : null;

    if ($sectionId) {
        // Perform your logic to remove the section (e.g., database deletion)
        // Example: $result = removeSectionFromDatabase($sectionId);
        
        // Assume the operation is successful
        echo json_encode(['success' => true, 'message' => 'Seção removida com sucesso.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'ID da seção não fornecido.']);
    }
} else {
    // Handle unexpected HTTP methods
    http_response_code(405); // Method Not Allowed
    echo json_encode(['success' => false, 'message' => 'Método HTTP inválido.']);
}
?>
