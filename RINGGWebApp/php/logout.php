<?php
session_start();
session_destroy(); // Destroi a sessão do usuário
header("Location: login.html"); // Redireciona para a página de login
?>
