<?php
$host = 'sql103.byethost7.com';
$db = 'b7_37575800_ringg_db';
$user = 'b7_37575800'; // ou seu usuário do MySQL
$pass = 'asdf1234ert'; // ou sua senha do MySQL

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
}
?>
