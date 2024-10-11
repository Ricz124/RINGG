<?php
session_start(); // Inicia a sessão

// Verifique se a sessão já foi configurada
if (!isset($_SESSION['user'])) {
    $_SESSION['user'] = 'Usuário Padrão'; // Exemplo de valor padrão para a sessão
}
?>
