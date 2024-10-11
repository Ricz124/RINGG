<?php
// Inicie a sessão
include '../session_start.php'; // Atualize para o caminho correto, se necessário
require '../php/db_connections.php'; // Caminho para o arquivo de conexão

// Verifica se a variável de conexão foi definida
if (!isset($pdo)) {
    die("Falha na conexão com o banco de dados.");
}

// Processamento do registro
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!empty($username) && !empty($email) && !empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        try {
            $query = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->execute();
            $_SESSION['success'] = "Cadastro realizado com sucesso!";
            header('Location: index.php');
            exit();
        } catch (PDOException $e) {
            $_SESSION['error'] = "Erro ao cadastrar: " . $e->getMessage();
            header('Location: index.php');
            exit();
        }
    } else {
        $_SESSION['error'] = "Por favor, preencha todos os campos!";
        header('Location: index.php');
        exit();
    }
}

// Processamento do login
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!empty($username) && !empty($password)) {
        try {
            $query = "SELECT * FROM users WHERE username = :username";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if (password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    header('Location: dashboard.php');
                    exit();
                } else {
                    $_SESSION['error'] = "Senha incorreta!";
                    header('Location: index.php');
                    exit();
                }
            } else {
                $_SESSION['error'] = "Usuário não encontrado!";
                header('Location: index.php');
                exit();
            }
        } catch (PDOException $e) {
            $_SESSION['error'] = "Erro ao acessar o banco de dados: " . $e->getMessage();
            header('Location: index.php');
            exit();
        }
    } else {
        $_SESSION['error'] = "Por favor, preencha todos os campos!";
        header('Location: index.php');
        exit();
    }
}
?>
