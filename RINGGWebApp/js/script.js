document.addEventListener('DOMContentLoaded', () => {
    loadColumns();
    document.getElementById('add-column-btn').addEventListener('click', createColumn);
});

// Função para carregar colunas e cards do servidor
function loadColumns() {
    fetch('php/kanban.php')
        .then(response => response.json())
        .then(data => {
            const board = document.getElementById('kanban-board');
            board.innerHTML = '';
            data.columns.forEach(column => {
                const columnDiv = createColumnElement(column);
                board.appendChild(columnDiv);
            });
        });
}

// Função para criar o elemento de coluna e anexar eventos
function createColumnElement(column) {
    const columnDiv = document.createElement('div');
    columnDiv.className = 'column';
    columnDiv.dataset.columnId = column.id;
    columnDiv.innerHTML = `
        <h3>${column.name}</h3>
        <button onclick="deleteColumn(${column.id})">Delete</button>
        <button onclick="addCard(${column.id})">Add Card</button>
        <div class="card-list"></div>
    `;

    column.cards.forEach(card => {
        const cardDiv = createCardElement(card);
        columnDiv.querySelector('.card-list').appendChild(cardDiv);
    });

    return columnDiv;
}

// Função para criar o elemento de card e anexar eventos
function createCardElement(card) {
    const cardDiv = document.createElement('div');
    cardDiv.className = 'card';
    cardDiv.dataset.cardId = card.id;
    cardDiv.style.backgroundColor = card.color;
    cardDiv.innerHTML = `
        <h4>${card.name}</h4>
        <p>Due Date: ${card.due_date || 'Not set'}</p>
        <button onclick="editCard(${card.id})">Edit</button>
        <button onclick="deleteCard(${card.id})">Delete</button>
    `;
    return cardDiv;
}

// Função para criar uma nova coluna
function createColumn() {
    const columnName = prompt("Enter column name:");
    if (columnName) {
        fetch('php/column.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ name: columnName })
        })
        .then(() => loadColumns());
    }
}

// Função para deletar uma coluna
function deleteColumn(columnId) {
    fetch(`php/column.php?id=${columnId}`, { method: 'DELETE' })
        .then(() => loadColumns());
}

// Função para adicionar um novo card a uma coluna
function addCard(columnId) {
    const cardName = prompt("Enter card name:");
    const dueDate = prompt("Enter due date (YYYY-MM-DD):");
    const color = prompt("Enter color (e.g., #ff0000):");

    if (cardName) {
        fetch('php/card.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ column_id: columnId, name: cardName, color, due_date: dueDate })
        })
        .then(() => loadColumns());
    }
}

// Função para editar um card
function editCard(cardId) {
    const newCardName = prompt("Edit card name:");
    const newDueDate = prompt("Edit due date (YYYY-MM-DD):");
    const newColor = prompt("Edit color (e.g., #ff0000):");

    fetch(`php/card.php?id=${cardId}`, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ name: newCardName, due_date: newDueDate, color: newColor })
    })
    .then(() => loadColumns());
}

// Função para deletar um card
function deleteCard(cardId) {
    fetch(`php/card.php?id=${cardId}`, { method: 'DELETE' })
        .then(() => loadColumns());
}
