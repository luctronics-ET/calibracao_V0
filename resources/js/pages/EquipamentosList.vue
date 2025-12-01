<template>
  <div class="equipamentos-list-page">
    <div class="page-header">
      <h1>Equipamentos</h1>
      <router-link to="/vue/equipamentos/novo" class="btn btn-primary">
        <i class="fas fa-plus"></i> Novo Equipamento
      </router-link>
    </div>

    <div class="filters-section">
      <input 
        v-model="search" 
        type="text" 
        placeholder="Buscar por tipo, fabricante, modelo ou código..." 
        class="search-input"
        @input="handleSearch"
      />
    </div>

    <div v-if="store.loading" class="loading-container">
      <div class="spinner"></div>
      <p>Carregando equipamentos...</p>
    </div>

    <div v-else-if="store.error" class="alert alert-danger">
      {{ store.error }}
    </div>

    <div v-else-if="store.equipamentos.length === 0" class="empty-state">
      <i class="fas fa-cogs"></i>
      <h3>Nenhum equipamento cadastrado</h3>
      <p>Comece cadastrando seu primeiro equipamento</p>
      <router-link to="/vue/equipamentos/novo" class="btn btn-primary">
        <i class="fas fa-plus"></i> Novo Equipamento
      </router-link>
    </div>

    <div v-else class="equipamentos-grid">
      <div v-for="equip in store.equipamentos" :key="equip.id" class="equip-card">
        <div class="card-header">
          <h3>{{ equip.tipo }}</h3>
          <span v-if="equip.bloqueado_para_uso" class="badge badge-danger">
            <i class="fas fa-lock"></i> Bloqueado
          </span>
          <span v-else-if="equip.criticidade_equipamento" 
                class="badge" 
                :class="`badge-${getCriticidadeClass(equip.criticidade_equipamento)}`">
            {{ equip.criticidade_equipamento }}
          </span>
        </div>

        <div class="card-body">
          <div class="info-row">
            <span class="label">Categoria:</span>
            <span class="value">{{ equip.categoria_metrologica || '-' }}</span>
          </div>
          <div class="info-row">
            <span class="label">Fabricante:</span>
            <span class="value">{{ equip.fabricante || '-' }}</span>
          </div>
          <div class="info-row">
            <span class="label">Modelo:</span>
            <span class="value">{{ equip.modelo || '-' }}</span>
          </div>
          <div class="info-row">
            <span class="label">Código:</span>
            <span class="value">{{ equip.codigo_interno }}</span>
          </div>
          <div v-if="equip.proxima_calibracao_prevista" class="info-row">
            <span class="label">Próxima Calibração:</span>
            <span class="value">{{ formatDate(equip.proxima_calibracao_prevista) }}</span>
          </div>
        </div>

        <div class="card-actions">
          <router-link :to="`/vue/equipamentos/${equip.id}`" class="btn btn-sm btn-secondary">
            <i class="fas fa-eye"></i> Ver
          </router-link>
          <router-link :to="`/vue/equipamentos/${equip.id}/editar`" class="btn btn-sm btn-primary">
            <i class="fas fa-edit"></i> Editar
          </router-link>
          <button @click="handleDelete(equip.id)" class="btn btn-sm btn-danger">
            <i class="fas fa-trash"></i> Excluir
          </button>
        </div>
      </div>
    </div>

    <div v-if="store.pagination.last_page > 1" class="pagination">
      <button 
        @click="changePage(store.pagination.current_page - 1)" 
        :disabled="store.pagination.current_page === 1"
        class="btn btn-sm btn-secondary">
        Anterior
      </button>
      <span class="page-info">
        Página {{ store.pagination.current_page }} de {{ store.pagination.last_page }}
      </span>
      <button 
        @click="changePage(store.pagination.current_page + 1)" 
        :disabled="store.pagination.current_page === store.pagination.last_page"
        class="btn btn-sm btn-secondary">
        Próxima
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useEquipamentosStore } from '../stores/equipamentos';

