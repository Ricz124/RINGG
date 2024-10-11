<?php
include '../session_start.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro e Login</title>
    <style>
        body {
            font-family: 'Red Hat Display', sans-serif;
            background-color: lightgrey;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        .container h2 {
            text-align: center;
            color: teal;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        input {
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            padding: 10px;
            background-color: teal;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: darkcyan;
        }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }

        .success {
            color: green;
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Cadastro</h2>
    <form action="process.php" method="POST">
        <input type="text" name="username" placeholder="Usuário" required>
        <input type="email" name="email" placeholder="E-mail" required>
        <input type="password" name="password" placeholder="Senha" required>
        <button type="submit" name="register">Cadastrar</button>
    </form>

    <h2>Login</h2>
    <form action="process.php" method="POST">
        <input type="text" name="username" placeholder="Usuário" required>
        <input type="password" name="password" placeholder="Senha" required>
        <button type="submit" name="login">Entrar</button>
    </form>

    <?php
    if (isset($_SESSION['error'])) {
        echo "<div class='error'>" . $_SESSION['error'] . "</div>";
        unset($_SESSION['error']);
    }

    if (isset($_SESSION['success'])) {
        echo "<div class='success'>" . $_SESSION['success'] . "</div>";
        unset($_SESSION['success']);
    }
    ?>
</div>

</body>
</html>
