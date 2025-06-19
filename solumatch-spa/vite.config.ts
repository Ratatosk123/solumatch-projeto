import { fileURLToPath, URL } from 'node:url'

import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

export default defineConfig({
  plugins: [
    vue(),
  ],
  resolve: {
    alias: {
      // --- PARTE MAIS IMPORTANTE ---
      // Esta configuração faz a mesma coisa que o tsconfig, mas para o Vite.
      '@': fileURLToPath(new URL('./src', import.meta.url))
    }
  }
})