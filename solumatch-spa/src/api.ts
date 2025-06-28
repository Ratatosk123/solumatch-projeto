import axios from 'axios';

const apiClient = axios.create({
  baseURL: '/api',          // relativo → proxy do Vite cuida
  withCredentials: true,    // se usar cookies/Sanctum
  headers: {
    Accept: 'application/json',
    'Content-Type': 'application/json',
  },
});

export default apiClient;
