// Função para remover uma seção
function remSec(button) {
    const secToRemove = button.parentElement;
    const secId = secToRemove.id; // Captura o ID da seção para remover do banco de dados

    // Chama uma função para remover a seção do servidor
    removeSection(secId)
        .then(() => {
            secToRemove.remove();
        });
}

// Função para remover a seção do servidor
function removeSection(sectionId) {
    const data = { sectionId: sectionId };

    return fetch('php/remove_section.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
    .then(response => {
        console.log('Response Status:', response.status);  // Adicione isso para ver o status da resposta
        return response.text();  // Alterar para 'text()' temporariamente para capturar a resposta bruta
    })
    .then(text => {
        console.log('Raw Response:', text);  // Exibir a resposta bruta
        return JSON.parse(text);  // Agora tentamos fazer o parse manualmente
    })
    .then(result => {
        console.log('Seção removida:', result);
        if (result.status !== 'success') {
            throw new Error(result.message);
        }
    })
    .catch(error => console.error('Erro ao remover a seção:', error));
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

    // Atualiza o título
    h3.textContent = input.value;
    h3.style.display = 'inline';
    input.style.display = 'none';
    saveBtn.style.display = 'none';
    editBtn.style.display = 'inline';

    // Salva a seção no banco de dados
    saveSection(h3.textContent, secTitId); // Aqui passamos o título correto e o ID da seção
}

// Função para salvar a seção
function saveSection(sectionTitle, sectionId) {
    const data = { sectionTitle: sectionTitle, sectionId: sectionId }; // Passa o ID da seção para o PHP

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
    const secCounter = container.children.length + 1; // Calcula o novo contador de seções

    // Cria uma nova div com a classe 'sec'
    const newSec = document.createElement('div');
    newSec.classList.add('sec');
    newSec.id = `sec${secCounter}`;

    // Adiciona conteúdo à nova sec, incluindo os botões de movimento e remoção
    newSec.innerHTML = `
        <div class="sec-tit" id="sec-tit${secCounter}">
            <h3>Nome ${secCounter}</h3>
            <input type="text" id="edit-tit${secCounter}" style="display: none;">
            <button onclick="editTit(this, 'sec-tit${secCounter}')">Editar</button>
            <button onclick="saveTit(this, 'sec-tit${secCounter}')" style="display: none;">Salvar</button>
        </div>
        <button onclick="mvEsq(this)">◄</button> <!-- Botão de mover para esquerda -->
        <button onclick="mvDir(this)">▶</button> <!-- Botão de mover para direita -->
        <button onclick="remSec(this)" id="btRemov">X</button>
        <div class="checkbox-container"></div>
        <button onclick="addCheckboxInput(this, 'sec${secCounter}')">Adicionar Checkbox</button>
    `;

    // Adiciona a nova sec ao container
    container.appendChild(newSec);

    // Salva a seção no servidor
    saveSection(`Nome ${secCounter}`, newSec.id); // Aqui você pode salvar o título da seção
}

// Função para adicionar um novo checkbox
function addCheckboxInput(button, secId) {
    const sec = document.getElementById(secId);
    const checkboxContainer = sec.querySelector('.checkbox-container');

    // Cria o input de texto
    const input = document.createElement('input');
    input.type = 'text';
    input.placeholder = 'Escreva o texto para o checkbox';

    // Cria o botão de confirmar
    const confirmButton = document.createElement('button');
    confirmButton.textContent = 'Confirmar';

    // Cria uma lista não ordenada se não existir
    let checkboxList = checkboxContainer.querySelector('ul');
    if (!checkboxList) {
        checkboxList = document.createElement('ul');
        checkboxContainer.appendChild(checkboxList);
    }

    // Adiciona os elementos ao container
    checkboxContainer.appendChild(input);
    checkboxContainer.appendChild(confirmButton);

    // Quando o botão de confirmar for clicado
    confirmButton.addEventListener('click', () => {
        const inputValue = input.value.trim();

        if (inputValue === '') {
            alert('Por favor, insira um texto válido.');
            return;
        }

        // Verifica se o checkbox já existe
        const existingCheckboxes = Array.from(checkboxList.querySelectorAll('input[type="checkbox"]'));
        if (existingCheckboxes.some(cb => cb.nextSibling.textContent === inputValue)) {
            alert('Checkbox com esse texto já existe.');
            return;
        }

        // Cria o checkbox e a label
        const checkboxItem = document.createElement('li');
        const checkbox = document.createElement('input');
        checkbox.type = 'checkbox';
        checkbox.checked = false; // Inicialmente não checado
        const label = document.createElement('label');
        label.textContent = inputValue;

        // Adiciona o checkbox e a label ao item da lista
        checkboxItem.appendChild(checkbox);
        checkboxItem.appendChild(label);
        checkboxList.appendChild(checkboxItem);

        // Salva o checkbox no banco de dados
        saveCheckbox(secId, inputValue, checkbox.checked);

        // Adiciona um listener para salvar mudanças no estado do checkbox
        checkbox.addEventListener('change', () => {
            saveCheckbox(secId, inputValue, checkbox.checked); // Atualiza o estado no banco de dados
        });

        // Remove o input e o botão de confirmar após adicionar o checkbox
        input.remove();
        confirmButton.remove();
    });
}

// Função para salvar checkbox
function saveCheckbox(sectionId, label, checked) {
    const data = { sectionId: sectionId, label: label, checked: checked };

    fetch('php/save_checkbox.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        if (result.status === 'success') {
            alert('Checkbox salvo com sucesso!');
        } else {
            alert('Erro ao salvar checkbox: ' + result.message);
        }
    })
    .catch(error => console.error('Erro ao salvar checkbox:', error));
}

// Código para inicializar o DOM
document.addEventListener('DOMContentLoaded', () => {
    loadSections(); // Chama a função para carregar as seções
    const addButton = document.getElementById('sec-button-add');
    addButton.addEventListener('click', addSec);

    // Função para remover as seções iniciais 'Nome Inicial 1, 2 e 3'
    const initialSections = ['sec1', 'sec2', 'sec3'];
    initialSections.forEach(secId => {
        const secToRemove = document.getElementById(secId);
        if (secToRemove) {
            secToRemove.remove();
        }
    });
});

// Função para carregar as seções do servidor
function loadSections() {
    fetch('php/endpoint.php')
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById('espç-sec');
            data.sections.forEach(section => {
                const newSec = document.createElement('div');
                newSec.classList.add('sec');
                newSec.id = section.id;

                newSec.innerHTML = `
                    <div class="sec-tit" id="sec-tit${section.id}">
                        <h3>${section.title}</h3>
                        <input type="text" id="edit-tit${section.id}" style="display: none;">
                        <button onclick="editTit(this, 'sec-tit${section.id}')">Editar</button>
                        <button onclick="saveTit(this, 'sec-tit${section.id}')" style="display: none;">Salvar</button>
                    </div>
                    <button onclick="mvEsq(this)">◄</button>
                    <button onclick="mvDir(this)">▶</button>
                    <button onclick="remSec(this)">X</button>
                    <div class="checkbox-container"></div>
                    <button onclick="addCheckboxInput(this, '${section.id}')">Adicionar Checkbox</button>
                `;

                container.appendChild(newSec);
            });
        })
        .catch(error => console.error('Erro ao carregar seções:', error));
}
