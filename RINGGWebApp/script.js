let draggedCard = null;
let draggedColumn = null;
let activeCard = null;

document.addEventListener("DOMContentLoaded", () => {
    // Salvar título do card a partir do modal, após o DOM estar carregado
    const cardTitleInput = document.getElementById("cardTitle");
    if (cardTitleInput) {
        cardTitleInput.addEventListener("input", (event) => {
            if (activeCard) {
                activeCard.querySelector(".card-title").textContent = event.target.value;
            }
        });
    }
});

// Função para adicionar uma nova coluna
function addColumn() {
    const board = document.getElementById("board");
    const columnCount = board.children.length + 1;

    const column = document.createElement("div");
    column.className = "column";
    column.draggable = true;
    column.ondragstart = dragColumn;
    column.ondragover = allowDrop;
    column.ondrop = dropColumn;
    column.innerHTML = `
      <h2 onclick="editColumnTitle(this)">Coluna ${columnCount}</h2>
      <input type="text" onblur="saveColumnTitle(this)" style="display: none;">
      <div class="card-container" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
      <button onclick="addCard(this)">Adicionar Card</button>
      <button onclick="deleteColumn(this)">Deletar Coluna</button>
    `;

    board.appendChild(column);

    // Salvar a nova coluna no banco de dados
    saveColumnToDB(`Coluna ${columnCount}`);
}

function saveColumnToDB(title) {
    fetch('php/save_column.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            title: title,
            userId: sessionStorage.getItem('user_id'), // Supondo que você armazena o ID do usuário na sessão
            orderIndex: document.getElementById("board").children.length
        }),
    }).then(response => response.json()).then(data => {
        console.log(data);
    }).catch((error) => {
        console.error('Erro:', error);
    });
}

// Função para adicionar um novo cartão
function addCard(button) {
    const cardContainer = button.previousElementSibling;
    const card = document.createElement("div");
    card.className = "card";
    card.draggable = true;
    card.ondragstart = dragCard;
    card.ondragover = allowDrop;
    card.ondrop = dropCard;
    card.onclick = () => openModal(card);
    card.dataset.creationDate = new Date().toLocaleDateString();
    card.dataset.color = "#ffffff";
    card.innerHTML = `<span class="card-title" onclick="editCardTitle(this)">Novo Card</span>
                      <input type="text" onblur="saveCardTitle(this)" style="display: none;">`;

    cardContainer.appendChild(card);

    // Salvar o novo cartão no banco de dados
    saveCardToDB(card);
}

function saveCardToDB(card) {
    fetch('php/save_card.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            title: card.querySelector(".card-title").textContent,
            userId: sessionStorage.getItem('user_id'), // ID do usuário
            columnId: card.parentNode.previousElementSibling.innerText.replace('Coluna ', ''),
            dueDate: card.dataset.dueDate || null,
            color: card.dataset.color,
            tasks: card.dataset.tasks || []
        }),
    }).then(response => response.json()).then(data => {
        console.log(data);
    }).catch((error) => {
        console.error('Erro:', error);
    });
}

// Funções de arrastar e soltar colunas e cartões
function dragColumn(event) {
    draggedColumn = event.target;
}

function dropColumn(event) {
    event.preventDefault();
    const targetColumn = event.target.closest(".column");
    if (draggedColumn && targetColumn && draggedColumn !== targetColumn) {
        const board = document.getElementById("board");
        board.insertBefore(draggedColumn, targetColumn.nextSibling);
        draggedColumn = null;
    }
}

function dragCard(event) {
    draggedCard = event.target;
}

function dropCard(event) {
    event.preventDefault();
    const targetCard = event.target.closest(".card");
    if (draggedCard && targetCard && draggedCard !== targetCard) {
        const parent = targetCard.parentNode;
        parent.insertBefore(draggedCard, targetCard.nextSibling);
        draggedCard = null;
    }
}

function allowDrop(event) {
    event.preventDefault();
}

// Modal de detalhes do cartão
function openModal(card) {
    activeCard = card;
    document.getElementById("cardModal").style.display = "block";
    document.getElementById("cardTitle").value = card.querySelector(".card-title").textContent;
    document.getElementById("creationDate").textContent = `Data de Criação: ${card.dataset.creationDate}`;
    document.getElementById("dueDate").value = card.dataset.dueDate || "";
    document.getElementById("cardColorPicker").value = card.dataset.color;

    loadCheckboxes();
}

