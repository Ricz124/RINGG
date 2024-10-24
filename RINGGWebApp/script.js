function remSec(sectionId) { // Modificado para aceitar apenas o sectionId
    const data = { sectionId: sectionId };

    fetch('php/remove_section.php', {
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
            console.log('Seção removida com sucesso:', data);
            // Remove a seção do DOM após a resposta bem-sucedida
            const sectionElement = document.getElementById(sectionId);
            if (sectionElement) {
                sectionElement.remove();
            }
        } else {
            console.error('Erro ao remover a seção:', data.message);
        }
    })
    .catch(error => {
        console.error('Erro ao remover a seção:', error);
    });
}

// Função para adicionar uma nova seção
function addSec() {
    const container = document.getElementById('espç-sec');
    const secCounter = container.children.length + 1;

    const newSec = document.createElement('div');
    newSec.classList.add('sec');
    newSec.id = `sec${secCounter}`; // ID único para a seção

    newSec.innerHTML = `
        <div class="sec-tit" id="sec-tit${secCounter}">
            <h3>Nome ${secCounter}</h3>
            <input type="text" id="edit-tit${secCounter}" style="display: none;">
            <button onclick="editTit(this, 'sec-tit${secCounter}')">Editar</button>
            <button onclick="saveTit(this, 'sec-tit${secCounter}')" style="display: none;">Salvar</button>
        </div>
        <button onclick="mvEsq(this)">esq</button>
        <button onclick="mvDir(this)">dir</button>
        <button onclick="remSec('${newSec.id}')">Remover Seção</button>
    `;

    container.appendChild(newSec);

    // Salva a seção no servidor
    saveSection(`Nome ${secCounter}`, newSec.id);
}

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
                        <button onclick="remSec('${newSec.id}')">Remover Seção</button>
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

// Inicializa o DOM
document.addEventListener('DOMContentLoaded', () => {
    loadSections();
    const addButton = document.getElementById('sec-button-add');
    addButton.addEventListener('click', addSec);
});
