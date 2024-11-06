<?php
// Recebe o conteúdo da requisição POST (JSON)
$json = file_get_contents('php://input');

// Decodifica o JSON em um array associativo PHP
$data = json_decode($json, true);

// Verifica se a decodificação foi bem-sucedida
if ($data) {
    // Percorre cada coluna
    foreach ($data['columns'] as $column) {
        // Armazena os dados da coluna em variáveis
        $columnId = $column['id'];
        $columnTitle = $column['title'];

        echo "Coluna ID: $columnId\n";
        echo "Coluna Título: $columnTitle\n";

        // Percorre cada cartão dentro da coluna
        foreach ($column['cards'] as $card) {
            // Armazena os dados do cartão em variáveis
            $cardId = $card['id'];
            $cardTitle = $card['title'];
            $cardCreationDate = $card['creationDate'];
            $cardDueDate = $card['dueDate'];
            $cardColor = $card['color'];

            echo "Card ID: $cardId\n";
            echo "Card Título: $cardTitle\n";
            echo "Data de Criação do Card: $cardCreationDate\n";
            echo "Data de Prazo do Card: $cardDueDate\n";
            echo "Cor do Card: $cardColor\n";

            // Percorre cada tarefa dentro do cartão
            foreach ($card['tasks'] as $task) {
                // Armazena os dados da tarefa em variáveis
                $taskText = $task['text'];
                $taskCompleted = $task['completed'] ? 'true' : 'false';

                echo "Tarefa: $taskText\n";
                echo "Concluída: $taskCompleted\n";
            }
        }
    }
} else {
    echo "Erro ao decodificar os dados JSON.";
}
?>
