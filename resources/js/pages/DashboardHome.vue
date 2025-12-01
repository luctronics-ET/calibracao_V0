<template>
  <div class="dashboard-page">
    <h1>Dashboard - Sistema de Calibração</h1>

    <div v-if="loading" class="loading-container">
      <div class="spinner"></div>
    </div>

    <div v-if="!loading" class="dashboard-grid">
      <div class="stat-card equipamentos">
        <div class="stat-icon">
          <i class="fas fa-tools"></i>
        </div>
        <div class="stat-info">
          <div class="stat-value">{{ stats.totalEquipamentos }}</div>
          <div class="stat-label">Equipamentos</div>
        </div>
      </div>

      <div class="stat-card calibracoes">
        <div class="stat-icon">
          <i class="fas fa-clipboard-check"></i>
        </div>
        <div class="stat-info">
          <div class="stat-value">{{ stats.totalCalibracoes }}</div>
          <div class="stat-label">Calibrações</div>
        </div>
      </div>

      <div class="stat-card lotes">
        <div class="stat-icon">
          <i class="fas fa-boxes"></i>
        </div>
        <div class="stat-info">
          <div class="stat-value">{{ stats.totalLotes }}</div>
          <div class="stat-label">Lotes</div>
        </div>
      </div>

      <div class="stat-card bloqueados">
        <div class="stat-icon">
          <i class="fas fa-lock"></i>
        </div>
        <div class="stat-info">
          <div class="stat-value">{{ stats.equipamentosBloqueados }}</div>
          <div class="stat-label">Equipamentos Bloqueados</div>
        </div>
      </div>

      <div class="chart-card criticidade-card">
        <h3><i class="fas fa-chart-pie"></i> Equipamentos por Criticidade</h3>
        <div class="criticidade-bars">
          <div class="bar-item critica">
            <span class="bar-label">Crítica</span>
            <div class="bar-track">
              <div class="bar-fill" :style="{width: getPercentage(stats.criticidade.critica, stats.totalEquipamentos)}"></div>
            </div>
            <span class="bar-value">{{ stats.criticidade.critica }}</span>
          </div>
          <div class="bar-item alta">
            <span class="bar-label">Alta</span>
            <div class="bar-track">
              <div class="bar-fill" :style="{width: getPercentage(stats.criticidade.alta, stats.totalEquipamentos)}"></div>
            </div>
            <span class="bar-value">{{ stats.criticidade.alta }}</span>
          </div>
          <div class="bar-item media">
            <span class="bar-label">Média</span>
            <div class="bar-track">
              <div class="bar-fill" :style="{width: getPercentage(stats.criticidade.media, stats.totalEquipamentos)}"></div>
            </div>
            <span class="bar-value">{{ stats.criticidade.media }}</span>
          </div>
          <div class="bar-item baixa">
            <span class="bar-label">Baixa</span>
            <div class="bar-track">
              <div class="bar-fill" :style="{width: getPercentage(stats.criticidade.baixa, stats.totalEquipamentos)}"></div>
            </div>
            <span class="bar-value">{{ stats.criticidade.baixa }}</span>
          </div>
        </div>
      </div>

      <div class="chart-card status-card">
        <h3><i class="fas fa-clipboard-list"></i> Calibrações por Status</h3>
        <div class="status-list">
          <div class="status-item pendente">
            <span class="status-badge">Pendente</span>
            <span class="status-count">{{ stats.calibracaoStatus.pendente }}</span>
          </div>
          <div class="status-item em_andamento">
            <span class="status-badge">Em Andamento</span>
            <span class="status-count">{{ stats.calibracaoStatus.em_andamento }}</span>
          </div>
          <div class="status-item concluida">
            <span class="status-badge">Concluída</span>
            <span class="status-count">{{ stats.calibracaoStatus.concluida }}</span>
          </div>
          <div class="status-item aprovada">
            <span class="status-badge">Aprovada</span>
            <span class="status-count">{{ stats.calibracaoStatus.aprovada }}</span>
          </div>
        </div>
      </div>

      <div class="info-card rbc-info">
        <h3><i class="fas fa-certificate"></i> Conformidade RBC</h3>
        <div class="rbc-stats">
          <div class="rbc-item">
            <i class="fas fa-check-circle"></i>
            <div>
              <div class="rbc-value">{{ stats.calibracoesRBC }}</div>
              <div class="rbc-label">Com Código RBC</div>
            </div>
          </div>
          <div class="rbc-item">
            <i class="fas fa-star"></i>
            <div>
              <div class="rbc-value">{{ stats.calibracoesILAC }}</div>
              <div class="rbc-label">Conformes ILAC-P14</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useEquipamentosStore } from '../stores/equipamentos';
