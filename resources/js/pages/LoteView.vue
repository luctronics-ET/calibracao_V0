<template>
  <div class="lote-view-page">
    <div class="page-header">
      <router-link to="/vue/lotes" class="back-link">
        <i class="fas fa-arrow-left"></i> Voltar
      </router-link>
      <div class="header-actions">
        <router-link :to="`/vue/lotes/${id}/editar`" class="btn btn-warning">
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

    <div v-if="!loading && lote" class="content-grid">
      <div class="info-card">
        <h2>
          <i class="fas fa-boxes"></i>
          Lote #{{ lote.id }}
          <span :class="['badge', getStatusClass(lote.status)]">
            {{ getStatusLabel(lote.status) }}
          </span>
        </h2>
        <div class="info-group">
          <div class="info-row">
            <span class="label">Descrição:</span>
            <span class="value">{{ lote.descricao || 'N/A' }}</span>
          </div>
          <div class="info-row">
            <span class="label">Laboratório de Destino:</span>
            <span class="value">{{ lote.laboratorio_destino?.nome || 'N/A' }}</span>
          </div>
          <div class="info-row">
            <span class="label">Responsável pelo Envio:</span>
            <span class="value">{{ lote.responsavel_envio || 'N/A' }}</span>
          </div>
        </div>
      </div>

      <div class="info-card">
        <h3><i class="fas fa-calendar-alt"></i> Datas</h3>
        <div class="info-group">
          <div class="info-row">
            <span class="label">Data de Envio:</span>
            <span class="value">{{ formatDate(lote.data_envio) }}</span>
          </div>
          <div class="info-row">
            <span class="label">Retorno Previsto:</span>
            <span class="value">{{ formatDate(lote.data_retorno_prevista) }}</span>
          </div>
          <div class="info-row">
            <span class="label">Retorno Efetivo:</span>
            <span class="value">{{ formatDate(lote.data_retorno_efetivo) }}</span>
          </div>
        </div>
      </div>

      <div class="info-card">
        <h3><i class="fas fa-link"></i> Relacionamentos</h3>
        <div class="info-group">
          <div class="info-row">
            <span class="label">Contrato de Serviço:</span>
            <span class="value">{{ lote.contrato_servico?.numero_contrato || 'N/A' }}</span>
          </div>
          <div class="info-row">
            <span class="label">Transporte:</span>
            <span class="value">
              {{ lote.transporte ? `${lote.transporte.tipo_transporte} - ${lote.transporte.empresa_transportadora}` : 'N/A' }}
            </span>
          </div>
        </div>
      </div>

      <div class="info-card equipamentos-card">
        <h3>
          <i class="fas fa-tools"></i>
          Equipamentos no Lote
          <span class="badge-count">{{ lote.equipamentos?.length || 0 }}</span>
        </h3>
        <div v-if="lote.equipamentos && lote.equipamentos.length > 0" class="equipamentos-list">
          <div v-for="equip in lote.equipamentos" :key="equip.id" class="equipamento-item">
            <div class="equip-info">
              <i class="fas fa-wrench"></i>
              <div>
                <div class="equip-name">{{ equip.tipo }}</div>
                <div class="equip-code">{{ equip.codigo_interno }}</div>
              </div>
            </div>
            <router-link :to="`/vue/equipamentos/${equip.id}`" class="btn-link">
              <i class="fas fa-eye"></i>
            </router-link>
          </div>
        </div>
        <div v-else class="empty-equipamentos">
          <i class="fas fa-inbox"></i>
          <p>Nenhum equipamento neste lote</p>
        </div>
      </div>

      <div v-if="lote.observacoes" class="info-card">
        <h3><i class="fas fa-comment"></i> Observações</h3>
        <p class="observacoes">{{ lote.observacoes }}</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { useLotesStore } from '../stores/lotes';

const router = useRouter();
const route = useRoute();
const lotesStore = useLotesStore();

const id = route.params.id;
const loading = ref(false);
const error = ref(null);
const lote = ref(null);

onMounted(async () => {
  try {
    loading.value = true;
    lote.value = await lotesStore.fetchLote(id);
  } catch (err) {
    error.value = err.message || 'Erro ao carregar lote';
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

const handleDelete = async () => {
  if (!confirm('Tem certeza que deseja excluir este lote?')) return;
  try {
    await lotesStore.deleteLote(id);
    router.push('/vue/lotes');
  } catch (err) {
    alert(err.message || 'Erro ao excluir lote');
  }
};
</script>

<style scoped>
.lote-view-page {
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

.equipamentos-card {
  background: linear-gradient(135deg, #faf5ff 0%, #ffffff 100%);
  border: 2px solid #8b5cf6;
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
  background: #8b5cf6;
  color: white;
  padding: 4px 12px;
  border-radius: 12px;
  font-size: 13px;
  font-weight: 600;
  margin-left: auto;
}

.equipamentos-list {
  display: grid;
  gap: 12px;
}

.equipamento-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 14px;
  background: white;
  border: 1px solid #e5e7eb;
  border-radius: 8px;
  transition: all 0.2s;
}

.equipamento-item:hover {
  border-color: #8b5cf6;
  box-shadow: 0 2px 4px rgba(139, 92, 246, 0.1);
}

.equip-info {
  display: flex;
  align-items: center;
  gap: 12px;
}

.equip-info i {
  color: #8b5cf6;
  font-size: 20px;
}

.equip-name {
  font-weight: 600;
  color: #1f2937;
  font-size: 14px;
}

.equip-code {
  color: #6b7280;
  font-size: 13px;
}

.btn-link {
  padding: 8px 12px;
  background: #f3f4f6;
  border-radius: 6px;
  color: #6b7280;
  text-decoration: none;
  transition: all 0.2s;
}

.btn-link:hover {
  background: #8b5cf6;
  color: white;
}

.empty-equipamentos {
  text-align: center;
  padding: 40px 20px;
  color: #9ca3af;
}

.empty-equipamentos i {
  font-size: 48px;
  margin-bottom: 12px;
}

.empty-equipamentos p {
  font-size: 14px;
}

.observacoes {
  color: #374151;
  line-height: 1.6;
  white-space: pre-wrap;
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
