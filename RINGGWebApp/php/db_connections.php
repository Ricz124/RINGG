<?php
// Parâmetros de conexão
$host = 'localhost'; 
$dbname = 'workspace_db'; 
$username = 'root'; 
$password = ''; 

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
