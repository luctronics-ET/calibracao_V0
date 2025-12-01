<template>
  <div class="lotes-list-page">
    <div class="page-header">
      <h1>Lotes de Calibração</h1>
      <router-link to="/vue/lotes/novo" class="btn btn-primary">
        <i class="fas fa-plus"></i>
        Novo Lote
      </router-link>
    </div>

    <div class="filters-bar">
      <input 
        v-model="searchQuery" 
        type="text" 
        placeholder="Buscar por descrição..." 
        class="search-input"
      />
      <select v-model="statusFilter" class="filter-select">
        <option value="">Todos os Status</option>
        <option value="preparacao">Preparação</option>
        <option value="enviado">Enviado</option>
        <option value="em_calibracao">Em Calibração</option>
        <option value="retornado">Retornado</option>
        <option value="cancelado">Cancelado</option>
      </select>
    </div>

    <div v-if="loading" class="loading-container">
      <div class="spinner"></div>
    </div>

    <div v-if="error" class="alert alert-danger">
      {{ error }}
    </div>

    <div v-if="!loading && filteredLotes.length === 0" class="empty-state">
      <i class="fas fa-boxes fa-3x"></i>
      <p>Nenhum lote encontrado</p>
      <router-link to="/vue/lotes/novo" class="btn btn-primary">
        Criar primeiro lote
      </router-link>
    </div>

    <div v-if="!loading && filteredLotes.length > 0" class="lotes-grid">
      <div v-for="lote in filteredLotes" :key="lote.id" class="lote-card">
        <div class="card-header">
          <div class="card-title">
            <i class="fas fa-boxes"></i>
            Lote #{{ lote.id }}
          </div>
          <span :class="['badge', getStatusClass(lote.status)]">
            {{ getStatusLabel(lote.status) }}
          </span>
        </div>

        <div class="card-body">
          <div class="info-row">
            <span class="label">Descrição:</span>
            <span class="value">{{ lote.descricao || 'N/A' }}</span>
          </div>
          <div class="info-row">
            <span class="label">Laboratório:</span>
            <span class="value">{{ lote.laboratorio_destino?.nome || 'N/A' }}</span>
          </div>
          <div class="info-row">
            <span class="label">Equipamentos:</span>
            <span class="value">
              <span class="badge-count">{{ lote.equipamentos?.length || 0 }}</span>
            </span>
          </div>
          <div v-if="lote.data_envio" class="info-row">
            <span class="label">Envio:</span>
            <span class="value">{{ formatDate(lote.data_envio) }}</span>
          </div>
          <div v-if="lote.data_retorno_prevista" class="info-row">
            <span class="label">Retorno Previsto:</span>
            <span class="value">{{ formatDate(lote.data_retorno_prevista) }}</span>
          </div>
          <div v-if="lote.responsavel_envio" class="info-row">
            <span class="label">Responsável:</span>
            <span class="value">{{ lote.responsavel_envio }}</span>
          </div>
        </div>

        <div class="card-actions">
          <router-link :to="`/vue/lotes/${lote.id}`" class="btn btn-sm btn-info">
            <i class="fas fa-eye"></i> Ver
          </router-link>
          <router-link :to="`/vue/lotes/${lote.id}/editar`" class="btn btn-sm btn-warning">
            <i class="fas fa-edit"></i> Editar
          </router-link>
          <button @click="handleDelete(lote.id)" class="btn btn-sm btn-danger">
            <i class="fas fa-trash"></i> Excluir
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { useLotesStore } from '../stores/lotes';

const lotesStore = useLotesStore();

const loading = ref(false);
const error = ref(null);
const searchQuery = ref('');
const statusFilter = ref('');

const lotes = computed(() => lotesStore.lotes);

const filteredLotes = computed(() => {
  let result = lotes.value;

  if (statusFilter.value) {
    result = result.filter(l => l.status === statusFilter.value);
  }

  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase();
    result = result.filter(l => 
      l.descricao?.toLowerCase().includes(query) ||
      l.laboratorio_destino?.nome?.toLowerCase().includes(query)
    );
  }

  return result;
});

onMounted(async () => {
  try {
    loading.value = true;
    await lotesStore.fetchLotes();
  } catch (err) {
    error.value = err.message || 'Erro ao carregar lotes';
  } finally {
    loading.value = false;
  }
});

const getStatusClass = (status) => {
  const classes = {
    'preparacao': 'badge-secondary',
    'enviado': 'badge-info',
    'em_calibracao': 'badge-warning',
    'retornado': 'badge-success',
    'cancelado': 'badge-danger'
  };
  return classes[status] || 'badge-secondary';
};

