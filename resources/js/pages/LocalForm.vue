<template>
  <div class="local-form-page">
    <div class="form-header">
      <router-link to="/vue/locais" class="back-link">
        <i class="fas fa-arrow-left"></i> Voltar
      </router-link>
      <h1>{{ isEdit ? 'Editar Local' : 'Novo Local' }}</h1>
    </div>

    <div v-if="loading" class="loading-container">
      <div class="spinner"></div>
    </div>

    <div v-if="error" class="alert alert-danger">
      {{ error }}
      <button @click="error = null" class="btn-close">&times;</button>
    </div>

    <form v-if="!loading" @submit.prevent="handleSubmit" class="form-container">
      <div class="form-section">
        <h2>Informações do Local</h2>
        <div class="form-grid">
          <div class="form-group">
            <label>Nome *</label>
            <input v-model="form.nome" type="text" required class="form-control" 
                   placeholder="Ex: Sala 101, Almoxarifado, etc" />
          </div>

          <div class="form-group">
            <label>Tipo de Local</label>
            <select v-model="form.tipo_local" class="form-control">
              <option value="">Selecione</option>
              <option value="laboratorio">Laboratório</option>
              <option value="almoxarifado">Almoxarifado</option>
              <option value="sala">Sala</option>
              <option value="setor">Setor</option>
              <option value="externo">Externo</option>
              <option value="outro">Outro</option>
            </select>
          </div>

          <div class="form-group">
            <label>Código/Identificador</label>
            <input v-model="form.codigo" type="text" class="form-control" 
                   placeholder="Ex: LAB-01, ALM-02" />
          </div>

          <div class="form-group">
            <label>Capacidade</label>
            <input v-model.number="form.capacidade" type="number" class="form-control" 
                   placeholder="Número de equipamentos" />
          </div>

          <div class="form-group full-width">
            <label>Descrição</label>
            <textarea v-model="form.descricao" rows="3" class="form-control"></textarea>
          </div>
        </div>
      </div>

      <div class="form-section">
        <h2>Localização Física</h2>
        <div class="form-grid">
          <div class="form-group">
            <label>Prédio/Edifício</label>
            <input v-model="form.predio" type="text" class="form-control" />
          </div>

          <div class="form-group">
            <label>Andar</label>
            <input v-model="form.andar" type="text" class="form-control" />
          </div>

          <div class="form-group">
            <label>Sala/Número</label>
            <input v-model="form.sala" type="text" class="form-control" />
          </div>

          <div class="form-group">
            <label>Setor/Departamento</label>
            <input v-model="form.setor" type="text" class="form-control" />
          </div>
        </div>
      </div>

      <div class="form-section">
        <h2>Responsável</h2>
        <div class="form-grid">
          <div class="form-group">
            <label>Nome do Responsável</label>
            <input v-model="form.responsavel" type="text" class="form-control" />
          </div>

          <div class="form-group">
            <label>E-mail do Responsável</label>
            <input v-model="form.responsavel_email" type="email" class="form-control" />
          </div>

          <div class="form-group">
            <label>Telefone do Responsável</label>
            <input v-model="form.responsavel_telefone" type="tel" class="form-control" />
          </div>
        </div>
      </div>

      <div class="form-section">
        <h2>Observações</h2>
        <div class="form-group full-width">
          <textarea v-model="form.observacoes" rows="4" class="form-control"></textarea>
        </div>
      </div>

      <div class="form-actions">
        <router-link to="/vue/locais" class="btn btn-secondary">
          Cancelar
        </router-link>
        <button type="submit" class="btn btn-primary" :disabled="loading">
          <i class="fas fa-save"></i>
          {{ isEdit ? 'Salvar' : 'Criar Local' }}
        </button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { useLocaisStore } from '../stores/locais';

const router = useRouter();
const route = useRoute();
const locaisStore = useLocaisStore();

const isEdit = computed(() => !!route.params.id);
const loading = ref(false);
const error = ref(null);

