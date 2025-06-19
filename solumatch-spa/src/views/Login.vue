<template>
  <section class="formulario-container">
    <div class="formulario">
      <img src="/logo.png" class="logo-form" alt="Logo SoluMatch"> <h1>Entrar no SoluMatch</h1>

      <div v-if="error" class="alert-danger">{{ error }}</div>

      <form @submit.prevent="handleLogin">
        <input 
          type="email" 
          placeholder="E-mail" 
          v-model="credentials.email" 
          required
        >
        <input 
          type="password" 
          placeholder="Senha" 
          v-model="credentials.password" 
          required
        >
        
        <button type="submit" class="btn_cadastrar" :disabled="loading">
          {{ loading ? 'Entrando...' : 'Entrar' }}
        </button>
      </form>
      
      <p>Não tem uma conta? <router-link to="/cadastro-usuario">Cadastre-se</router-link></p>
      <p><router-link to="/esqueci-senha">Esqueceu a senha?</router-link></p>
    </div>
  </section>
</template>

<script setup lang="ts">
import { reactive, ref } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '@/stores/auth'; // Importamos nosso store de autenticação

// Instanciamos o roteador e o store para poder usá-los
const router = useRouter();
const authStore = useAuthStore();

// 'reactive' é ótimo para agrupar dados de um formulário
const credentials = reactive({
  email: '',
  password: ''
});

// 'ref' é usado para valores primitivos (boolean, string, number)
const loading = ref(false);
const error = ref('');

// Função assíncrona que será chamada ao enviar o formulário
const handleLogin = async () => {
  loading.value = true;
  error.value = ''; // Limpa erros anteriores

  try {
    // Chama a ação 'login' do nosso store, que por sua vez chama a API Laravel
    const success = await authStore.login(credentials);

    if (success) {
      // Se o login for bem-sucedido, redireciona para a página de trabalhos
      router.push('/trabalhos');
    } else {
      // Se a ação 'login' do store retornar false, definimos uma mensagem de erro
      error.value = 'E-mail ou senha incorretos. Tente novamente.';
    }
  } catch (err) {
    // Tratamento de erros inesperados
    error.value = 'Ocorreu um erro ao tentar fazer login. Por favor, tente mais tarde.';
    console.error(err);
  } finally {
    // Este bloco sempre executa, seja em caso de sucesso ou falha
    loading.value = false;
  }
};
</script>

<style scoped>
/* Copie os estilos relevantes do seu 'login.css' aqui para manter a aparência */
.formulario-container {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    background-image: linear-gradient(to bottom, #f2f6fd, #2474cf, #013b5f);
}
.formulario {
    background-color: rgb(22, 22, 22);
    padding: 3rem;
    border-radius: 1rem;
    color: white;
    text-align: center;
    width: 100%;
    max-width: 400px;
}
.alert-danger {
    color: #ff4d4d;
    background-color: #ffeded;
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 15px;
}
/* ... etc ... */
</style>