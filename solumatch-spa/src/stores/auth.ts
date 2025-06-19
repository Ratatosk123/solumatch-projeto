import { defineStore } from 'pinia';
import { ref, computed } from 'vue';
import apiClient from '@/api';

interface User {
  id: number;
  nome: string;
  email: string;
  tipo_usuario: 'profissional' | 'empresa';
}

export const useAuthStore = defineStore('auth', () => {
  const user = ref<User | null>(null);
  const token = ref<string | null>(localStorage.getItem('token'));
  const isAuthenticated = computed(() => !!token.value && !!user.value);

  function loadUserFromStorage() {
    const storedUser = localStorage.getItem('user');
    if (storedUser) user.value = JSON.parse(storedUser);
    if (token.value) apiClient.defaults.headers.common['Authorization'] = `Bearer ${token.value}`;
  }

  async function login(credentials: object) {
    try {
      const response = await apiClient.post('/api/login', credentials);
      token.value = response.data.token;
      user.value = response.data.user;

      if (token.value) { // Correção para o erro de tipo
        localStorage.setItem('token', token.value);
      }
      localStorage.setItem('user', JSON.stringify(user.value));
      apiClient.defaults.headers.common['Authorization'] = `Bearer ${token.value}`;
      return true;
    } catch (error) {
      console.error("Erro no login:", error);
      return false;
    }
  }

  loadUserFromStorage(); // Carrega o usuário ao iniciar

  return { user, token, isAuthenticated, login };
});