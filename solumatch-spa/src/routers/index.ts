import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

// Importando todos os componentes de View
import HomeView from '@/views/HomeView.vue'
import LoginView from '@/views/LoginView.vue'
import TrabalhosView from '@/views/TrabalhosView.vue'
import CadastroUsuarioView from '@/views/CadastroUsuario.vue' // <-- GARANTA QUE ESTA LINHA EXISTE
import CadastroEmpresaView from '@/views/CadastroEmpresa.vue'
import EsqueciSenhaView from '@/views/EsqueciSenha.vue'
import ResetarSenhaview from '@/views/ResetarSenha.vue'

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
    // ROTA PARA O CADASTRO DE USUÁRIO
    {
      path: '/cadastro-usuario', // <-- GARANTA QUE ESTE BLOCO EXISTA
      name: 'cadastroUsuario',
      component: CadastroUsuarioView
    },
    {
      path: '/cadastro-empresa',
      name: 'cadastroEmpresa',
      component: CadastroEmpresaView
    },
    {
      path: '/trabalhos',
      name: 'trabalhos',
      component: TrabalhosView,
      meta: { requiresAuth: true }
    },
    {
      path: '/esqueci-senha',
      name:  'EsqueciSenha',
      component: EsqueciSenhaView,
    },
    {
      path: '/resetar-senha',
      name: 'ResetarSenha', 
      component: ResetarSenhaview,
    }
  ]
})

// Guarda de navegação (código continua o mesmo)
router.beforeEach((to, _from, next) => {
  const authStore = useAuthStore();
  if (to.meta.requiresAuth && !authStore.isAuthenticated) {
    next({ name: 'login' });
  } else {
    next();
  }
});

export default router