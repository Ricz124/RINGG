// Função para remover uma seção
function remSec(button) {
    const secToRemove = button.parentElement;
    secToRemove.remove();
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
}

// Função para adicionar uma nova seção
function addSec() {
    const container = document.getElementById('espç-sec');
    const secCounter = container.children.length + 1; // Calcula o novo contador de seções

    // Cria uma nova div com a classe 'sec'
    const newSec = document.createElement('div');
    newSec.classList.add('sec');
    newSec.id = `sec${secCounter}`;

    // Adiciona conteúdo à nova sec, incluindo os botões de movimento, remoção e o novo botão de checkbox
    newSec.innerHTML = `
        <div class="sec-tit" id="sec-tit${secCounter}">
            <h3>Nome ${secCounter}</h3>
            <input type="text" id="edit-tit${secCounter}" style="display: none;">
            <button onclick="editTit(this, 'sec-tit${secCounter}')">Editar</button>
            <button onclick="saveTit(this, 'sec-tit${secCounter}')" style="display: none;">Salvar</button>
        </div>
        <button onclick="mvEsq(this)">esq</button>
        <button onclick="mvDir(this)">dir</button>
        <button onclick="remSec(this)">remover</button>
        <button onclick="addCheckboxInput(this, 'sec${secCounter}')">Adicionar Checkbox</button>
        <div class="checkbox-container" id="checkbox-container${secCounter}"></div>
    `;

    // Adiciona a nova sec ao container
    container.appendChild(newSec);
}

// Função para adicionar o input e converter para checkbox
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

        // Cria o checkbox e a label
        const checkbox = document.createElement('input');
        checkbox.type = 'checkbox';
        const label = document.createElement('label');
        label.textContent = inputValue;

        // Adiciona o checkbox e a label ao container
        checkboxContainer.appendChild(checkbox);
        checkboxContainer.appendChild(label);

        // Remove o input e o botão de confirmar após adicionar o checkbox
        input.remove();
        confirmButton.remove();
    });
}

document.addEventListener('DOMContentLoaded', () => {
    const addButton = document.getElementById('sec-button-add');

    // Adiciona o evento de clique ao botão de adicionar
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

function saveSection(sectionTitle) {
    const data = { sectionTitle: sectionTitle };

    fetch('save_section.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    }).then(response => response.json())
      .then(result => {
          console.log('Seção salva:', result);
      });
}

function saveCheckbox(sectionId, label, checked) {
    const data = { sectionId: sectionId, label: label, checked: checked };

    fetch('save_checkbox.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    }).then(response => response.json())
      .then(result => {
          console.log('Checkbox salvo:', result);
      });
}

