<?php include 'session_start.php'; ?> <!-- Inclui o arquivo de sessão -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workspace</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>
<body>
    <nav>
        <a href="../pagInicial/pag.html"><img src="#" alt="Ringg-icone" id="bagui"></a>
        <h3>RINGG</h3>
        <a href="#"><img src="#" alt="icone-usu"></a>
    </nav>

    <div class="fundo">
        <div class="wrkspc" id="">
            <div class="wrkspc-tit">
                <h3>Espaço de Trabalho</h3>
            </div>

            <div class="sec-button-add">
                <button id="sec-button-add">Adicionar Seção</button>
            </div>

            <div class="espç-sec" id="espç-sec">
                <div class="sec" id="sec1">
                    <div class="sec-tit" id="sec-tit1">
                        <h3>Nome Inicial 1</h3>
                        <input type="text" id="edit-tit1" style="display: none;">
                        <button onclick="editTit(this, 'sec-tit1')">Editar</button>
                        <button onclick="saveTit(this, 'sec-tit1')" style="display: none;">Salvar</button>
                    </div>
                    <button onclick="mvEsq(this)">esq</button>
                    <button onclick="mvDir(this)">dir</button>
                    <button onclick="remSec(this)">remover</button>
                </div>
                <div class="sec" id="sec2">
                    <div class="sec-tit" id="sec-tit2">
                        <h3>Nome Inicial 2</h3>
                        <input type="text" id="edit-tit2" style="display: none;">
                        <button onclick="editTit(this, 'sec-tit2')">Editar</button>
                        <button onclick="saveTit(this, 'sec-tit2')" style="display: none;">Salvar</button>
                    </div>
                    <button onclick="mvEsq(this)">esq</button>
                    <button onclick="mvDir(this)">dir</button>
                    <button onclick="remSec(this)">remover</button>
                </div>
                <div class="sec" id="sec3">
                    <div class="sec-tit" id="sec-tit3">
                        <h3>Nome Inicial 3</h3>
                        <input type="text" id="edit-tit3" style="display: none;">
                        <button onclick="editTit(this, 'sec-tit3')">Editar</button>
                        <button onclick="saveTit(this, 'sec-tit3')" style="display: none;">Salvar</button>
                    </div>
                    <button onclick="mvEsq(this)">esq</button>
                    <button onclick="mvDir(this)">dir</button>
                    <button onclick="remSec(this)">remover</button>
                </div>
            </div>

            <!-- Link para voltar ao dashboard -->
            <div class="back-link">
                <a href="php/dashboard.php">Voltar ao Dashboard</a>
            </div>
        </div>
    </div>
</body>
</html>