const store = useEquipamentosStore();
const search = ref('');

onMounted(() => {
  store.fetchEquipamentos();
});

const handleSearch = () => {
  store.fetchEquipamentos({ search: search.value });
};

const changePage = (page) => {
  store.fetchEquipamentos({ page, search: search.value });
};

const handleDelete = async (id) => {
  if (confirm('Tem certeza que deseja excluir este equipamento?')) {
    try {
      await store.deleteEquipamento(id);
    } catch (error) {
      alert('Erro ao excluir equipamento: ' + (error.message || 'Erro desconhecido'));
    }
  }
};

const formatDate = (date) => {
  if (!date) return '-';
  return new Date(date).toLocaleDateString('pt-BR');
};

const getCriticidadeClass = (criticidade) => {
  const map = {
    'critica': 'danger',
    'alta': 'warning',
    'media': 'info',
    'baixa': 'success'
  };
  return map[criticidade?.toLowerCase()] || 'secondary';
};
</script>

<style scoped>
.equipamentos-list-page {
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

h1 {
  font-size: 28px;
  font-weight: 700;
  color: #1f2937;
  margin: 0;
}

.filters-section {
  margin-bottom: 24px;
}

.search-input {
  width: 100%;
  max-width: 500px;
  padding: 12px 16px;
  border: 1px solid #d1d5db;
  border-radius: 6px;
  font-size: 14px;
}

.search-input:focus {
  outline: none;
  border-color: #3b82f6;
  box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.equipamentos-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
  gap: 20px;
  margin-bottom: 24px;
}

.equip-card {
  background: white;
  border-radius: 8px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
  overflow: hidden;
  transition: transform 0.2s, box-shadow 0.2s;
}

.equip-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.card-header {
  padding: 16px;
  background: #f9fafb;
  border-bottom: 1px solid #e5e7eb;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.card-header h3 {
  margin: 0;
  font-size: 18px;
  font-weight: 600;
  color: #1f2937;
}

.badge {
  padding: 4px 12px;
  border-radius: 12px;
  font-size: 12px;
  font-weight: 600;
  text-transform: uppercase;
}

.badge-danger { background: #fee2e2; color: #991b1b; }
.badge-warning { background: #fef3c7; color: #92400e; }
.badge-info { background: #dbeafe; color: #1e40af; }
.badge-success { background: #d1fae5; color: #065f46; }
.badge-secondary { background: #e5e7eb; color: #374151; }

.card-body {
  padding: 16px;
}

.info-row {
  display: flex;
  justify-content: space-between;
  padding: 8px 0;
  border-bottom: 1px solid #f3f4f6;
}

.info-row:last-child {
  border-bottom: none;
}

.label {
  font-size: 14px;
  color: #6b7280;
  font-weight: 500;
}

.value {
  font-size: 14px;
  color: #1f2937;
  font-weight: 600;
}

.card-actions {
  padding: 12px 16px;
  background: #f9fafb;
  display: flex;
  gap: 8px;
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

.btn-secondary {
  background: #e5e7eb;
  color: #374151;
}

.btn-secondary:hover {
  background: #d1d5db;
}

.btn-danger {
  background: #ef4444;
  color: white;
}

.btn-danger:hover {
  background: #dc2626;
}

.btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.loading-container, .empty-state {
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

.empty-state i {
  font-size: 64px;
  color: #d1d5db;
  margin-bottom: 16px;
}

.empty-state h3 {
  font-size: 20px;
  font-weight: 600;
  color: #1f2937;
  margin: 0 0 8px;
}

.empty-state p {
  color: #6b7280;
  margin-bottom: 24px;
}

.pagination {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 16px;
  padding: 20px;
  background: white;
  border-radius: 8px;
}

.page-info {
  font-size: 14px;
  color: #6b7280;
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