import { useCalibracoesStore } from '../stores/calibracoes';
import { useLotesStore } from '../stores/lotes';

const equipamentosStore = useEquipamentosStore();
const calibracoesStore = useCalibracoesStore();
const lotesStore = useLotesStore();

const loading = ref(false);

const stats = ref({
  totalEquipamentos: 0,
  totalCalibracoes: 0,
  totalLotes: 0,
  equipamentosBloqueados: 0,
  criticidade: {
    critica: 0,
    alta: 0,
    media: 0,
    baixa: 0
  },
  calibracaoStatus: {
    pendente: 0,
    em_andamento: 0,
    concluida: 0,
    aprovada: 0
  },
  calibracoesRBC: 0,
  calibracoesILAC: 0
});

onMounted(async () => {
  try {
    loading.value = true;
    
    await Promise.all([
      equipamentosStore.fetchEquipamentos(),
      calibracoesStore.fetchCalibracoes(),
      lotesStore.fetchLotes()
    ]);

    calculateStats();
  } catch (err) {
    console.error('Erro ao carregar dashboard:', err);
  } finally {
    loading.value = false;
  }
});

const calculateStats = () => {
  const equipamentos = equipamentosStore.equipamentos || [];
  const calibracoes = calibracoesStore.calibracoes || [];
  const lotes = lotesStore.lotes || [];

  stats.value.totalEquipamentos = equipamentos.length;
  stats.value.totalCalibracoes = calibracoes.length;
  stats.value.totalLotes = lotes.length;

  stats.value.equipamentosBloqueados = equipamentos.filter(e => e.bloqueado_para_uso).length;

  stats.value.criticidade = {
    critica: equipamentos.filter(e => e.criticidade_equipamento === 'critica').length,
    alta: equipamentos.filter(e => e.criticidade_equipamento === 'alta').length,
    media: equipamentos.filter(e => e.criticidade_equipamento === 'media').length,
    baixa: equipamentos.filter(e => e.criticidade_equipamento === 'baixa').length
  };

  stats.value.calibracaoStatus = {
    pendente: calibracoes.filter(c => c.status === 'pendente').length,
    em_andamento: calibracoes.filter(c => c.status === 'em_andamento').length,
    concluida: calibracoes.filter(c => c.status === 'concluida').length,
    aprovada: calibracoes.filter(c => c.status === 'aprovada').length
  };

  stats.value.calibracoesRBC = calibracoes.filter(c => c.rbc_codigo_laboratorio).length;
  stats.value.calibracoesILAC = calibracoes.filter(c => c.conformidade_ilac_p14).length;
};

const getPercentage = (value, total) => {
  if (total === 0) return '0%';
  return `${Math.round((value / total) * 100)}%`;
};
</script>

<style scoped>
.dashboard-page {
  padding: 24px;
  max-width: 1400px;
  margin: 0 auto;
}

h1 {
  font-size: 28px;
  font-weight: 700;
  color: #1f2937;
  margin-bottom: 32px;
}

.dashboard-grid {
  display: grid;
  gap: 24px;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
}

