import { defineConfig } from "vite";
import vue from "@vitejs/plugin-vue";

export default defineConfig({
  plugins: [vue()],
  root: "resources",
  base: "/",
  build: {
    outDir: "../public/build",
    emptyOutDir: true,
    manifest: true,
    rollupOptions: {
      input: "resources/js/main.js",
    },
  },
  server: {
    strictPort: true,
    port: 5173,
    host: "0.0.0.0", // Permite acesso externo (Docker)
    hmr: {
      host: "localhost",
      port: 5173,
    },
    watch: {
      usePolling: true, // Necessário para containers Docker
    },
  },
});
