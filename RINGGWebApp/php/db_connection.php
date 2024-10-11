<?php
// Credenciais de conexão com o banco de dados
$host = 'localhost';   // Nome do servidor ou endereço IP
$dbname = 'db_info'; // Nome do banco de dados
$username = 'root';    // Nome de usuário do banco de dados
$password = '';        // Senha do banco de dados

try {
    // Cria uma nova conexão PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    
    // Define o modo de erro do PDO para exceções
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Exibe uma mensagem de sucesso ao conectar
    // (Opcional: remova ou comente em um ambiente de produção)
    echo "Conexão com o banco de dados estabelecida com sucesso!";
} catch (PDOException $e) {
    // Caso a conexão falhe, exibe a mensagem de erro
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}
?>