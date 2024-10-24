<?php
session_start()
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciador de Tarefas</title>
    <link rel="stylesheet" href="caminho/para/seu/estilo.css">
</head>
<body>
    <div>
        <input type="text" id="task-title" placeholder="Título da Tarefa">
        <input type="text" id="checkbox-title" placeholder="Título do Checkbox">
        <select id="priority">
            <option value="green">Verde</option>
            <option value="yellow">Amarelo</option>
            <option value="red">Vermelho</option>
        </select>
        <input type="date" id="start-date">
        <input type="date" id="end-date">
        <button id="add-task">Adicionar Tarefa</button>
        <button id="save-tasks">Salvar Tarefas</button>
    </div>
    <div id="task-list"></div>

    <script src="caminho/para/seu/script.js"></script>
</body>
</html>
