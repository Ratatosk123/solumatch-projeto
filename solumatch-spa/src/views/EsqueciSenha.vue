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
import '@/assets/css/form.css'; // Reutilizando nosso CSS de formulários
import { ref } from 'vue';
import apiClient from '@/api';

const email = ref('');
const loading = ref(false);
const successMessage = ref('');
const resetLink = ref('');

const handleForgotPassword = async () => {
  loading.value = true;
  successMessage.value = '';
  try {
    const response = await apiClient.post('/api/forgot-password', { email: email.value });
    successMessage.value = response.data.message;
    resetLink.value = response.data.reset_link;
  } catch (error) {
    alert("E-mail não encontrado em nosso sistema.");
    console.error(error);
  } finally {
    loading.value = false;
  }
};

const copiarLink = (event: Event) => {
    const input = event.target as HTMLInputElement;
    input.select();
    document.execCommand('copy');
    alert("Link copiado para a área de transferência!");
}
</script>

<style scoped>
/* Estilos adicionais específicos para esta página */
label {
  display: block;
  text-align: left;
  margin-bottom: 0.5rem;
  font-weight: 500;
  color: #ccc;
}
.alert-success {
  background-color: rgba(40, 167, 69, 0.1);
  border: 1px solid #28a745;
  padding: 1rem;
  border-radius: 8px;
  color: #d4edda;
  text-align: left;
}
.link-input {
    width: 100%;
    margin-top: 1rem;
    cursor: pointer;
}
</style>