const form = ref({
  nome: '',
  tipo_local: '',
  codigo: '',
  descricao: '',
  predio: '',
  andar: '',
  sala: '',
  setor: '',
  capacidade: null,
  responsavel: '',
  responsavel_email: '',
  responsavel_telefone: '',
  observacoes: ''
});

onMounted(async () => {
  if (isEdit.value) {
    try {
      loading.value = true;
      const local = await locaisStore.fetchLocal(route.params.id);
      Object.keys(form.value).forEach(key => {
        if (local[key] !== undefined) {
          form.value[key] = local[key];
        }
      });
    } catch (err) {
      error.value = err.message || 'Erro ao carregar local';
    } finally {
      loading.value = false;
    }
  }
});

const handleSubmit = async () => {
  try {
    loading.value = true;
    error.value = null;

    if (isEdit.value) {
      await locaisStore.updateLocal(route.params.id, form.value);
    } else {
      await locaisStore.createLocal(form.value);
    }

    router.push('/vue/locais');
  } catch (err) {
    error.value = err.response?.data?.message || 'Erro ao salvar local';
  } finally {
    loading.value = false;
  }
};
</script>

<style scoped>
.local-form-page {
  padding: 24px;
  max-width: 1200px;
  margin: 0 auto;
}

.form-header {
  margin-bottom: 24px;
}

.back-link {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  color: #6b7280;
  text-decoration: none;
  margin-bottom: 12px;
  font-size: 14px;
}

.back-link:hover {
  color: #3b82f6;
}

h1 {
  font-size: 28px;
  font-weight: 700;
  color: #1f2937;
  margin: 0;
}

.form-container {
  display: flex;
  flex-direction: column;
  gap: 24px;
}

.form-section {
  background: white;
  padding: 24px;
  border-radius: 8px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.form-section h2 {
  font-size: 18px;
  font-weight: 600;
  color: #1f2937;
  margin: 0 0 20px 0;
  padding-bottom: 12px;
  border-bottom: 2px solid #e5e7eb;
}

.form-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 20px;
}

.form-group {
  display: flex;
  flex-direction: column;
}

.form-group.full-width {
  grid-column: 1 / -1;
}

.form-group label {
  font-size: 14px;
  font-weight: 500;
  color: #374151;
  margin-bottom: 6px;
}

.form-control {
  padding: 10px 12px;
  border: 1px solid #d1d5db;
  border-radius: 6px;
  font-size: 14px;
  transition: border-color 0.2s;
}

.form-control:focus {
  outline: none;
  border-color: #3b82f6;
  box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

textarea.form-control {
  resize: vertical;
  font-family: inherit;
}

.form-actions {
  display: flex;
  gap: 12px;
  justify-content: flex-end;
  padding: 20px;
  background: white;
  border-radius: 8px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.btn {
  padding: 10px 20px;
  border: none;
  border-radius: 6px;
  font-size: 14px;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.2s;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  text-decoration: none;
}

.btn-primary {
  background: #3b82f6;
  color: white;
}

.btn-primary:hover:not(:disabled) {
  background: #2563eb;
}

.btn-secondary {
  background: #e5e7eb;
  color: #374151;
}

.btn-secondary:hover {
  background: #d1d5db;
}

.btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.loading-container {
  text-align: center;
  padding: 60px 20px;
  background: white;
  border-radius: 8px;
}

.spinner {
  width: 48px;
  height: 48px;
  margin: 0 auto 16px;
  border: 4px solid #e5e7eb;
  border-top-color: #3b82f6;
  border-radius: 50%;
  animation: spin 0.8s linear infinite;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

.alert {
  padding: 12px 16px;
  border-radius: 6px;
  margin-bottom: 20px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.alert-danger {
  background: #fee2e2;
  color: #991b1b;
  border: 1px solid #fecaca;
}

.btn-close {
  background: transparent;
  border: none;
  font-size: 20px;
  cursor: pointer;
  color: inherit;
  padding: 0;
  width: 24px;
  height: 24px;
}
</style>
