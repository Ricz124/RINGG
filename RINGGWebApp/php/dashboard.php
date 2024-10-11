<?php include '../session_start.php'; ?> <!-- Inclui o arquivo de sessão -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <h3>Dashboard</h3>
        <a href="logout.php">Sair</a>
    </nav>

    <div class="content">
        <h2>Bem-vindo, <?php echo $_SESSION['username']; ?>!</h2>
        <div class="links">
            <a href="../workstation.php">Ir para o Gerenciador de Tarefas</a>
        </div>
    </div>
</body>
</html>
