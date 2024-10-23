<?php
// Parâmetros de conexão
$host = 'sql103.byethost7.com'; 
$dbname = 'b7_37575800_workspace_db'; 
$username = 'b7_37575800'; 
$password = 'asdf1234ert'; 

try {
    // Cria a conexão
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Define o modo de erro do PDO para exceções
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log("Falha na conexão com o banco de dados: " . $e->getMessage());
    die("Falha na conexão com o banco de dados.");
}

// O objeto de conexão ($pdo) agora está pronto para ser usado
?>
