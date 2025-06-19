import { defineStore } from 'pinia';
import { ref, computed } from 'vue';
import apiClient from '@/api';

// Interface para garantir que nosso objeto 'user' tenha sempre a mesma forma
interface User {
  id: number;
  nome: string;
  email: string;
  tipo_usuario: 'profissional' | 'empresa';
}

// Criando o store de autenticação
export const useAuthStore = defineStore('auth', () => {
  // Estado: as variáveis reativas da nossa store
  const user = ref<User | null>(null);
  const token = ref<string | null>(localStorage.getItem('token'));

  // Getter: uma propriedade computada para verificar se o usuário está logado
  const isAuthenticated = computed(() => !!token.value && !!user.value);

  // Ação para fazer login
  async function login(credentials: object) {
    try {
      const response = await apiClient.post('/api/login', credentials);
      token.value = response.data.token;
      user.value = response.data.user;

      localStorage.setItem('token', token.value ?? '');
      localStorage.setItem('user', JSON.stringify(user.value));

      apiClient.defaults.headers.common['Authorization'] = `Bearer ${token.value}`;
      return true;
    } catch (error) {
      console.error("Erro no login:", error);
      return false;
    }
  }

  // Ação para fazer logout
  function logout() {
    token.value = null;
    user.value = null;
    localStorage.removeItem('token');
    localStorage.removeItem('user');
    delete apiClient.defaults.headers.common['Authorization'];
  }

  // Função auxiliar para carregar os dados do usuário do localStorage ao iniciar
  function loadUserFromStorage() {
    const storedUser = localStorage.getItem('user');
    if (storedUser) {
        user.value = JSON.parse(storedUser);
    }
    if (token.value) {
        apiClient.defaults.headers.common['Authorization'] = `Bearer ${token.value}`;
    }
  }

  loadUserFromStorage();

  return { user, token, isAuthenticated, login, logout };
});