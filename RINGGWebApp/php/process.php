<?php
session_start();
require 'db_connections.php'; // Certifique-se de que o caminho está correto

if (!isset($conn)) {
    die("Falha na conexão com o banco de dados.");
}

if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if (!empty($username) && !empty($email) && !empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashedPassword')";

        if (mysqli_query($conn, $query)) {
            $_SESSION['success'] = "Cadastro realizado com sucesso!";
            header('Location: index.php');
        } else {
            $_SESSION['error'] = "Erro ao cadastrar: " . mysqli_error($conn);
            header('Location: index.php');
        }
    } else {
        $_SESSION['error'] = "Por favor, preencha todos os campos!";
        header('Location: index.php');
    }
}

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if (!empty($username) && !empty($password)) {
        $query = "SELECT * FROM users WHERE username='$username'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);

            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header('Location: dashboard.php');
            } else {
                $_SESSION['error'] = "Senha incorreta!";
                header('Location: index.php');
            }
        } else {
            $_SESSION['error'] = "Usuário não encontrado!";
            header('Location: index.php');
        }
    } else {
        $_SESSION['error'] = "Por favor, preencha todos os campos!";
        header('Location: index.php');
    }
}
?>
