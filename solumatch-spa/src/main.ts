import { createApp } from 'vue'
import { createPinia } from 'pinia'
import { IMaskDirective} from 'vue-imask';
import App from './App.vue'
import router from './routers' // O caminho './router' já é suficiente


const app = createApp(App)
app.use(createPinia())
app.use(router)
app.directive('imask', IMaskDirective); // <-- 2. VERIFIQUE ESTA LINHA
app.mount('#app')