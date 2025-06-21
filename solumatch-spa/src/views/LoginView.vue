<template>
  <div class="form-wrapper">
    <div class="form-container">
      <img src="/logo.png" alt="SoluMatch Logo" class="logo">
      <h1>Entrar no SoluMatch</h1>

      <div v-if="error" class="alert-danger">{{ error }}</div>

      <form @submit.prevent="handleLogin">
        <input 
          type="email" 
          placeholder="Celular ou e-mail" 
          v-model="credentials.email" 
          required
        >
        <input 
          type="password" 
          placeholder="Senha" 
          v-model="credentials.password" 
          required
        >
        
        <button type="submit" class="submit-btn" :disabled="loading">
          {{ loading ? 'Entrando...' : 'Entrar' }}
        </button>
      </form>

      <div class="links-footer">
        <p><router-link to="/esqueci-senha">Esqueceu a senha?</router-link></p>
        <p>
          Não tem uma conta? 
          <router-link to="/cadastro-usuario">Cadastre-se como Profissional</router-link> ou
          <router-link to="/cadastro-empresa">como Empresa</router-link>.
        </p>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
// 1. Importa os estilos compartilhados que já criamos para os formulários
import '@/assets/css/form.css';

import { reactive, ref } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '@/stores/auth';

const router = useRouter();
const authStore = useAuthStore();

const credentials = reactive({
  email: '',
  password: ''
});

const loading = ref(false);
const error = ref('');

const handleLogin = async () => {
  loading.value = true;
  error.value = '';

  const success = await authStore.login(credentials);

  if (success) {
    // Se o login for bem-sucedido, redireciona para a página de trabalhos
    router.push('/trabalhos');
  } else {
    error.value = 'E-mail ou senha incorretos. Tente novamente.';
  }

  loading.value = false;
};
</script>