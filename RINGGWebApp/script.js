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

    // Adiciona conteúdo à nova sec, incluindo os botões de movimento e remoção
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
    `;

    // Adiciona a nova sec ao container
    container.appendChild(newSec);
}

document.addEventListener('DOMContentLoaded', () => {
    const addButton = document.getElementById('sec-button-add');

    // Adiciona o evento de clique ao botão de adicionar
    addButton.addEventListener('click', addSec);
});
