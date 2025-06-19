import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '@/stores/auth' // Este import agora deve funcionar

// Usando o atalho '@' para todos os imports. Fica mais limpo e padronizado.
import HomeView from '@/views/HomeView.vue'
import LoginView from '@/views/Login.vue'
import TrabalhosView from '@/views/Trabalhos.vue'
import CadastroUsuarioView from '@/views/CadastroUsuario.vue'
import CadastroEmpresaView from '@/views/CadastroEmpresa.vue'
import EsqueciSenhaView from '@/views/EsqueciSenha.vue'
import ResetarSenhaView from '@/views/ResetarSenha.vue'

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
      path: '/cadastro-usuario',
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
      meta: { requiresAuth: true } // Marcando a rota como protegida
    },
    {
    path: '/esqueci-senha',
    name: 'esqueciSenha',
    component: EsqueciSenhaView,
    },
    {
    path: '/resetar-senha',
    name: 'resetarSenha',
    component: ResetarSenhaView,
    },
  ]
})

// Guarda de Navegação: Roda antes de cada mudança de rota
router.beforeEach((to, _from, next) => { // Usando '_from' para evitar o aviso de variável não utilizada
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