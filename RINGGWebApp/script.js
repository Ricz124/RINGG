function remSec(button) {
    const secToRemove = button.parentElement;

    // Verifique se secToRemove existe
    if (!secToRemove) {
        console.error('Elemento pai não encontrado para o botão.');
        return;
    }

    const sectionId = secToRemove.id;

    // Verifique se o secToRemove tem um ID
    if (!sectionId) {
        console.error('ID não encontrado para a seção.');
        return;
    }

    console.log('Removendo a seção com ID:', sectionId);

    // Faça a requisição para remover a seção
    fetch('php/remove_section.php', {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({ id: sectionId }) // Envia o ID da seção no corpo
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Erro de rede: ' + response.statusText);
        }
        return response.json();
    })
    .then(data => {
        if (data.status === "success") {
            secToRemove.remove(); // Remove a seção do DOM
            console.log('Seção removida com sucesso');
        } else {
            console.error('Erro ao remover seção:', data.message);
        }
    })
    .catch(error => {
        console.error('Erro:', error.message); // Captura e exibe qualquer erro
    });
}



// Função para mover a seção para a esquerda
function mvEsq(button) {
    const sec = button.parentElement;
    const previousSec = sec.previousElementSibling;

    if (previousSec && previousSec.classList.contains('sec')) {
        sec.parentElement.insertBefore(sec, previousSec);
    }
}

// Função para mover a seção para a direita
function mvDir(button) {
    const sec = button.parentElement;
    const nextSec = sec.nextElementSibling;

    if (nextSec && nextSec.classList.contains('sec')) {
        sec.parentElement.insertBefore(nextSec, sec);
    }
}

// Função para começar a edição do título
function editTit(button, secTitId) {
    const secTit = document.getElementById(secTitId);
    const h3 = secTit.querySelector('h3');
    const input = secTit.querySelector('input');
    const editBtn = secTit.querySelector('button');
    const saveBtn = editBtn.nextElementSibling;

    h3.style.display = 'none';
    input.style.display = 'inline';
    input.value = h3.textContent;
    editBtn.style.display = 'none';
    saveBtn.style.display = 'inline';
}

// Função para salvar o novo título
function saveTit(button, secTitId) {
    const secTit = document.getElementById(secTitId);
    const h3 = secTit.querySelector('h3');
    const input = secTit.querySelector('input');
    const saveBtn = button;
    const editBtn = saveBtn.previousElementSibling;

    h3.textContent = input.value;
    h3.style.display = 'inline';
    input.style.display = 'none';
    saveBtn.style.display = 'none';
    editBtn.style.display = 'inline';

    // Salva a seção no banco de dados
    saveSection(h3.textContent, secTitId);
}

// Função para salvar a seção
function saveSection(sectionTitle, sectionId) {
    const data = { sectionTitle: sectionTitle, sectionId: sectionId };

    fetch('php/save_section.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Erro na rede: ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        if (data.status === 'success') {
            console.log('Seção salva com sucesso:', data);
        } else {
            console.error('Erro ao salvar a seção:', data.message);
        }
    })
    .catch(error => {
        console.error('Erro ao salvar a seção:', error);
    });
}

// Função para adicionar uma nova seção
function addSec() {
    const container = document.getElementById('espç-sec');
    const secCounter = container.children.length + 1;

    const newSec = document.createElement('div');
    newSec.classList.add('sec');
    newSec.id = `sec${secCounter}`;

    newSec.innerHTML = `
        <div class="sec-tit" id="sec-tit${secCounter}">
            <h3>Nome ${secCounter}</h3>
            <input type="text" id="edit-tit${secCounter}" style="display: none;">
            <button onclick="editTit(this, 'sec-tit${secCounter}')">Editar</button>
            <button onclick="saveTit(this, 'sec-tit${secCounter}')" style="display: none;">Salvar</button>
        </div>
        <button onclick="mvEsq(this)">esq</button>
        <button onclick="mvDir(this)">dir</button>
        <button onclick="remSec(this, '${newSec.id}')">Remover Seção</button>
    `;

    container.appendChild(newSec);
    
    // Salva a seção no servidor
    saveSection(`Nome ${secCounter}`, newSec.id);
}

// Inicializa o DOM
document.addEventListener('DOMContentLoaded', () => {
    loadSections();
    const addButton = document.getElementById('sec-button-add');
    addButton.addEventListener('click', addSec);
});

// Função para carregar seções
function loadSections() {
    fetch('php/endpoint.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.status === 'success') {
                const container = document.getElementById('espç-sec');
                container.innerHTML = '';

                data.sections.forEach(section => {
                    const newSec = document.createElement('div');
                    newSec.classList.add('sec');
                    newSec.id = `sec${section.id}`;
                    newSec.innerHTML = `
                        <div class="sec-tit" id="sec-tit${section.id}">
                            <h3>${section.section_title}</h3>
                            <input type="text" id="edit-tit${section.id}" style="display: none;">
                            <button onclick="editTit(this, 'sec-tit${section.id}')">Editar</button>
                            <button onclick="saveTit(this, 'sec-tit${section.id}')" style="display: none;">Salvar</button>
                        </div>
                        <button onclick="mvEsq(this)">esq</button>
                        <button onclick="mvDir(this)">dir</button>
                        <button onclick="remSec(this, '${newSec.id}')">Remover Seção</button>
                    `;

                    container.appendChild(newSec);
                });
            } else {
                console.error('Erro ao carregar seções:', data.message);
            }
        })
        .catch(error => {
            console.error('Erro ao buscar seções:', error);
        });
}
