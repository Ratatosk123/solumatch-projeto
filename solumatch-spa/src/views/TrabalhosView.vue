<template>
<header class="header">
    <nav class="navbar">
        <a href="/trabalhos">
            <div class="logo">
                <img src="../assets/misc/logo2.png" width="50vh">
                <h2>Solu<span>Match</span></h2>
            </div>
        </a>
        <div class="navbar-icons-container">
            <button id="header-tts-toggle" class="header-accessibility-btn" aria-label="Ativar leitura de tela.">
                <img src="../assets/misc/audio-icon.svg" alt="Ícone de áudio para acessibilidade">
            </button>
            <button id="voice-command-toggle" class="header-accessibility-btn" title="Ativar comando de voz" aria-label="Ativar comando de voz para controlar a acessibilidade">
                <img src="../assets/misc/microphone-icon.svg" alt="Ícone de microfone para comando de voz">
            </button>
            <div class="notification-icon" id="notificationIcon">
                <i class="fas fa-bell"></i>
                <span class="notification-dot" id="notificationDot" style="display: none;"></span>
                <div class="notification-dropdown" id="notificationDropdown">
                    <div class="notification-header">Notificações</div>
                    <div class="notification-list" id="notificationList"></div>
                </div>
            </div>
            <div class="dropdown">
                <div class="profile-icon" id="profileIcon">
                    <img class="profile" id="headerProfileIcon" src="../assets/misc/Perfil_imagem.jpg" alt="Perfil">
                </div>
                <div class="dropdown-menu" id="dropdownMenu">
                    <div><strong>Seja bem vindo ao Solu<span>Match</span></strong></div>
                    <div class="section"><a href="<?php echo htmlspecialchars($perfilLink); ?>">Meu perfil</a></div>
                    <div class="section"><a href="meus_chats.php">Minhas Mensagens</a></div>
                    <div class="section"><a href="ajuda.html">Obter Ajuda</a></div>
                    <div class="section"><a href="../PHP/logout.php">Sair</a></div>
                </div>
            </div>
        </div>
    </nav>
</header>
<div class="workana-jobs-container">
    <aside class="jobs-filter-sidebar">
        <div class="filter-section">
            <h3 class="filter-title">Categorias</h3>
            <ul class="filter-list">
                <li class="filter-item active">Todos</li>
                <li class="filter-item">Programação</li>
                <li class="filter-item">Design</li>
                <li class="filter-item">Marketing</li>
                <li class="filter-item">Redação</li>
                <li class="filter-item">Suporte Administrativo</li>
                <li class="filter-item">Jurídico</li>
                <li class="filter-item">Finanças</li>
            </ul>
        </div>
        <div class="filter-section">
            <h3 class="filter-title">Tipo de Contratação</h3>
            <div class="filter-checkbox">
                <input type="checkbox" id="fixed-price" checked>
                <label for="fixed-price">Preço Fixo / PJ / Freelance</label>
            </div>
            <div class="filter-checkbox">
                <input type="checkbox" id="hourly-rate" checked>
                <label for="hourly-rate">CLT / Estágio</label>
            </div>
        </div>
    </aside>
    <main class="jobs-main-content">
        <div class="jobs-search-bar">
            <input type="text" class="search-input" placeholder="Pesquisar por título, habilidade...">
            <button class="search-button">Buscar</button>
        </div>
        <div class="jobs-sorting">
            <span class="sorting-label">Ordenar por:</span>
            <select class="sorting-select">
                <option value="mais-recentes">Mais recentes</option>
                <option value="menor-orcamento">Menor orçamento</option>
                <option value="maior-orcamento">Maior orçamento</option>
            </select>
        </div>
        <div class="jobs-list">
            </div>
        <div class="jobs-pagination">
            </div>
    </main>
</div>

<div class="job-modal" id="jobModal">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <h2 class="modal-title" id="modalJobTitle"></h2>
        <div class="modal-budget" id="modalJobBudget"></div>
        <div class="modal-section"><h3>Descrição do Projeto</h3><p id="modalJobDescription"></p></div>
        <div class="modal-section"><h3>Habilidades Requeridas</h3><div class="modal-skills" id="modalJobSkills"></div></div>
        <div class="modal-footer"><span id="modalJobPosted"></span><span id="modalJobProposals"></span></div>
        <button class="apply-button">Enviar Proposta</button>
    </div>
</div>

<div class="job-modal" id="directChatModal">
    <div class="modal-content">
        <span class="close-modal" id="closeChatModal">&times;</span>
        <h2 class="modal-title" id="chatModalTitle">Conversa sobre a vaga</h2>
        <div class="chat-area" id="chatArea"></div>
        <div class="chat-input-area">
            <input type="file" id="chatAttachmentInput" style="display: none;">
            <button id="chatAttachmentBtn" title="Anexar arquivo">📎</button>
            <textarea id="chatMessageInput" placeholder="Digite sua mensagem..." rows="1"></textarea>
            <button id="chatSendBtn">Enviar</button>
        </div>
    </div>
</div>

</template>


<script setup lang='ts'>
import '@/assets/css/trabalhos.css'
import '@/assets/js/dropdown.js'
import '@/assets/js/acessibilidade_tts.js'
</script>