.stat-card {
  background: white;
  padding: 24px;
  border-radius: 12px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  display: flex;
  align-items: center;
  gap: 20px;
  transition: transform 0.2s;
}

.stat-card:hover {
  transform: translateY(-2px);
}

.stat-icon {
  width: 64px;
  height: 64px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 28px;
}

.stat-card.equipamentos .stat-icon {
  background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
  color: white;
}

.stat-card.calibracoes .stat-icon {
  background: linear-gradient(135deg, #10b981 0%, #059669 100%);
  color: white;
}

.stat-card.lotes .stat-icon {
  background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
  color: white;
}

.stat-card.bloqueados .stat-icon {
  background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
  color: white;
}

.stat-info {
  flex: 1;
}

.stat-value {
  font-size: 36px;
  font-weight: 700;
  color: #1f2937;
  line-height: 1;
  margin-bottom: 8px;
}

.stat-label {
  font-size: 14px;
  color: #6b7280;
  font-weight: 500;
}

.chart-card {
  background: white;
  padding: 24px;
  border-radius: 12px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  grid-column: span 2;
}

.chart-card h3 {
  font-size: 18px;
  font-weight: 600;
  color: #1f2937;
  margin: 0 0 24px 0;
  display: flex;
  align-items: center;
  gap: 10px;
}

.criticidade-bars {
  display: grid;
  gap: 16px;
}

.bar-item {
  display: grid;
  grid-template-columns: 80px 1fr 50px;
  align-items: center;
  gap: 12px;
}

.bar-label {
  font-size: 14px;
  font-weight: 500;
  color: #374151;
}

.bar-track {
  height: 24px;
  background: #f3f4f6;
  border-radius: 12px;
  overflow: hidden;
}

.bar-fill {
  height: 100%;
  border-radius: 12px;
  transition: width 0.3s;
}

.bar-item.critica .bar-fill {
  background: linear-gradient(90deg, #ef4444 0%, #dc2626 100%);
}

.bar-item.alta .bar-fill {
  background: linear-gradient(90deg, #f59e0b 0%, #d97706 100%);
}

.bar-item.media .bar-fill {
  background: linear-gradient(90deg, #3b82f6 0%, #2563eb 100%);
}

.bar-item.baixa .bar-fill {
  background: linear-gradient(90deg, #10b981 0%, #059669 100%);
}

.bar-value {
  font-size: 14px;
  font-weight: 600;
  color: #1f2937;
  text-align: right;
}

.status-list {
  display: grid;
  gap: 12px;
}

.status-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 12px 16px;
  background: #f9fafb;
  border-radius: 8px;
}

.status-badge {
  font-size: 14px;
  font-weight: 500;
  color: #374151;
}

.status-count {
  font-size: 18px;
  font-weight: 700;
  color: #1f2937;
}

.info-card {
  background: linear-gradient(135deg, #f0f9ff 0%, #ffffff 100%);
  border: 2px solid #3b82f6;
  padding: 24px;
  border-radius: 12px;
  grid-column: span 2;
}

.info-card h3 {
  font-size: 18px;
  font-weight: 600;
  color: #1f2937;
  margin: 0 0 20px 0;
  display: flex;
  align-items: center;
  gap: 10px;
}

.rbc-stats {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;
}

.rbc-item {
  display: flex;
  align-items: center;
  gap: 16px;
}

.rbc-item i {
  font-size: 36px;
  color: #3b82f6;
}

.rbc-value {
  font-size: 28px;
  font-weight: 700;
  color: #1f2937;
}

.rbc-label {
  font-size: 13px;
  color: #6b7280;
  font-weight: 500;
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

@media (max-width: 768px) {
  .chart-card {
    grid-column: span 1;
  }
  
  .info-card {
    grid-column: span 1;
  }
  
  .rbc-stats {
    grid-template-columns: 1fr;
  }
}
</style>
