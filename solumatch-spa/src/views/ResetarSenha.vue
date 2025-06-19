<template>
  <div class="form-wrapper">
    <div class="form-container">
      <img src="/logo.png" alt="SoluMatch Logo" class="logo">
      <h1>Redefinir Senha</h1>

      <div v-if="message" :class="isError ? 'alert-danger' : 'alert-success'">
        {{ message }}
      </div>
      
      <form @submit.prevent="handleResetPassword" v-if="!success">
        <label for="email">E-mail</label>
        <input id="email" type="email" v-model="formData.email" readonly disabled>
        
        <label for="password">Nova Senha</label>
        <input id="password" type="password" placeholder="Digite a nova senha" v-model="formData.password" required>
        
        <label for="password_confirmation">Confirme a Nova Senha</label>
        <input id="password_confirmation" type="password" placeholder="Confirme a nova senha" v-model="formData.password_confirmation" required>

        <button type="submit" class="submit-btn" :disabled="loading">
          {{ loading ? 'Redefinindo...' : 'Redefinir Senha' }}
        </button>
      </form>

      <div class="links-footer" v-if="success">
        <p><router-link to="/login">Ir para o Login</router-link></p>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import '@/assets/css/form.css'; // Reutilizando nosso CSS de formulários
import { onMounted, reactive, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import apiClient from '@/api';

const route = useRoute(); // Hook para ler os parâmetros da URL
const router = useRouter(); // Hook para redirecionar o usuário

const loading = ref(false);
const message = ref('');
const isError = ref(false);
const success = ref(false);

const formData = reactive({
  token: '',
  email: '',
  password: '',
  password_confirmation: ''
});

// onMounted é executado assim que o componente é carregado na tela
onMounted(() => {
  // Pegamos o token e o email da URL (ex: /resetar-senha?token=...&email=...)
  const tokenFromUrl = route.query.token;
  const emailFromUrl = route.query.email;

  if (typeof tokenFromUrl === 'string' && typeof emailFromUrl === 'string') {
    formData.token = tokenFromUrl;
    formData.email = emailFromUrl;
  } else {
    // Se não houver token/email na URL, mostra um erro e esconde o formulário
    message.value = 'Link de redefinição de senha inválido ou incompleto.';
    isError.value = true;
    success.value = true; // Usamos 'success' para esconder o formulário
  }
});

const handleResetPassword = async () => {
  loading.value = true;
  message.value = '';
  isError.value = false;

  if (formData.password !== formData.password_confirmation) {
      message.value = "As senhas não coincidem.";
      isError.value = true;
      loading.value = false;
      return;
  }

  try {
    const response = await apiClient.post('/api/reset-password', formData);
    message.value = response.data.message;
    success.value = true; // Marca como sucesso para esconder o formulário e mostrar o link de login
    
    // Redireciona para o login após 5 segundos
    setTimeout(() => {
        router.push('/login');
    }, 5000);

  } catch (error: any) {
    message.value = error.response?.data?.message || "Ocorreu um erro. Tente novamente.";
    isError.value = true;
  } finally {
    loading.value = false;
  }
};
</script>

<style scoped>
/* Estilos adicionais para os labels e mensagens */
label {
  display: block;
  text-align: left;
  margin-bottom: 0.5rem;
  font-weight: 500;
  color: #ccc;
}
input:disabled {
    background-color: #444;
    color: #888;
}
.alert-success {
  background-color: rgba(40, 167, 69, 0.1);
  border: 1px solid #28a745;
  padding: 1rem;
  border-radius: 8px;
  color: #d4edda;
  text-align: center;
  margin-bottom: 1rem;
}
.alert-danger {
  background-color: rgba(220, 53, 69, 0.1);
  border: 1px solid #dc3545;
  padding: 1rem;
  border-radius: 8px;
  color: #f8d7da;
  text-align: center;
  margin-bottom: 1rem;
}
</style>