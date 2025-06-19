import { createApp } from 'vue'
import { createPinia } from 'pinia'
import { IMaskDirective } from 'vue-imask'; 

import App from './App.vue'
import router from './routers/index';// Importa nosso roteador

// Cria a instância principal da aplicação
const app = createApp(App)

// Instala os plugins que vamos usar
app.use(createPinia()) // Ativa o Pinia (para o authStore)
app.use(router)      // Ativa o Vue Router (para as páginas)

app.directive('imask', IMaskDirective)

// Monta a aplicação na div #app do nosso index.html
app.mount('#app')