const getStatusLabel = (status) => {
  const labels = {
    'preparacao': 'Preparação',
    'enviado': 'Enviado',
    'em_calibracao': 'Em Calibração',
    'retornado': 'Retornado',
    'cancelado': 'Cancelado'
  };
  return labels[status] || status;
};

const formatDate = (date) => {
  if (!date) return 'N/A';
  return new Date(date).toLocaleDateString('pt-BR');
};

const handleDelete = async (id) => {
  if (!confirm('Tem certeza que deseja excluir este lote?')) {
    return;
  }

  try {
    await lotesStore.deleteLote(id);
  } catch (err) {
    alert(err.message || 'Erro ao excluir lote');
  }
};
</script>

<style scoped>
.lotes-list-page {
  padding: 24px;
  max-width: 1400px;
  margin: 0 auto;
}

.page-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 24px;
}

.page-header h1 {
  font-size: 28px;
  font-weight: 700;
  color: #1f2937;
  margin: 0;
}

.filters-bar {
  display: flex;
  gap: 12px;
  margin-bottom: 24px;
}

.search-input {
  flex: 1;
  padding: 10px 16px;
  border: 1px solid #d1d5db;
  border-radius: 6px;
  font-size: 14px;
}

.search-input:focus {
  outline: none;
  border-color: #3b82f6;
}

.filter-select {
  padding: 10px 16px;
  border: 1px solid #d1d5db;
  border-radius: 6px;
  font-size: 14px;
  min-width: 200px;
}

.lotes-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
  gap: 20px;
}

.lote-card {
  background: white;
  border-radius: 8px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
  overflow: hidden;
  transition: transform 0.2s, box-shadow 0.2s;
}

.lote-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.15);
}

.card-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 16px;
  background: #f9fafb;
  border-bottom: 1px solid #e5e7eb;
}

.card-title {
  font-size: 16px;
  font-weight: 600;
  color: #1f2937;
  display: flex;
  align-items: center;
  gap: 8px;
}

.card-title i {
  color: #8b5cf6;
}

.badge {
  padding: 4px 12px;
  border-radius: 12px;
  font-size: 12px;
  font-weight: 500;
}

.badge-secondary {
  background: #e5e7eb;
  color: #374151;
}

.badge-info {
  background: #dbeafe;
  color: #1e40af;
}

.badge-warning {
  background: #fef3c7;
  color: #92400e;
}

.badge-success {
  background: #d1fae5;
  color: #065f46;
}

.badge-danger {
  background: #fee2e2;
  color: #991b1b;
}

.badge-count {
  background: #e5e7eb;
  color: #374151;
  padding: 2px 10px;
  border-radius: 10px;
  font-size: 13px;
  font-weight: 600;
}

.card-body {
  padding: 16px;
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.info-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-size: 14px;
}

.info-row .label {
  color: #6b7280;
  font-weight: 500;
}

.info-row .value {
  color: #1f2937;
  text-align: right;
}

.card-actions {
  display: flex;
  gap: 8px;
  padding: 12px 16px;
  background: #f9fafb;
  border-top: 1px solid #e5e7eb;
}

.btn {
  padding: 8px 16px;
  border: none;
  border-radius: 6px;
  font-size: 14px;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.2s;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  text-decoration: none;
}

.btn-sm {
  padding: 6px 12px;
  font-size: 13px;
}

.btn-primary {
  background: #3b82f6;
  color: white;
}

.btn-primary:hover {
  background: #2563eb;
}

.btn-info {
  background: #0ea5e9;
  color: white;
}

.btn-info:hover {
  background: #0284c7;
}

.btn-warning {
  background: #f59e0b;
  color: white;
}

.btn-warning:hover {
  background: #d97706;
}

.btn-danger {
  background: #ef4444;
  color: white;
}

.btn-danger:hover {
  background: #dc2626;
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
  margin: 0 auto;
  border: 4px solid #e5e7eb;
  border-top-color: #3b82f6;
  border-radius: 50%;
  animation: spin 0.8s linear infinite;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

.empty-state {
  text-align: center;
  padding: 60px 20px;
  background: white;
  border-radius: 8px;
}

.empty-state i {
  color: #9ca3af;
  margin-bottom: 16px;
}

.empty-state p {
  color: #6b7280;
  font-size: 16px;
  margin-bottom: 20px;
}

.alert {
  padding: 12px 16px;
  border-radius: 6px;
  margin-bottom: 20px;
}

.alert-danger {
  background: #fee2e2;
  color: #991b1b;
  border: 1px solid #fecaca;
}
</style>
