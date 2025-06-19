<template>
  <div class="job-card">
    <div class="job-header">
      <h3 class="job-title">{{ vaga.titulo }}</h3>
      <span class="job-budget">{{ formatarOrcamento(vaga) }}</span>
    </div>
    <a href="#" class="company-link" v-if="vaga.empresa">{{ vaga.empresa.nome }}</a>
    <p class="job-description">{{ vaga.descricao.substring(0, 150) }}...</p>
  </div>
</template>

<script setup lang="ts">
// Definindo a "forma" dos dados que este componente espera receber
interface Vaga {
  id: number;
  titulo: string;
  descricao: string;
  salario: string | null;
  tipo_orcamento: 'fixo' | 'por_hora';
  empresa: { nome: string };
}
// defineProps é como declaramos as "propriedades" que o componente recebe do pai
defineProps<{
  vaga: Vaga
}>();

// Função para formatar o orçamento
const formatarOrcamento = (vaga: Vaga) => {
  const orcamento = parseFloat(vaga.salario);
  if (!orcamento || orcamento <= 0) return 'A combinar';
  let texto = `R$ ${orcamento.toFixed(2).replace('.', ',')}`;
  if (vaga.tipo_orcamento === 'por_hora') texto += ' por hora';
  return texto;
};
</script>

<style scoped>
  /* Estilos do seu job-card do trabalhos.css vêm aqui */
  .job-card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
</style>