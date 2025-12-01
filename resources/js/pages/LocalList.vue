<template>
  <div class="locais-list-page">
    <div class="page-header">
      <h1>Locais</h1>
      <router-link to="/vue/locais/novo" class="btn btn-primary">
        <i class="fas fa-plus"></i>
        Novo Local
      </router-link>
    </div>

    <div class="filters-bar">
      <input 
        v-model="searchQuery" 
        type="text" 
        placeholder="Buscar por nome, código ou setor..." 
        class="search-input"
      />
      <select v-model="tipoFilter" class="filter-select">
        <option value="">Todos os Tipos</option>
        <option value="laboratorio">Laboratório</option>
        <option value="almoxarifado">Almoxarifado</option>
        <option value="sala">Sala</option>
        <option value="setor">Setor</option>
        <option value="externo">Externo</option>
        <option value="outro">Outro</option>
      </select>
    </div>

    <div v-if="loading" class="loading-container">
      <div class="spinner"></div>
    </div>

    <div v-if="error" class="alert alert-danger">{{ error }}</div>

    <div v-if="!loading && filteredLocais.length === 0" class="empty-state">
      <i class="fas fa-map-marker-alt fa-3x"></i>
      <p>Nenhum local encontrado</p>
      <router-link to="/vue/locais/novo" class="btn btn-primary">
        Criar primeiro local
      </router-link>
    </div>

    <div v-if="!loading && filteredLocais.length > 0" class="locais-grid">
      <div v-for="local in filteredLocais" :key="local.id" class="local-card">
        <div class="card-header">
          <div class="card-title">
            <i class="fas fa-map-marker-alt"></i>
            {{ local.nome }}
          </div>
          <span v-if="local.tipo_local" :class="['badge-tipo', getTipoClass(local.tipo_local)]">
            {{ getTipoLabel(local.tipo_local) }}
          </span>
        </div>

        <div class="card-body">
          <div v-if="local.codigo" class="info-row">
            <span class="label">Código:</span>
            <span class="value">{{ local.codigo }}</span>
          </div>
          <div v-if="local.predio" class="info-row">
            <span class="label">Prédio:</span>
            <span class="value">{{ local.predio }}</span>
          </div>
          <div v-if="local.andar || local.sala" class="info-row">
            <span class="label">Localização:</span>
            <span class="value">
              {{ [local.andar, local.sala].filter(Boolean).join(' - ') }}
            </span>
          </div>
          <div v-if="local.setor" class="info-row">
            <span class="label">Setor:</span>
            <span class="value">{{ local.setor }}</span>
          </div>
          <div v-if="local.capacidade" class="info-row">
            <span class="label">Capacidade:</span>
            <span class="value">{{ local.capacidade }} equipamentos</span>
          </div>
          <div v-if="local.responsavel" class="info-row">
            <span class="label">Responsável:</span>
            <span class="value">{{ local.responsavel }}</span>
          </div>
        </div>

        <div class="card-actions">
          <router-link :to="`/vue/locais/${local.id}`" class="btn btn-sm btn-info">
            <i class="fas fa-eye"></i> Ver
          </router-link>
          <router-link :to="`/vue/locais/${local.id}/editar`" class="btn btn-sm btn-warning">
            <i class="fas fa-edit"></i> Editar
          </router-link>
          <button @click="handleDelete(local.id)" class="btn btn-sm btn-danger">
            <i class="fas fa-trash"></i> Excluir
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { useLocaisStore } from '../stores/locais';

const locaisStore = useLocaisStore();

const loading = ref(false);
const error = ref(null);
const searchQuery = ref('');
const tipoFilter = ref('');

const locais = computed(() => locaisStore.locais);

const filteredLocais = computed(() => {
  let result = locais.value;

  if (tipoFilter.value) {
    result = result.filter(l => l.tipo_local === tipoFilter.value);
  }

  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase();
    result = result.filter(l => 
      l.nome?.toLowerCase().includes(query) ||
      l.codigo?.toLowerCase().includes(query) ||
      l.setor?.toLowerCase().includes(query)
    );
  }

  return result;
});

onMounted(async () => {
  try {
    loading.value = true;
    await locaisStore.fetchLocais();
  } catch (err) {
    error.value = err.message || 'Erro ao carregar locais';
  } finally {
    loading.value = false;
  }
});

const getTipoClass = (tipo) => {
  const classes = {
    'laboratorio': 'tipo-lab',
    'almoxarifado': 'tipo-alm',
    'sala': 'tipo-sala',
    'setor': 'tipo-setor',
    'externo': 'tipo-ext',
    'outro': 'tipo-outro'
  };
  return classes[tipo] || 'tipo-outro';
};

const getTipoLabel = (tipo) => {
  const labels = {
    'laboratorio': 'Laboratório',
    'almoxarifado': 'Almoxarifado',
    'sala': 'Sala',
    'setor': 'Setor',
    'externo': 'Externo',
    'outro': 'Outro'
  };
  return labels[tipo] || tipo;
};

const handleDelete = async (id) => {
  if (!confirm('Tem certeza que deseja excluir este local?')) return;
  try {
    await locaisStore.deleteLocal(id);
  } catch (err) {
    alert(err.message || 'Erro ao excluir local');
  }
};
</script>

<style scoped>
.locais-list-page {
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

.locais-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
  gap: 20px;
}

.local-card {
  background: white;
  border-radius: 8px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
  overflow: hidden;
  transition: transform 0.2s, box-shadow 0.2s;
}

.local-card:hover {
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
  color: #f59e0b;
}

.badge-tipo {
  padding: 4px 12px;
  border-radius: 12px;
  font-size: 12px;
  font-weight: 600;
  text-transform: uppercase;
}

.tipo-lab {
  background: #dbeafe;
  color: #1e40af;
}

.tipo-alm {
  background: #fef3c7;
  color: #92400e;
}

.tipo-sala {
  background: #d1fae5;
  color: #065f46;
}

.tipo-setor {
  background: #e9d5ff;
  color: #6b21a8;
}

.tipo-ext {
  background: #fed7aa;
  color: #9a3412;
}

.tipo-outro {
  background: #e5e7eb;
  color: #374151;
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
