<?php
session_start();
require 'db.php';
include 'nav.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Buscar usuário no banco de dados
    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($senha, $user['senha'])) {
        $_SESSION['user_id'] = $user['id']; // Armazenar ID do usuário na sessão
        header("Location: dashboard.php"); // Redirecionar para a página do dashboard
        exit();
    } else {
        echo "Email ou senha incorretos.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form method="POST">
        <label for="email">Email:</label>
        <input type="email" name="email" required><br>

        <label for="senha">Senha:</label>
        <input type="password" name="senha" required><br>

        <button type="submit">Login</button>
    </form>
    <a href="register.php">Não tem cadastro?</a>

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


</body>
</html>
