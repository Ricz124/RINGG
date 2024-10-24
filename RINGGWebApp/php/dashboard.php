<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html"); // Redireciona para o login se o usuário não estiver logado
    exit();
}

$host = 'localhost';
$db = 'gerenciador_tarefas';
$user = 'root'; // seu usuário
$pass = ''; // sua senha

$pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
$userId = $_SESSION['user_id'];

// Buscar informações do usuário
$stmt = $pdo->prepare("SELECT username FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Buscar tarefas do usuário
$stmt = $pdo->prepare("SELECT * FROM tasks WHERE user_id = ?");
$stmt->execute([$userId]);
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Painel do Usuário</title>
</head>
<body>
    <div class="container">
        <h1>Painel do Usuário</h1>
        <p>Bem-vindo, <?php echo htmlspecialchars($user['username']); ?>!</p>
        <a href="logout.php">Sair</a>
        
        <h2>Suas Tarefas</h2>
        <div id="task-list">
            <?php if (count($tasks) > 0): ?>
                <?php foreach ($tasks as $task): ?>
                    <div class="task" style="border-left: 5px solid <?php echo htmlspecialchars($task['priority']); ?>">
                        <h3><?php echo htmlspecialchars($task['title']); ?></h3>
                        <input type="checkbox"> <?php echo htmlspecialchars($task['checkbox_title']); ?>
                        <span><?php echo htmlspecialchars($task['start_date']); ?> - <?php echo htmlspecialchars($task['end_date']); ?></span>
                        <button onclick="deleteTask(<?php echo $task['id']; ?>)">Remover</button>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Você não tem tarefas cadastradas.</p>
            <?php endif; ?>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>
