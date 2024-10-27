<?php
session_start();
require 'php/db.php'; // Inclua seu arquivo de conexão com o banco de dados

// Você pode realizar consultas ao banco de dados aqui se necessário
// Exemplo: Verificar se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redireciona para a página de login se o usuário não estiver autenticado
    exit;
}

// Aqui você pode carregar colunas e cartões do banco de dados, se necessário
// Exemplo: $columns = fetchColumnsFromDatabase($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espaço de Trabalho</title>
    <link rel="stylesheet" href="../css/pagIndex.css">
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
    <script src="https://kit.fontawesome.com/602c4605e3.js" crossorigin="anonymous"></script>
</head>
<body>
    <nav>
        <div class="icone-ringg"><a href="index.php"><img src="../img/img2.jpg"></a></div>
        <div class="nav-mob">
            <ul>
                <a href="../quemsomos.html"><li><i class="fa-solid fa-question"></i></li></a>
                <a href="../ajuda.html"><li><i class="fa-solid fa-circle-info"></i></li></a>
                <a href="workstation.php"><li><i class="fa-solid fa-laptop"></i></li></a>
                <a href="php/dashboard.php"><li><i class="fa-solid fa-user"></i></li></a>
            </ul>
        </div>
        <div class="navbar">
            <div class="op-nav">
                <ul>
                    <a href="../quemsomos.html"><li>Quem Somos</li></a>
                    <a href="php/dashboard.php"><li>Dashboard</li></a>
                    <a href="../ajuda.html"><li>Ajuda</li></a>
                    <a href="workstation.php"><li>Espaço de Trabalho</li></a>
                    <a href="php/login.php"><li>ENTRAR</li></a>
                </ul>
            </div>
        </div>
    </nav>

    <header>
        <h1>Espaço de Trabalho</h1>
        <button onclick="addColumn()">Adicionar Coluna</button>
    </header>

    <main id="board">
        <div class="column" draggable="true" ondragstart="dragColumn(event)">
            <h2>Coluna 1</h2>
            <div class="card-container" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
            <button onclick="addCard(this)">Adicionar Card</button>
            <button onclick="deleteColumn(this)">Deletar Coluna</button>
        </div>
    </main>

    <!-- Modal de Detalhes do Cartão -->
    <div id="cardModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Detalhes do Card</h2>
            <label for="cardTitle">Título do Card:</label>
            <input type="text" id="cardTitle">

            <p id="creationDate"></p>
            <label for="dueDate">Data de Prazo:</label>
            <input type="date" id="dueDate">

            <h3>Lista de Tarefas</h3>
            <ul id="taskList"></ul>
            <button onclick="addCheckbox()">Adicionar Tarefa</button>
            <button onclick="deleteCheckboxes()">Deletar Tarefas Selecionadas</button>

            <h3>Cor do Card</h3>
            <input type="color" id="cardColorPicker" onchange="changeCardColor()">

            <!-- Botão para deletar o card -->
            <button onclick="deleteCard()">Deletar Card</button>
        </div>
    </div>

</body>
</html>