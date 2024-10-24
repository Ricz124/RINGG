<?php
session_start();
session_destroy(); // Destroi a sessão do usuário
header("Location: login.php"); // Redireciona para a página de login
?>
