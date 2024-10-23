<?php include 'session_start.php'; ?> <!-- Inclui o arquivo de sessão -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workspace</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="./css/pagIndex.css">
    <script src="script.js" defer></script>
</head>
<body>
    <nav>
      <div class="icone-ringg"><a href="index.html"><img src="./img/img2.jpg"></a></div>
      <div class="nav-mob">
        <ul>
          <a href="./quemsomos.html"><li><i class="fa-solid fa-question"></i></li></a>
          <a href="./ajuda.html"><li><i class="fa-solid fa-circle-info"></i></li></a>
          <a href="workstation.php"><li><i class="fa-solid fa-laptop"></i></li></a>
          <a href="php/index.php"><li><i class="fa-solid fa-user"></i></li></a>
        </ul>
      </div>
      <div class="navbar">
        <div class="op-nav">
          <ul>
            <a href="quemsomos.html"><li>Quem Somos</li></a>
            <a href="./RINGGWebApp/php/dashboard.php"><li>Dashboard</li></a>
            <a href="ajuda.html"><li>Ajuda</li></a>
            <a href="RINGGWebApp/workstation.php"><li>Espaço de Trabalho</li></a>
            <a href="./RINGGWebApp/php/index.php"><li>ENTRAR</li></a>
          </ul>
        </div>
      </div>
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
