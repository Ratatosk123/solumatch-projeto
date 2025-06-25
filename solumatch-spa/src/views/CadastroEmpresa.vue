<template>
  <div class="form-wrapper">
    <div class="form-container">
      <img src="/logo.png" alt="SoluMatch Logo" class="logo">
      <h1>Cadastro de Empresa</h1>

      <div v-if="errors" class="alert-danger">
        <strong>Ops! Algo deu errado:</strong>
        <ul>
          <li v-for="(error, key) in errors" :key="key">{{ error[0] }}</li>
        </ul>
      </div>

      <form @submit.prevent="handleRegister">
        <input type="text" placeholder="Nome da Empresa:" v-model="formData.name" required>
        <input type="email" placeholder="Email de Contato:" v-model="formData.email" required>
        
        <input type="tel" placeholder="Telefone:" v-model="formData.telefone" v-imask="masks.telefone">
        
        <input type="text" placeholder="CEP:" v-model="formData.cep" v-imask="masks.cep" @blur="buscarCep">
        
        <input type="text" placeholder="Endereço da Sede:" v-model="formData.endereco">
        
        <input type="text" placeholder="CNPJ:" v-model="formData.cnpj" v-imask="masks.cnpj" required>
        
        <input type="password" placeholder="Crie uma senha:" v-model="formData.password" required>
        <input type="password" placeholder="Confirme a senha:" v-model="formData.password_confirmation" required>
        
        <button type="submit" class="submit-btn" :disabled="loading">
          {{ loading ? 'Cadastrando...' : 'Cadastrar Empresa' }}
        </button>
      </form>

      <div class="links-footer">
        <p>Já tem uma conta? <router-link to="/login">Faça login</router-link></p>
        <p>Ou <router-link to="/cadastro-usuario">cadastre-se como usuário</router-link></p>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import '@/assets/css/form.css'
import { reactive, ref } from 'vue';
import { useRouter } from 'vue-router';
import apiClient from '@/api';

// Definição das máscaras para a diretiva v-imask
const masks = {
  cep: { mask: '00000-000' },
  cnpj: { mask: '00.000.000/0000-00' },
  telefone: { mask: '(00) 00000-0000' }
};

const router = useRouter();
const loading = ref(false);
const errors = ref<Record<string, string[]> | null>(null);

// Usando 'any' temporariamente para o telefone, pois a máscara pode retornar tipos diferentes
const formData = reactive({
  name: '',
  email: '',
  telefone: '' as any,
  endereco: '',
  cep: '' as any,
  cnpj: '' as any,
  password: '',
  password_confirmation: '',
  tipo_usuario: 'empresa' as const
});

// Função para buscar o endereço a partir do CEP
const buscarCep = async () => {
  if (!formData.cep || typeof formData.cep.replace !== 'function') return;

  const cepLimpo = formData.cep.replace(/\D/g, ''); // Remove caracteres não numéricos
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
    alert("Não foi possível buscar o endereço.");
  }
};

// Função para lidar com o envio do formulário de registro
const handleRegister = async () => {
  loading.value = true;
  errors.value = null;

  // Prepara os dados para enviar, garantindo que os valores mascarados sejam apenas números
  const dadosParaEnviar = {
    ...formData,
    cep: String(formData.cep).replace(/\D/g, ''),
    cnpj: String(formData.cnpj).replace(/\D/g, ''),
    telefone: String(formData.telefone).replace(/\D/g, ''),
  };

  try {
    await apiClient.post('/api/register', dadosParaEnviar);
    alert('Empresa cadastrada com sucesso! Você será redirecionado para o login.');
    router.push('/login');
  } catch (error: any) {
    if (error.response && error.response.status === 422) {
      errors.value = error.response.data.errors;
    } else {
      alert('Ocorreu um erro inesperado.');
      console.error(error);
    }
  } finally {
    loading.value = false;
  }
};
</script>