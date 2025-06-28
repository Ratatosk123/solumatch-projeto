<template>
  <div class="form-wrapper">
    <div class="form-container">
      <img src="/logo.png" alt="SoluMatch Logo" class="logo">
      <h1>Recuperar Senha</h1>

      <div v-if="successMessage" class="alert-success">
        <p>{{ successMessage }}</p>
        <p><strong>Copie e cole este link no seu navegador:</strong></p>
        <input type="text" :value="resetLink" readonly @click="copiarLink" class="link-input">
      </div>

      <form @submit.prevent="handleForgotPassword" v-else>
        <label for="email">E-mail Cadastrado:</label>
        <input id="email" type="email" placeholder="Digite seu e-mail" v-model="email" required>
        <button type="submit" class="submit-btn" :disabled="loading">
          {{ loading ? 'Enviando...' : 'Enviar Link de Recuperação' }}
        </button>
      </form>

      <div class="links-footer">
        <p><router-link to="/login">Voltar para o Login</router-link></p>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import '@/assets/css/form.css'
import { ref } from 'vue';
import apiClient from '@/api';

const email = ref('');
const loading = ref(false);
const successMessage = ref('');
const resetLink = ref('');

const handleForgotPassword = async () => {
  loading.value = true;
  successMessage.value = '';
  resetLink.value = '';

  try {
    const { data } = await apiClient.post('/forgot-password', { email: email.value });

    successMessage.value = data.message;
    resetLink.value = data.reset_link ?? '';   // pode vir undefined em produção
  } catch (err: any) {
    alert('E-mail não encontrado em nosso sistema.');
    console.error(err);
  } finally {
    loading.value = false;
  }
};

const copiarLink = () => {
  if (resetLink.value) {
    navigator.clipboard.writeText(resetLink.value);
    alert('Link copiado para a área de transferência!');
  }
};
</script>