<template>
  <div class="form-wrapper">
    <div class="form-container">
      <img src="/logo.png" alt="SoluMatch Logo" class="logo">
      <h1>Cadastro de Profissional</h1>

      <div v-if="errors" class="alert-danger">
        <strong>Ops! Algo deu errado:</strong>
        <ul>
          <li v-for="(error, key) in errors" :key="key">{{ error[0] }}</li>
        </ul>
      </div>

      <form @submit.prevent="handleRegister">
        <input type="text" placeholder="Nome Completo:" v-model="formData.name" required>
        <input type="email" placeholder="Seu melhor email:" v-model="formData.email" required>
        
        <input type="tel" placeholder="Telefone:" v-model="formData.telefone" v-imask="masks.telefone">
        
        <input type="text" placeholder="CEP:" v-model="formData.cep" v-imask="masks.cep" @blur="buscarCep">
        
        <input type="text" placeholder="Endereço:" v-model="formData.endereco">
        
        <input type="text" placeholder="CPF:" v-model="formData.cpf" v-imask="masks.cpf" required>
        
        <input type="password" placeholder="Crie uma senha:" v-model="formData.password" required>
        <input type="password" placeholder="Confirme a senha:" v-model="formData.password_confirmation" required>
        
        <button type="submit" class="submit-btn" :disabled="loading">
          {{ loading ? 'Criando Conta...' : 'Criar Minha Conta' }}
        </button>
      </form>

      <div class="links-footer">
        <p>Já tem uma conta? <router-link to="/login">Faça login</router-link></p>
        <p>Ou <router-link to="/cadastro-empresa">cadastre-se como empresa</router-link></p>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
// Importa o nosso arquivo de estilos compartilhado
import '@/assets/css/form.css';

import { reactive, ref } from 'vue';
import { useRouter } from 'vue-router';
import apiClient from '@/api';

// Máscaras para a diretiva v-imask
const masks = {
  cpf: { mask: '000.000.000-00' },
  cep: { mask: '00000-000' },
  telefone: { mask: '(00) 00000-0000' }
};

const router = useRouter();
const loading = ref(false);
const errors = ref<Record<string, string[]> | null>(null);

// Dados do formulário
const formData = reactive({
  name: '',
  email: '',
  telefone: '',
  endereco: '',
  cep: '',
  cpf: '',
  password: '',
  password_confirmation: '',
  tipo_usuario: 'profissional' as const
});

// Função para buscar o endereço a partir do CEP
const buscarCep = async () => {
  const cepLimpo = String(formData.cep).replace(/\D/g, '');
  if (cepLimpo.length !== 8) return;
  try {
    const response = await fetch(`https://viacep.com.br/ws/${cepLimpo}/json/`);
    const data = await response.json();
    if (!data.erro) {
      formData.endereco = `${data.logradouro}, ${data.bairro}, ${data.localidade} - ${data.uf}`;
    } else {
      alert("CEP não encontrado.");
      formData.endereco = '';
    }
  } catch (error) {
    console.error("Erro ao buscar CEP:", error);
  }
};

// Função de registro
const handleRegister = async () => {
  loading.value = true;
  errors.value = null;
  const dadosParaEnviar = {
    ...formData,
    cep: String(formData.cep).replace(/\D/g, ''),
    cpf: String(formData.cpf).replace(/\D/g, ''),
    telefone: String(formData.telefone).replace(/\D/g, ''),
  };
  try {
    await apiClient.post('/register', dadosParaEnviar);
    alert('Cadastro realizado com sucesso! Você será redirecionado para o login.');
    router.push('/login');
  } catch (error: any) {
    if (error.response && error.response.status === 422) {
      errors.value = error.response.data.errors;
    } else {
      alert('Ocorreu um erro inesperado.');
    }
  } finally {
    loading.value = false;
  }
};
</script>