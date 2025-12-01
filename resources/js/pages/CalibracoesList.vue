<template>
  <div class="calibracoes-list-page">
    <div class="page-header">
      <h1>Calibrações</h1>
      <router-link to="/vue/calibracoes/nova" class="btn btn-primary">
        <i class="fas fa-plus"></i>
        Nova Calibração
      </router-link>
    </div>

    <div class="filters-bar">
      <input 
        v-model="searchQuery" 
        type="text" 
        placeholder="Buscar por equipamento, laboratório..." 
        class="search-input"
      />
      <select v-model="statusFilter" class="filter-select">
        <option value="">Todos os Status</option>
        <option value="pendente">Pendente</option>
        <option value="em_andamento">Em Andamento</option>
        <option value="concluida">Concluída</option>
        <option value="aprovada">Aprovada</option>
        <option value="reprovada">Reprovada</option>
      </select>
    </div>

    <div v-if="loading" class="loading-container">
      <div class="spinner"></div>
    </div>

    <div v-if="error" class="alert alert-danger">
      {{ error }}
    </div>

    <div v-if="!loading && filteredCalibracoes.length === 0" class="empty-state">
      <i class="fas fa-clipboard-check fa-3x"></i>
      <p>Nenhuma calibração encontrada</p>
      <router-link to="/vue/calibracoes/nova" class="btn btn-primary">
        Criar primeira calibração
      </router-link>
    </div>

    <div v-if="!loading && filteredCalibracoes.length > 0" class="calibracoes-grid">
      <div v-for="calibracao in filteredCalibracoes" :key="calibracao.id" class="calibracao-card">
        <div class="card-header">
          <div class="card-title">
            <i class="fas fa-clipboard-check"></i>
            Calibração #{{ calibracao.id }}
          </div>
          <span :class="['badge', getStatusClass(calibracao.status)]">
            {{ getStatusLabel(calibracao.status) }}
          </span>
        </div>

        <div class="card-body">
          <div class="info-row">
            <span class="label">Equipamento:</span>
            <span class="value">{{ calibracao.equipamento?.tipo || 'N/A' }}</span>
          </div>
          <div class="info-row">
            <span class="label">Laboratório:</span>
            <span class="value">{{ calibracao.laboratorio?.nome || 'N/A' }}</span>
          </div>
          <div class="info-row">
            <span class="label">Data:</span>
            <span class="value">{{ formatDate(calibracao.data_calibracao) }}</span>
          </div>
          <div v-if="calibracao.rbc_codigo_laboratorio" class="info-row">
            <span class="label">RBC:</span>
            <span class="value">
              <i class="fas fa-check-circle" style="color: #10b981;"></i>
              {{ calibracao.rbc_codigo_laboratorio }}
            </span>
          </div>
          <div v-if="calibracao.conformidade_ilac_p14" class="info-row">
            <span class="label">ILAC-P14:</span>
            <span class="value">
              <i class="fas fa-certificate" style="color: #3b82f6;"></i>
              Conforme
            </span>
          </div>
          <div v-if="calibracao.proxima_calibracao_sugerida" class="info-row">
            <span class="label">Próxima:</span>
            <span class="value">{{ formatDate(calibracao.proxima_calibracao_sugerida) }}</span>
          </div>
        </div>

        <div class="card-actions">
          <router-link :to="`/vue/calibracoes/${calibracao.id}`" class="btn btn-sm btn-info">
            <i class="fas fa-eye"></i> Ver
          </router-link>
          <router-link :to="`/vue/calibracoes/${calibracao.id}/editar`" class="btn btn-sm btn-warning">
            <i class="fas fa-edit"></i> Editar
          </router-link>
          <button @click="handleDelete(calibracao.id)" class="btn btn-sm btn-danger">
            <i class="fas fa-trash"></i> Excluir
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { useCalibracoesStore } from '../stores/calibracoes';

const calibracoesStore = useCalibracoesStore();

const loading = ref(false);
const error = ref(null);
const searchQuery = ref('');
const statusFilter = ref('');

const calibracoes = computed(() => calibracoesStore.calibracoes);

const filteredCalibracoes = computed(() => {
  let result = calibracoes.value;

  if (statusFilter.value) {
    result = result.filter(c => c.status === statusFilter.value);
  }

  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase();
    result = result.filter(c => 
      c.equipamento?.tipo?.toLowerCase().includes(query) ||
      c.laboratorio?.nome?.toLowerCase().includes(query) ||
      c.rbc_codigo_laboratorio?.toLowerCase().includes(query)
    );
  }

  return result;
});

onMounted(async () => {
  try {
    loading.value = true;
    await calibracoesStore.fetchCalibracoes();
  } catch (err) {
    error.value = err.message || 'Erro ao carregar calibrações';
  } finally {
    loading.value = false;
  }
});

const getStatusClass = (status) => {
  const classes = {
    'pendente': 'badge-secondary',
    'em_andamento': 'badge-info',
    'concluida': 'badge-success',
    'aprovada': 'badge-success',
    'reprovada': 'badge-danger'
  };
  return classes[status] || 'badge-secondary';
};

const getStatusLabel = (status) => {
  const labels = {
    'pendente': 'Pendente',
    'em_andamento': 'Em Andamento',
    'concluida': 'Concluída',
    'aprovada': 'Aprovada',
    'reprovada': 'Reprovada'
  };
  return labels[status] || status;
};

const formatDate = (date) => {
  if (!date) return 'N/A';
  return new Date(date).toLocaleDateString('pt-BR');
};

const handleDelete = async (id) => {
  if (!confirm('Tem certeza que deseja excluir esta calibração?')) {
    return;
  }

  try {
    await calibracoesStore.deleteCalibracao(id);
  } catch (err) {
    alert(err.message || 'Erro ao excluir calibração');
  }
};
</script>

<style scoped>
.calibracoes-list-page {
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

.calibracoes-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
  gap: 20px;
}

.calibracao-card {
  background: white;
  border-radius: 8px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
  overflow: hidden;
  transition: transform 0.2s, box-shadow 0.2s;
}

.calibracao-card:hover {
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
  color: #3b82f6;
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

.badge-success {
  background: #d1fae5;
  color: #065f46;
}

.badge-danger {
  background: #fee2e2;
  color: #991b1b;
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
  display: flex;
  align-items: center;
  gap: 6px;
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
