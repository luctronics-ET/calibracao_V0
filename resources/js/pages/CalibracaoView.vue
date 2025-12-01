<template>
  <div class="calibracao-view-page">
    <div class="page-header">
      <router-link to="/vue/calibracoes" class="back-link">
        <i class="fas fa-arrow-left"></i> Voltar
      </router-link>
      <div class="header-actions">
        <router-link :to="`/vue/calibracoes/${id}/editar`" class="btn btn-warning">
          <i class="fas fa-edit"></i> Editar
        </router-link>
        <button @click="handleDelete" class="btn btn-danger">
          <i class="fas fa-trash"></i> Excluir
        </button>
      </div>
    </div>

    <div v-if="loading" class="loading-container">
      <div class="spinner"></div>
    </div>

    <div v-if="error" class="alert alert-danger">{{ error }}</div>

    <div v-if="!loading && calibracao" class="content-grid">
      <div class="info-card">
        <h2>
          <i class="fas fa-clipboard-check"></i>
          Calibração #{{ calibracao.id }}
          <span :class="['badge', getStatusClass(calibracao.status)]">
            {{ getStatusLabel(calibracao.status) }}
          </span>
        </h2>
        <div class="info-group">
          <div class="info-row">
            <span class="label">Equipamento:</span>
            <span class="value">{{ calibracao.equipamento?.tipo || 'N/A' }}</span>
          </div>
          <div class="info-row">
            <span class="label">Data da Calibração:</span>
            <span class="value">{{ formatDate(calibracao.data_calibracao) }}</span>
          </div>
          <div class="info-row">
            <span class="label">Laboratório:</span>
            <span class="value">{{ calibracao.laboratorio?.nome || 'N/A' }}</span>
          </div>
          <div v-if="calibracao.proxima_calibracao_sugerida" class="info-row">
            <span class="label">Próxima Calibração Sugerida:</span>
            <span class="value">{{ formatDate(calibracao.proxima_calibracao_sugerida) }}</span>
          </div>
        </div>
      </div>

      <div class="info-card rbc-card">
        <h3>
          <i class="fas fa-certificate"></i>
          Informações RBC
          <span v-if="calibracao.conformidade_ilac_p14" class="badge-success">
            <i class="fas fa-check-circle"></i> ILAC-P14 Conforme
          </span>
        </h3>
        <div class="info-group">
          <div class="info-row">
            <span class="label">Código RBC do Laboratório:</span>
            <span class="value">{{ calibracao.rbc_codigo_laboratorio || 'N/A' }}</span>
          </div>
          <div class="info-row">
            <span class="label">Método de Calibração RBC:</span>
            <span class="value">{{ calibracao.rbc_metodo_calibracao || 'N/A' }}</span>
          </div>
          <div class="info-row">
            <span class="label">Incerteza Prevista RBC:</span>
            <span class="value">{{ calibracao.rbc_incerteza_prevista || 'N/A' }}</span>
          </div>
          <div class="info-row">
            <span class="label">Capacidade de Medição (CMC):</span>
            <span class="value">{{ calibracao.rbc_capacidade_medicao || 'N/A' }}</span>
          </div>
        </div>
      </div>

      <div class="info-card">
        <h3><i class="fas fa-link"></i> Relacionamentos</h3>
        <div class="info-group">
          <div class="info-row">
            <span class="label">Lote:</span>
            <span class="value">
              {{ calibracao.lote ? `Lote #${calibracao.lote.id}` : 'N/A' }}
            </span>
          </div>
          <div class="info-row">
            <span class="label">Contrato de Serviço:</span>
            <span class="value">{{ calibracao.contrato_servico?.numero_contrato || 'N/A' }}</span>
          </div>
          <div class="info-row">
            <span class="label">Localização Atual:</span>
            <span class="value">{{ calibracao.localizacao_atual?.nome || 'N/A' }}</span>
          </div>
        </div>
      </div>

      <div v-if="calibracao.observacoes" class="info-card">
        <h3><i class="fas fa-comment"></i> Observações</h3>
        <p class="observacoes">{{ calibracao.observacoes }}</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { useCalibracoesStore } from '../stores/calibracoes';

const router = useRouter();
const route = useRoute();
const calibracoesStore = useCalibracoesStore();

const id = route.params.id;
const loading = ref(false);
const error = ref(null);
const calibracao = ref(null);

onMounted(async () => {
  try {
    loading.value = true;
    calibracao.value = await calibracoesStore.fetchCalibracao(id);
  } catch (err) {
    error.value = err.message || 'Erro ao carregar calibração';
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

const handleDelete = async () => {
  if (!confirm('Tem certeza que deseja excluir esta calibração?')) return;
  try {
    await calibracoesStore.deleteCalibracao(id);
    router.push('/vue/calibracoes');
  } catch (err) {
    alert(err.message || 'Erro ao excluir calibração');
  }
};
</script>

<style scoped>
.calibracao-view-page {
  padding: 24px;
  max-width: 1200px;
  margin: 0 auto;
}

.page-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 24px;
}

.back-link {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  color: #6b7280;
  text-decoration: none;
  font-size: 14px;
}

.back-link:hover {
  color: #3b82f6;
}

.header-actions {
  display: flex;
  gap: 12px;
}

.content-grid {
  display: grid;
  gap: 20px;
}

.info-card {
  background: white;
  padding: 24px;
  border-radius: 8px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.rbc-card {
  background: linear-gradient(135deg, #f0f9ff 0%, #ffffff 100%);
  border: 2px solid #3b82f6;
}

.info-card h2 {
  font-size: 24px;
  font-weight: 700;
  color: #1f2937;
  margin: 0 0 20px 0;
  display: flex;
  align-items: center;
  gap: 12px;
}

.info-card h3 {
  font-size: 16px;
  font-weight: 600;
  color: #1f2937;
  margin: 0 0 16px 0;
  display: flex;
  align-items: center;
  gap: 8px;
  padding-bottom: 12px;
  border-bottom: 2px solid #e5e7eb;
}

.info-group {
  display: grid;
  gap: 12px;
}

.info-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 8px 0;
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

.observacoes {
  color: #374151;
  line-height: 1.6;
  white-space: pre-wrap;
}

.badge {
  padding: 6px 14px;
  border-radius: 16px;
  font-size: 13px;
  font-weight: 600;
  text-transform: uppercase;
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
  display: inline-flex;
  align-items: center;
  gap: 6px;
}

.badge-danger {
  background: #fee2e2;
  color: #991b1b;
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
