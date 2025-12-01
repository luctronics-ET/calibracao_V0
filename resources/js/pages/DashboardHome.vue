<template>
  <div class="dashboard-home">
    <div class="welcome-section">
      <h1>Sistema de Gerenciamento de Calibração</h1>
      <p>Controle de equipamentos com Matriz IGP (Índice de Grau de Prioridade)</p>
    </div>

    <!-- Cards de Estatísticas -->
    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-icon total">
          <i class="fas fa-tools"></i>
        </div>
        <div class="stat-content">
          <span class="stat-label">Total de Equipamentos</span>
          <span class="stat-value">{{ stats.total }}</span>
        </div>
      </div>

      <div class="stat-card">
        <div class="stat-icon alta">
          <i class="fas fa-exclamation-triangle"></i>
        </div>
        <div class="stat-content">
          <span class="stat-label">IGP Alta</span>
          <span class="stat-value">{{ stats.alta }}</span>
        </div>
      </div>

      <div class="stat-card">
        <div class="stat-icon media">
          <i class="fas fa-exclamation-circle"></i>
        </div>
        <div class="stat-content">
          <span class="stat-label">IGP Média</span>
          <span class="stat-value">{{ stats.media }}</span>
        </div>
      </div>

      <div class="stat-card">
        <div class="stat-icon baixa">
          <i class="fas fa-check-circle"></i>
        </div>
        <div class="stat-content">
          <span class="stat-label">IGP Baixa</span>
          <span class="stat-value">{{ stats.baixa }}</span>
        </div>
      </div>
    </div>

    <!-- Ações Rápidas -->
    <div class="quick-actions">
      <h2>Ações Rápidas</h2>
      <div class="actions-grid">
        <router-link to="/equipamentos/novo" class="action-card">
          <i class="fas fa-plus-circle"></i>
          <span>Novo Equipamento</span>
        </router-link>
        
        <router-link to="/equipamentos" class="action-card">
          <i class="fas fa-list"></i>
          <span>Ver Todos os Equipamentos</span>
        </router-link>
        
        <router-link to="/equipamentos?classificacao=alta" class="action-card">
          <i class="fas fa-filter"></i>
          <span>Equipamentos Alta Prioridade</span>
        </router-link>
      </div>
    </div>

    <!-- Informações sobre IGP -->
    <div class="info-section">
      <h2>Sobre a Matriz IGP</h2>
      <div class="info-content">
        <p>
          O <strong>IGP (Índice de Grau de Prioridade)</strong> é calculado automaticamente 
          com base em 5 fatores essenciais, cada um avaliado de 1 a 3:
        </p>
        <ul>
          <li><strong>Frequência de Uso:</strong> Intensidade de utilização do equipamento</li>
          <li><strong>Necessidade Crítica:</strong> Importância para processos críticos</li>
          <li><strong>Abundância:</strong> Disponibilidade de equipamentos similares</li>
          <li><strong>Custo de Indisponibilidade:</strong> Impacto financeiro da falha</li>
          <li><strong>Criticidade Metrológica:</strong> Precisão requerida nas medições</li>
        </ul>
        <div class="classification-info">
          <div class="classif-item alta">
            <strong>Alta Prioridade (IGP ≥ 12):</strong> Equipamentos críticos que requerem atenção imediata
          </div>
          <div class="classif-item media">
            <strong>Média Prioridade (7 ≤ IGP < 12):</strong> Equipamentos importantes com manutenção regular
          </div>
          <div class="classif-item baixa">
            <strong>Baixa Prioridade (IGP < 7):</strong> Equipamentos de rotina com menor criticidade
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const stats = ref({
  total: 0,
  alta: 0,
  media: 0,
  baixa: 0,
});

onMounted(async () => {
  try {
    const response = await axios.get('/api/equipamentos', {
      params: { per_page: 1000 }
    });
    
    const equipamentos = response.data.data;
    stats.value.total = equipamentos.length;
    stats.value.alta = equipamentos.filter(e => e.classificacao_igp === 'alta').length;
    stats.value.media = equipamentos.filter(e => e.classificacao_igp === 'media').length;
    stats.value.baixa = equipamentos.filter(e => e.classificacao_igp === 'baixa').length;
  } catch (error) {
    console.error('Erro ao carregar estatísticas:', error);
  }
});
</script>

<style scoped>
.dashboard-home {
  padding: 24px;
  max-width: 1400px;
  margin: 0 auto;
}

.welcome-section {
  margin-bottom: 32px;
}

.welcome-section h1 {
  font-size: 32px;
  font-weight: 700;
  color: #1f2937;
  margin-bottom: 8px;
}

.welcome-section p {
  font-size: 16px;
  color: #6b7280;
}

.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 20px;
  margin-bottom: 40px;
}

.stat-card {
  background: white;
  border-radius: 8px;
  padding: 20px;
  display: flex;
  align-items: center;
  gap: 16px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
  transition: transform 0.2s, box-shadow 0.2s;
}

.stat-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.stat-icon {
  width: 60px;
  height: 60px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 28px;
  color: white;
}

.stat-icon.total {
  background: linear-gradient(135deg, #3b82f6, #2563eb);
}

.stat-icon.alta {
  background: linear-gradient(135deg, #ef4444, #dc2626);
}

.stat-icon.media {
  background: linear-gradient(135deg, #f59e0b, #d97706);
}

.stat-icon.baixa {
  background: linear-gradient(135deg, #10b981, #059669);
}

.stat-content {
  display: flex;
  flex-direction: column;
  gap: 4px;
}

.stat-label {
  font-size: 13px;
  font-weight: 500;
  color: #6b7280;
}

.stat-value {
  font-size: 32px;
  font-weight: 700;
  color: #1f2937;
}

.quick-actions {
  margin-bottom: 40px;
}

.quick-actions h2 {
  font-size: 20px;
  font-weight: 600;
  color: #1f2937;
  margin-bottom: 16px;
}

.actions-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 16px;
}

.action-card {
  background: white;
  border-radius: 8px;
  padding: 24px;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 12px;
  text-decoration: none;
  color: #1f2937;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
  transition: all 0.2s;
}

.action-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
  background: #3b82f6;
  color: white;
}

.action-card i {
  font-size: 32px;
  color: #3b82f6;
  transition: color 0.2s;
}

.action-card:hover i {
  color: white;
}

.action-card span {
  font-size: 14px;
  font-weight: 500;
  text-align: center;
}

.info-section {
  background: white;
  border-radius: 8px;
  padding: 24px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.info-section h2 {
  font-size: 20px;
  font-weight: 600;
  color: #1f2937;
  margin-bottom: 16px;
}

.info-content p {
  color: #4b5563;
  line-height: 1.6;
  margin-bottom: 16px;
}

.info-content ul {
  list-style-position: inside;
  color: #4b5563;
  margin-bottom: 20px;
}

.info-content li {
  margin-bottom: 8px;
  line-height: 1.6;
}

.classification-info {
  display: flex;
  flex-direction: column;
  gap: 12px;
  margin-top: 20px;
}

.classif-item {
  padding: 16px;
  border-radius: 8px;
  color: white;
  font-size: 14px;
  line-height: 1.5;
}

.classif-item.alta {
  background: linear-gradient(135deg, #ef4444, #dc2626);
}

.classif-item.media {
  background: linear-gradient(135deg, #f59e0b, #d97706);
}

.classif-item.baixa {
  background: linear-gradient(135deg, #10b981, #059669);
}

.classif-item strong {
  display: block;
  margin-bottom: 4px;
  font-weight: 600;
}
</style>
