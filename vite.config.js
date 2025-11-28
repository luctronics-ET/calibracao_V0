import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

export default defineConfig({
  plugins: [vue()],
  root: 'resources',
  base: '/',
  build: {
    outDir: '../public/build',
    emptyOutDir: true
  },
  server: {
    strictPort: true,
    port: 5173
  }
})
