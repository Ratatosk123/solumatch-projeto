<template>
  <div>
    <div class="workana-jobs-container">
      <aside class="jobs-filter-sidebar">
        <div class="filter-section">
          <h3 class="filter-title">Categorias</h3>
          <ul class="filter-list">
            <li
              v-for="cat in categorias"
              :key="cat"
              :class="{ 'active': cat === categoriaSelecionada }"
              @click="filtrarPorCategoria(cat)"
            >
              {{ cat }}
            </li>
          </ul>
        </div>
      </aside>

      <main class="jobs-main-content">
        <h1>Encontre seu próximo projeto</h1>
        <h2 v-if="categoriaSelecionada !== 'Todos'">Vagas em {{ categoriaSelecionada }}</h2>
        
        <div v-if="loading" class="loading-message">Carregando vagas...</div>
        <div v-if="error" class="error-message">{{ error }}</div>
        
        <div v-if="!loading && !error" class="jobs-list">
          <VagaCard v-for="vaga in vagas" :key="vaga.id" :vaga="vaga" />
          <p v-if="vagas.length === 0">Nenhuma vaga encontrada para esta categoria.</p>
        </div>
      </main>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import apiClient from '../api';
import VagaCard from '@/components/VagaCard.vue'; // Lembre-se de criar este componente

// Definindo a "forma" dos nossos dados com TypeScript
interface Empresa {
  id: number;
  nome: string;
}
interface Vaga {
  id: number;
  titulo: string;
  descricao: string;
  salario: string | null;
  tipo_orcamento: 'fixo' | 'por_hora';
  requisitos: string | null;
  data_postagem: string;
  propostas_count: number;
  empresa: Empresa;
}

// Estado reativo do componente
const vagas = ref<Vaga[]>([]);
const loading = ref(true);
const error = ref<string | null>(null);
const categoriaSelecionada = ref('Todos');
const categorias = ['Todos', 'Programação', 'Design', 'Marketing', 'Redação'];

// Função para buscar os dados da API Laravel
const fetchVagas = async (categoria = 'Todos') => {
  loading.value = true;
  error.value = null;
  categoriaSelecionada.value = categoria;

  try {
    // Faz a requisição autenticada para a API Laravel
    const response = await apiClient.get('/api/vagas', {
      params: { category: categoria }
    });
    // A resposta paginada do Laravel tem os dados dentro de uma chave 'data'
    vagas.value = response.data.data;
  } catch (err: any) {
    if (err.response && err.response.status === 401) {
      error.value = 'Sua sessão expirou. Por favor, faça login novamente.';
      // Aqui você poderia redirecionar para o login
    } else {
      error.value = 'Não foi possível carregar as vagas. Tente novamente mais tarde.';
    }
    console.error('Falha ao buscar vagas:', err);
  } finally {
    loading.value = false;
  }
};

const filtrarPorCategoria = (categoria: string) => {
  fetchVagas(categoria);
};

// Quando o componente for montado, busca as vagas
onMounted(fetchVagas);
</script>

<style scoped>
/* Adapte os estilos do seu trabalhos.css aqui */
.workana-jobs-container { display: flex; max-width: 1200px; margin: 20px auto; gap: 20px; }
.jobs-main-content h1 { margin-bottom: 2rem; }
.filter-item { list-style: none; padding: 8px 0; cursor: pointer; }
.filter-item.active { color: rgb(0, 89, 255); font-weight: bold; }
.loading-message, .error-message { text-align: center; padding: 40px; font-size: 1.2rem; color: #666; }
.error-message { color: red; }
</style>