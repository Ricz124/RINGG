<?php
session_start()
?>

<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <title>Gerenciador de Tarefas</title>
    </head>
    <body>
        <div class="container">
            <h1>Gerenciador de Tarefas</h1>
            <div id="task-form">
                <input type="text" id="task-title" placeholder="Título da Tarefa" required>
                <input type="text" id="checkbox-title" placeholder="Título do Checkbox" required>
                <select id="priority">
                    <option value="green">Verde</option>
                    <option value="yellow">Amarelo</option>
                    <option value="red">Vermelho</option>
                </select>
                <input type="date" id="start-date" required>
                <input type="date" id="end-date" required>
                <button id="add-task">Adicionar Tarefa</button>
                <button id="save-tasks">Salvar Tarefas</button>
            </div>
            <div id="task-list"></div>
        </div>
        <script src="script.js"></script>
    </body>
    </html>
    