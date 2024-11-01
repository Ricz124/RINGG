document.addEventListener('DOMContentLoaded', () => {
    loadColumns(); // Carregar colunas e cards no carregamento da página

    document.getElementById('btnAddColumn').addEventListener('click', () => {
        const columnName = prompt('Digite o nome da coluna:');
        if (columnName) {
            createColumn(columnName);
        }
    });
});

function loadColumns() {
    fetch('api/get_columns.php')
        .then(response => response.json())
        .then(data => {
            data.columns.forEach(column => {
                const newColumn = document.createElement('div');
                newColumn.className = 'column';
                newColumn.innerHTML = `<h3>${column.name}</h3>
                                       <button onclick="editColumn(${column.id})">Editar</button>
                                       <button onclick="deleteColumn(${column.id})">Deletar</button>
                                       <button onclick="addCard(${column.id})">Adicionar Card</button>
                                       <div class="cards"></div>`;
                column.cards.forEach(card => {
                    const cardElement = document.createElement('div');
                    cardElement.className = 'card';
                    cardElement.innerText = card.name;
                    cardElement.innerHTML += `<button onclick="editCard(${card.id})">Editar</button>
                                              <button onclick="deleteCard(${card.id})">Deletar</button>`;
                    newColumn.querySelector('.cards').appendChild(cardElement);
                });
                document.getElementById('board').appendChild(newColumn);
            });
        });
}

function createColumn(name) {
    fetch('api/create_column.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ name }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const newColumn = document.createElement('div');
            newColumn.className = 'column';
            newColumn.innerHTML = `<h3>${name}</h3>
                                   <button onclick="addCard(${data.columnId})">Adicionar Card</button>
                                   <div class="cards"></div>`;
            document.getElementById('board').appendChild(newColumn);
        }
    });
}

function editColumn(columnId) {
    const newName = prompt('Digite o novo nome da coluna:');
    if (newName) {
        fetch('api/edit_column.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ id: columnId, name: newName }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload(); // Recarrega a página após a edição
            }
        });
    }
}

function deleteColumn(columnId) {
    if (confirm('Tem certeza que deseja deletar esta coluna?')) {
        fetch('api/delete_column.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ id: columnId }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload(); // Recarrega a página após a exclusão
            }
        });
    }
}

function addCard(columnId) {
    const cardName = prompt('Digite o nome do card:');
    if (cardName) {
        fetch('api/create_card.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ name: cardName, columnId }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const cardElement = document.createElement('div');
                cardElement.className = 'card';
                cardElement.innerText = cardName;
                cardElement.innerHTML += `<button onclick="editCard(${data.cardId})">Editar</button>
                                          <button onclick="deleteCard(${data.cardId})">Deletar</button>`;
                
                const cardsContainer = document.querySelector(`.column:nth-child(${columnId}) .cards`);
                if (cardsContainer) {
                    cardsContainer.appendChild(cardElement);
                    location.reload(); // Recarrega a página após a edição
                } else {
                    console.error('Cards container not found for column ID:', columnId);
                }
            }
        })
        .catch(error => console.error('Error adding card:', error));
    }
}

function editCard(cardId) {
    const newName = prompt('Digite o novo nome do card:');
    if (newName) {
        fetch('api/edit_card.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ id: cardId, name: newName }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload(); // Recarrega a página após a edição
            }
        });
    }
}

function deleteCard(cardId) {
    if (confirm('Tem certeza que deseja deletar este card?')) {
        fetch('api/delete_card.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ id: cardId }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload(); // Recarrega a página após a exclusão
            }
        });
    }
}

// Modal functionality
const modal = document.getElementById("modal");
const btnRegister = document.getElementById("btnRegister");
const btnLogin = document.getElementById("btnLogin");
const closeModal = document.getElementsByClassName("close")[0];

btnRegister.onclick = function() {
    modal.style.display = "block";
    document.getElementById("modalTitle").innerText = "Registrar";
    document.getElementById("submitBtn").innerText = "Registrar";
    document.getElementById("authForm").onsubmit = registerUser;
}

btnLogin.onclick = function() {
    modal.style.display = "block";
    document.getElementById("modalTitle").innerText = "Login";
    document.getElementById("submitBtn").innerText = "Login";
    document.getElementById("authForm").onsubmit = loginUser;
}

closeModal.onclick = function() {
    modal.style.display = "none";
}

window.onclick = function(event) {
    if (event.target === modal) {
        modal.style.display = "none";
    }
}

function registerUser(event) {
    event.preventDefault();
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    fetch('api/register.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ name, email, password }),
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        modal.style.display = "none";
    });
}

function loginUser(event) {
    event.preventDefault();
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    fetch('api/login.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ email, password }),
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        modal.style.display = "none";
    });
}
