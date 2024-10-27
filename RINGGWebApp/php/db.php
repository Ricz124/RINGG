<?php
$host = 'sql103.byethost7.com'; // ou o endereço do seu servidor de banco de dados
$db = 'b7_37575800_ringg_db';
$user = 'b7_37575800';
$pass = 'asdf1234ert';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro de conexão: " . $e->getMessage());
}
?>
