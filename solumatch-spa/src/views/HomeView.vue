<template>
      <header class="header">
        <nav class="navbar">
            <router-link to="/"><a href="../templates/home.html">
                <div class="logo">
                    <img src="../assets/misc/logo.png" width="50vh">
                    <h2>Solu<span>Match</span></h2>
                </div>
            </a></router-link>

            <div class="nav-links">
                <router-link to="/login"><a class="login-link">Faça login</a></router-link>
                <router-link to="/cadastro-usuario"><a class="cta-button">Cadastre-se</a></router-link>
                <router-link to=""><a class="btn-suporte">Obtenha ajuda</a></router-link>
            </div>

            
            
            <div class="mobile-menu-toggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </nav>
    </header>
  <div class="main-content">
    <section class="hero">
      <div class="hero-content">
        <div class="hero-text">
          <h1>
            Conecte sua empresa com
            <span class="highlight">os melhores parceiros</span>
            e profissionais qualificados
          </h1>
          
          <p class="hero-description">
            Desenvolva seu negócio de forma rápida e assertiva.
            Conectamos você com empresas e profissionais ideais através de 
            filtros inteligentes e critérios personalizados.
          </p>
          
          <div class="hero-buttons">
            <router-link to="/cadastro-empresa" class="primary-button">Quero Contratar</router-link>
            
            <router-link to="/cadastro-usuario" class="secondary-button">
              Quero Prestar Serviços <span class="arrow">→</span>
            </router-link>
          </div>
        </div>
        
        <div class="hero-visuals">
          <div class="profile-image profile-1">
            <img src="/allan_foto.jpg" alt="Profissional 1"> </div>
          <div class="profile-image profile-2">
            <img src="/kayky_foto.jpg" alt="Profissional 2">
          </div>
          <div class="profile-image profile-3">
            <img src="/pedro_foto.jpg" alt="Profissional 3">
          </div>
          <div class="decorative-element element-1"></div>
          <div class="decorative-element element-2"></div>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup lang="ts">
import '@/assets/css/nav_bar.css'
// Para uma página estática como esta, a seção de script pode ser bem simples.
// Não precisamos buscar dados ou ter uma lógica complexa.
</script>

<style scoped>
/* Aqui você pode copiar os estilos do seu arquivo 'home.css' original */
/* Exemplo com os principais estilos adaptados: */

.main-content {
  max-width: 1200px;
  margin: 0 auto;
  padding: 2rem;
}

.hero {
  min-height: 70vh;
  display: flex;
  align-items: center;
}

.hero-content {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 4rem;
  align-items: center;
  width: 100%;
}

.hero-text h1 {
  font-size: 3.2rem;
  font-weight: 700;
  line-height: 1.2;
  margin-bottom: 1.5rem;
  color: #1f2937;
}

.highlight {
  color: rgb(0, 89, 255);
}

.hero-description {
  font-size: 1.2rem;
  color: #666;
  margin-bottom: 2rem;
}

.hero-buttons {
  display: flex;
  gap: 1.5rem;
  align-items: center;
}

.primary-button, .secondary-button {
  text-decoration: none;
  font-weight: 600;
  transition: all 0.3s ease;
  padding: 1rem 2rem;
  border-radius: 25px;
}

.primary-button {
  background: rgb(0, 89, 255);
  color: white;
}

.primary-button:hover {
  background: rgb(0, 70, 210);
  transform: translateY(-2px);
}

.secondary-button {
  color: #666;
}

.secondary-button:hover {
  color: rgb(0, 89, 255);
}

.arrow {
  transition: transform 0.3s ease;
  display: inline-block;
}

.secondary-button:hover .arrow {
  transform: translateX(5px);
}

.hero-visuals {
  position: relative;
  height: 500px;
}

.profile-image {
  position: absolute;
  width: 80px;
  height: 80px;
  border-radius: 50%;
  overflow: hidden;
  border: 3px solid white;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
  animation: float 6s ease-in-out infinite;
}

.profile-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

/* Posicionamento das imagens de exemplo */
.profile-1 { top: 50px; right: 100px; animation-delay: 0s; }
.profile-2 { top: 150px; right: 200px; animation-delay: 1s; }
.profile-3 { top: 250px; right: 50px; animation-delay: 2s; }

.decorative-element { position: absolute; border-radius: 50%; opacity: 0.1; }
.element-1 { width: 100px; height: 100px; background: #8ecae6; top: 80px; right: 50px; }
.element-2 { width: 60px; height: 60px; background: #ffb703; top: 200px; right: 320px; }

@keyframes float {
  0%, 100% { transform: translateY(0px); }
  50% { transform: translateY(-20px); }
}

/* Responsividade para telas menores */
@media (max-width: 768px) {
  .hero-content {
    grid-template-columns: 1fr;
    text-align: center;
  }
  .hero-visuals {
    display: none; /* Esconde as imagens flutuantes em telas pequenas para uma melhor experiência */
  }
  .hero-buttons {
    justify-content: center;
  }
}
</style>