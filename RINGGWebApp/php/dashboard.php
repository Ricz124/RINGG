<?php
session_start(); // Iniciar a sessão
include 'nav.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirecionar para login se não estiver autenticado
    exit();
}

// Exibir informações do usuário
$user_id = $_SESSION['user_id'];
$user_nome = $_SESSION['user_nome'];

echo "<h1>Bem-vindo, $user_nome!</h1>"; // Exibir o nome do usuário
echo "Seu ID de usuário é: " . $user_id;
?>
<a href="../workstation.php">Ir para o Espaço de Trabalho</a>
<a href="logout.php">Sair</a>

<footer>
      <div class="footer-content">
        <p>&copy; 2024 RINGG. Todos os direitos reservados.</p>
        <ul class="footer-links">
          <li><a href="quemsomos.html">Quem Somos</a></li>
          <li><a href="ajuda.html">Ajuda</a></li>
          <li><a href="login.html">Entrar</a></li>
        </ul>
      </div>
    </footer>
