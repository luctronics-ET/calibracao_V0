<template>
  <div class="equipamento-view-page">
    <div class="page-header">
      <router-link to="/vue/equipamentos" class="back-link">
        <i class="fas fa-arrow-left"></i> Voltar
      </router-link>
      <div class="header-actions">
        <router-link :to="`/vue/equipamentos/${id}/editar`" class="btn btn-warning">
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

    <div v-if="!loading && equipamento" class="content-grid">
      <div class="info-card">
        <h2>
          <i class="fas fa-tools"></i>
          {{ equipamento.tipo }}
          <span v-if="equipamento.bloqueado_para_uso" class="badge-bloqueado">
            <i class="fas fa-lock"></i> BLOQUEADO
          </span>
        </h2>
        <div class="info-group">
          <div class="info-row">
            <span class="label">Categoria Metrológica:</span>
            <span class="value">{{ equipamento.categoria_metrologica || 'N/A' }}</span>
          </div>
          <div class="info-row">
            <span class="label">Fabricante:</span>
            <span class="value">{{ equipamento.fabricante || 'N/A' }}</span>
          </div>
          <div class="info-row">
            <span class="label">Modelo:</span>
            <span class="value">{{ equipamento.modelo || 'N/A' }}</span>
          </div>
          <div class="info-row">
            <span class="label">Número de Série:</span>
            <span class="value">{{ equipamento.numero_serie || 'N/A' }}</span>
          </div>
          <div class="info-row">
            <span class="label">Código Interno:</span>
            <span class="value">{{ equipamento.codigo_interno || 'N/A' }}</span>
          </div>
          <div class="info-row">
            <span class="label">Criticidade:</span>
            <span :class="['badge', getCriticidadeClass(equipamento.criticidade_equipamento)]">
              {{ equipamento.criticidade_equipamento || 'N/A' }}
            </span>
          </div>
        </div>
      </div>

      <div class="info-card">
        <h3><i class="fas fa-map-marker-alt"></i> Localização</h3>
        <div class="info-group">
          <div class="info-row">
            <span class="label">Local de Dotação:</span>
            <span class="value">{{ equipamento.local_dotacao?.nome || 'N/A' }}</span>
          </div>
          <div class="info-row">
            <span class="label">Localização Atual:</span>
            <span class="value">{{ equipamento.localizacao_atual?.nome || 'N/A' }}</span>
          </div>
        </div>
      </div>

      <div class="info-card">
        <h3><i class="fas fa-ruler"></i> Características Metrológicas</h3>
        <div class="info-group">
          <div class="info-row">
            <span class="label">Classe de Exatidão:</span>
            <span class="value">{{ equipamento.classe_exatidao || 'N/A' }}</span>
          </div>
          <div class="info-row">
            <span class="label">Resolução:</span>
            <span class="value">{{ equipamento.resolucao || 'N/A' }}</span>
          </div>
          <div class="info-row">
            <span class="label">Intervalo de Medição:</span>
            <span class="value">
              {{ equipamento.intervalo_medicao_min }} - {{ equipamento.intervalo_medicao_max }}
            </span>
          </div>
        </div>
      </div>

      <div class="info-card">
        <h3><i class="fas fa-thermometer-half"></i> Condições de Operação</h3>
        <div class="info-group">
          <div class="info-row">
            <span class="label">Temperatura:</span>
            <span class="value">{{ equipamento.cond_temp_operacao || 'N/A' }}</span>
          </div>
          <div class="info-row">
            <span class="label">Umidade:</span>
            <span class="value">{{ equipamento.cond_umidade_operacao || 'N/A' }}</span>
          </div>
          <div v-if="equipamento.cond_ambiente_restricoes" class="info-row full">
            <span class="label">Restrições Ambientais:</span>
            <span class="value">{{ equipamento.cond_ambiente_restricoes }}</span>
          </div>
        </div>
      </div>

      <div class="info-card">
        <h3><i class="fas fa-calendar-check"></i> Calibração</h3>
        <div class="info-group">
          <div class="info-row">
            <span class="label">Intervalo de Calibração:</span>
            <span class="value">{{ equipamento.intervalo_calibracao_meses }} meses</span>
          </div>
          <div class="info-row">
            <span class="label">Próxima Calibração:</span>
            <span class="value">{{ formatDate(equipamento.proxima_calibracao_prevista) }}</span>
          </div>
          <div class="info-row">
            <span class="label">Custo Previsto:</span>
            <span class="value">{{ formatMoeda(equipamento.custo_previsto_calibracao) }}</span>
          </div>
          <div v-if="equipamento.justificativa_intervalo" class="info-row full">
            <span class="label">Justificativa do Intervalo:</span>
            <span class="value">{{ equipamento.justificativa_intervalo }}</span>
          </div>
        </div>
      </div>

      <div v-if="equipamento.bloqueado_para_uso" class="info-card alert-warning">
        <h3><i class="fas fa-lock"></i> Bloqueio de Uso</h3>
        <div class="info-group">
          <div class="info-row full">
            <span class="label">Motivo do Bloqueio:</span>
            <span class="value">{{ equipamento.motivo_bloqueio || 'N/A' }}</span>
          </div>
        </div>
      </div>

      <div class="info-card">
        <h3><i class="fas fa-user"></i> Responsáveis</h3>
        <div class="info-group">
          <div class="info-row">
            <span class="label">Responsável Técnico:</span>
            <span class="value">{{ equipamento.responsavel_tecnico || 'N/A' }}</span>
          </div>
          <div class="info-row">
            <span class="label">Responsável Cadastramento:</span>
            <span class="value">{{ equipamento.responsavel_cadastramento || 'N/A' }}</span>
          </div>
          <div v-if="equipamento.observacoes_auditoria" class="info-row full">
            <span class="label">Observações de Auditoria:</span>
            <span class="value">{{ equipamento.observacoes_auditoria }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { useEquipamentosStore } from '../stores/equipamentos';

const router = useRouter();
const route = useRoute();
const equipamentosStore = useEquipamentosStore();

const id = route.params.id;
const loading = ref(false);
const error = ref(null);
const equipamento = ref(null);

onMounted(async () => {
  try {
    loading.value = true;
    equipamento.value = await equipamentosStore.fetchEquipamento(id);
  } catch (err) {
    error.value = err.message || 'Erro ao carregar equipamento';
  } finally {
    loading.value = false;
  }
});

const getCriticidadeClass = (criticidade) => {
  const classes = {
    'critica': 'badge-danger',
    'alta': 'badge-warning',
    'media': 'badge-info',
    'baixa': 'badge-success'
  };
  return classes[criticidade] || 'badge-secondary';
};

const formatDate = (date) => {
  if (!date) return 'N/A';
  return new Date(date).toLocaleDateString('pt-BR');
};

const formatMoeda = (valor) => {
  if (!valor) return 'N/A';
  return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(valor);
};

const handleDelete = async () => {
  if (!confirm('Tem certeza que deseja excluir este equipamento?')) return;
  try {
    await equipamentosStore.deleteEquipamento(id);
    router.push('/vue/equipamentos');
  } catch (err) {
    alert(err.message || 'Erro ao excluir equipamento');
  }
};
</script>

<style scoped>
.equipamento-view-page {
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

.info-card.alert-warning {
  background: #fffbeb;
  border: 2px solid #fbbf24;
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

.info-row.full {
  flex-direction: column;
  align-items: flex-start;
  gap: 6px;
}

.info-row .label {
  color: #6b7280;
  font-weight: 500;
}

.info-row .value {
  color: #1f2937;
  text-align: right;
}

.info-row.full .value {
  text-align: left;
}

.badge {
  padding: 4px 12px;
  border-radius: 12px;
  font-size: 12px;
  font-weight: 600;
  text-transform: uppercase;
}

.badge-danger {
  background: #fee2e2;
  color: #991b1b;
}

.badge-warning {
  background: #fef3c7;
  color: #92400e;
}

.badge-info {
  background: #dbeafe;
  color: #1e40af;
}

.badge-success {
  background: #d1fae5;
  color: #065f46;
}

.badge-secondary {
  background: #e5e7eb;
  color: #374151;
}

.badge-bloqueado {
  background: #fee2e2;
  color: #991b1b;
  padding: 6px 14px;
  border-radius: 16px;
  font-size: 13px;
  font-weight: 600;
  display: inline-flex;
  align-items: center;
  gap: 6px;
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
