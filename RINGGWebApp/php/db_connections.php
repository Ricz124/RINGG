<?php
// Credenciais de conexão com o banco de dados
$host = 'localhost';   // Nome do servidor ou endereço IP
$dbname = 'workspace_db'; // Nome do banco de dados
$username = 'root';    // Nome de usuário do banco de dados
$password = '';        // Senha do banco de dados

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Mensagem de sucesso
echo "Conexão com o banco de dados estabelecida com sucesso!";
?>