function closeModal() {
    document.getElementById("cardModal").style.display = "none";

    // Salvar a data de prazo
    if (activeCard) {
      activeCard.dataset.dueDate = document.getElementById("dueDate").value; // Salvar data de prazo
    }
    
    saveCheckboxes();
}

// Função para salvar o título do card
function saveCardTitle(input) {
    const cardTitle = input.previousElementSibling;
    cardTitle.textContent = input.value;
    input.style.display = "none";
    cardTitle.style.display = "inline";
}

// Função para editar o título do card
function editCardTitle(titleElement) {
    const input = titleElement.nextElementSibling;
    input.value = titleElement.textContent;
    titleElement.style.display = "none";
    input.style.display = "inline";
    input.focus();
}

// Função para salvar o título da coluna
function saveColumnTitle(input) {
    const columnTitle = input.previousElementSibling;
    columnTitle.textContent = input.value;
    input.style.display = "none";
    columnTitle.style.display = "inline";
}

// Função para editar o título da coluna
function editColumnTitle(titleElement) {
    const input = titleElement.nextElementSibling;
    input.value = titleElement.textContent;
    titleElement.style.display = "none";
    input.style.display = "inline";
    input.focus();
}

// Função para adicionar uma nova tarefa no modal
function addCheckbox() {
    const taskList = document.getElementById("taskList");
    const li = document.createElement("li");
    li.innerHTML = `<input type="checkbox"> <input type="text" placeholder="Nova Tarefa">`;
    taskList.appendChild(li);
}

// Função para carregar as tarefas salvas no modal
function loadCheckboxes() {
    const taskList = document.getElementById("taskList");
    taskList.innerHTML = ""; // Limpa as tarefas anteriores
    const tasks = activeCard?.dataset.tasks ? JSON.parse(activeCard.dataset.tasks) : [];

    tasks.forEach(task => {
        const li = document.createElement("li");
        li.innerHTML = `<input type="checkbox" ${task.completed ? "checked" : ""}> <input type="text" value="${task.text}">`;
        taskList.appendChild(li);
    });
}

// Função para salvar as tarefas ao fechar o modal
function saveCheckboxes() {
    const taskList = document.getElementById("taskList").children;
    const tasks = Array.from(taskList).map(li => ({
        text: li.querySelector("input[type='text']").value,
        completed: li.querySelector("input[type='checkbox']").checked,
    }));

    if (activeCard) {
        activeCard.dataset.tasks = JSON.stringify(tasks);
    }
}

// Função para mudar a cor do card
function changeCardColor() {
    const colorPicker = document.getElementById("cardColorPicker");
    if (activeCard) {
        activeCard.dataset.color = colorPicker.value;
        activeCard.style.backgroundColor = colorPicker.value;
    }
}

// Salva tarefas ao fechar o modal
window.onclick = function(event) {
    if (event.target === document.getElementById("cardModal")) {
        closeModal();
    }
};

function deleteCheckboxes() {
    const taskList = document.getElementById("taskList");
    const checkboxes = taskList.querySelectorAll("input[type='checkbox']");
    
    // Filtrar as tarefas para remover aquelas que estão marcadas
    checkboxes.forEach((checkbox, index) => {
      if (checkbox.checked) {
        taskList.removeChild(checkbox.parentElement); // Remove a tarefa
      }
    });
}

function deleteColumn(button) {
    const column = button.parentElement; // Obter a coluna pai
    column.remove(); // Remover a coluna do DOM

    // Marcar a coluna como deletada no banco de dados
    deleteColumnFromDB(column.querySelector("h2").textContent);
}

function deleteColumnFromDB(title) {
    fetch('php/delete_column.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            title: title,
            userId: sessionStorage.getItem('user_id')
        }),
    }).then(response => response.json()).then(data => {
        console.log(data);
    }).catch((error) => {
        console.error('Erro:', error);
    });
}

function deleteCard() {
    if (activeCard) {
        // Remove o card do DOM
        const cardContainer = activeCard.parentNode; // Obtém o container do card
        cardContainer.removeChild(activeCard); // Remove o card do container
        closeModal(); // Fecha o modal após deletar o card

        // Marcar o card como deletado no banco de dados
        deleteCardFromDB(activeCard.querySelector(".card-title").textContent);
    }
}

function deleteCardFromDB(title) {
    fetch('php/delete_card.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            title: title,
            userId: sessionStorage.getItem('user_id')
        }),
    }).then(response => response.json()).then(data => {
        console.log(data);
    }).catch((error) => {
        console.error('Erro:', error);
    });
}