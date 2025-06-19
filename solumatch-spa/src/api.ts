import axios from 'axios';

const apiClient = axios.create({
  baseURL: 'http://localhost:8000',
  withCredentials: true,
  headers: {
    'Accept': 'application/json',
    'Content-Type': 'application/json'
  }
});

// AQUI ESTÁ A LINHA CRÍTICA:
// Ela torna a variável 'apiClient' disponível para outros arquivos
// como a exportação PADRÃO deste módulo.
export default apiClient;