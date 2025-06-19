import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

// Usando o atalho '@' para todos os imports. Fica mais limpo e padronizado.
import HomeView from '@/views/HomeView.vue'
import LoginView from '@/views/Login.vue'
import TrabalhosView from '@/views/Trabalhos.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/login',
      name: 'login',
      component: LoginView
    },
    {
      path: '/trabalhos',
      name: 'trabalhos',
      component: TrabalhosView,
      meta: { requiresAuth: true } // Marcando a rota como protegida
    }
  ]
})

// Guarda de navegação para proteger rotas
router.beforeEach((to, _from, next) => {
  const authStore = useAuthStore();
  
  // Se a rota destino exige autenticação E o usuário não está autenticado...
  if (to.meta.requiresAuth && !authStore.isAuthenticated) {
    // ...redireciona para a página de login.
    next({ name: 'login' });
  } else {
    // Senão, permite a navegação.
    next();
  }
});

export default router