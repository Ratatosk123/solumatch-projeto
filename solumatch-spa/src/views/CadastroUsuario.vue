<template>
  <section class="formulario-container">
    <div class="formulario">
      <img src="/logo.png" alt="Logo SoluMatch">
      <h1>Cadastro de Profissional</h1>

      <div v-if="errors" class="alert-danger">
        <strong>Ops! Algo deu errado:</strong>
        <ul>
          <li v-for="(error, key) in errors" :key="key">{{ error[0] }}</li>
        </ul>
      </div>

      <form @submit.prevent="handleRegister">
        <input type="text" placeholder="Nome Completo:" v-model="formData.nome" required>
        <input type="email" placeholder="Seu melhor email:" v-model="formData.email" required>
        <input type="text" placeholder="CPF:" v-model="formData.cpf" required>
        <input type="password" placeholder="Crie uma senha:" v-model="formData.password" required>
        <input type="password" placeholder="Confirme sua senha:" v-model="formData.password_confirmation" required>
        
        <button type="submit" :disabled="loading">
          {{ loading ? 'Cadastrando...' : 'Criar Minha Conta' }}
        </button>
      </form>
      <p>Já tem uma conta? <router-link to="/login">Faça login</router-link></p>
    </div>
  </section>
</template>

<script setup lang="ts">
import { reactive, ref } from 'vue';
import { useRouter } from 'vue-router';
import apiClient from '@/api';

interface RegisterFormData {
  nome: string;
  email: string;
  cpf: string;
  password: string;
  password_confirmation: string;
  tipo_usuario: 'profissional';
}

const router = useRouter();
const loading = ref(false);
const errors = ref<Record<string, string[]> | null>(null);

const formData = reactive<RegisterFormData>({
  nome: '',
  email: '',
  cpf: '',
  password: '',
  password_confirmation: '',
  tipo_usuario: 'profissional'
});

const handleRegister = async () => {
  loading.value = true;
  errors.value = null;

  try {
    await apiClient.post('/api/register', formData);
    alert('Cadastro realizado com sucesso! Você será redirecionado para a página de login.');
    router.push('/login');
  } catch (error: any) {
    if (error.response && error.response.status === 422) {
      errors.value = error.response.data.errors;
    } else {
      alert('Ocorreu um erro inesperado. Verifique o console para mais detalhes.');
      console.error(error);
    }
  } finally {
    loading.value = false;
  }
};
</script>

<style scoped>
/* Adapte seus estilos de 'cadastro.css' aqui */
.formulario-container { 
display: flex; 
align-items: center; 
justify-content: center; 
min-height: 100vh; 
}

.formulario { 
background-color: rgb(22, 22, 22); 
padding: 3rem; 
border-radius: 1rem; 
color: white; 
text-align: center; 
}

.alert-danger { 
color: #ff4d4d; 
background-color: #ffeded; 
padding: 10px; 
border-radius: 5px; 
margin-bottom: 15px; 
text-align: left; 
}
.alert-danger ul { 
padding-left: 20px; 
}
</style>