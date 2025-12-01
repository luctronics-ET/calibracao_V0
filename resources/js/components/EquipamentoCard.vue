<template>
  <div class="equipamento-card">
    <!-- Foto -->
    <div class="card-image">
      <img
        v-if="equipamento.foto"
        :src="`/storage/${equipamento.foto}`"
        :alt="equipamento.tipo"
      />
      <div v-else class="no-image">
        <i class="fas fa-tools"></i>
      </div>
      
      <!-- Badge IGP -->
      <div class="igp-badge" :style="{ background: igpCor }">
        <span class="igp-label">IGP</span>
        <span class="igp-value">{{ equipamento.igp }}</span>
      </div>
    </div>

    <!-- Conteúdo -->
    <div class="card-content">
      <div class="card-header">
        <h3 class="card-title">{{ equipamento.tipo }}</h3>
        <span class="classe-badge">{{ equipamento.classe }}</span>
      </div>

      <div class="card-info">
        <div class="info-row">
          <i class="fas fa-industry"></i>
          <span>{{ equipamento.fabricante || 'N/A' }}</span>
        </div>
        <div class="info-row">
          <i class="fas fa-cube"></i>
          <span>{{ equipamento.modelo || 'N/A' }}</span>
        </div>
        <div class="info-row">
          <i class="fas fa-barcode"></i>
          <span>{{ equipamento.codigo_interno || 'N/A' }}</span>
        </div>
      </div>

      <!-- Classificação IGP -->
      <div class="classificacao-row">
        <span class="classificacao-label">Classificação:</span>
        <span
          class="classificacao-badge"
          :style="{ background: classificacaoCor, color: 'white' }"
        >
          {{ formatClassificacao(equipamento.classificacao_igp) }}
        </span>
      </div>

      <!-- Fatores IGP -->
      <div class="fatores-igp">
        <div class="fator-item" :title="`Frequência de Uso: ${equipamento.frequencia_uso || 0}`">
          <div class="fator-bar">
            <div
              class="fator-fill"
              :style="{ width: `${((equipamento.frequencia_uso || 0) / 3) * 100}%` }"
            ></div>
          </div>
        </div>
        <div class="fator-item" :title="`Necessidade Crítica: ${equipamento.necessidade_critica || 0}`">
          <div class="fator-bar">
            <div
              class="fator-fill"
              :style="{ width: `${((equipamento.necessidade_critica || 0) / 3) * 100}%` }"
            ></div>
          </div>
        </div>
        <div class="fator-item" :title="`Abundância: ${equipamento.abundancia || 0}`">
          <div class="fator-bar">
            <div
              class="fator-fill"
              :style="{ width: `${((equipamento.abundancia || 0) / 3) * 100}%` }"
            ></div>
          </div>
        </div>
        <div class="fator-item" :title="`Custo de Indisponibilidade: ${equipamento.custo_indisponibilidade || 0}`">
          <div class="fator-bar">
            <div
              class="fator-fill"
              :style="{ width: `${((equipamento.custo_indisponibilidade || 0) / 3) * 100}%` }"
            ></div>
          </div>
        </div>
        <div class="fator-item" :title="`Criticidade Metrológica: ${equipamento.criticidade_metrologica || 0}`">
          <div class="fator-bar">
            <div
              class="fator-fill"
              :style="{ width: `${((equipamento.criticidade_metrologica || 0) / 3) * 100}%` }"
            ></div>
          </div>
        </div>
      </div>

      <!-- Status -->
      <div class="status-row">
        <span
          class="status-badge"
          :style="{ background: statusCor }"
        >
          {{ formatStatus(equipamento.status) }}
        </span>
      </div>
    </div>

    <!-- Ações -->
    <div class="card-actions">
      <router-link
        :to="`/equipamentos/${equipamento.id}`"
        class="btn btn-sm btn-secondary"
        title="Ver detalhes"
      >
        <i class="fas fa-eye"></i>
      </router-link>
      <router-link
        :to="`/equipamentos/${equipamento.id}/editar`"
        class="btn btn-sm btn-primary"
        title="Editar"
      >
        <i class="fas fa-edit"></i>
      </router-link>
      <button
        @click="$emit('delete', equipamento.id)"
        class="btn btn-sm btn-danger"
        title="Excluir"
      >
        <i class="fas fa-trash"></i>
      </button>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';
import { useEquipamentosStore } from '../stores/equipamentos';

const props = defineProps({
  equipamento: {
    type: Object,
    required: true,
  },
});

defineEmits(['delete']);

const store = useEquipamentosStore();

const igpCor = computed(() => {
  return store.getClassificacaoCor(props.equipamento.classificacao_igp);
});

const classificacaoCor = computed(() => {
  return store.getClassificacaoCor(props.equipamento.classificacao_igp);
});

const statusCor = computed(() => {
  return store.getStatusCor(props.equipamento.status);
});

const formatClassificacao = (classif) => {
  const labels = {
    'alta': 'ALTA',
    'media': 'MÉDIA',
    'baixa': 'BAIXA',
  };
  return labels[classif] || classif?.toUpperCase();
};

const formatStatus = (status) => {
  const labels = {
    'ativo': 'Ativo',
    'fora_uso': 'Fora de Uso',
    'condenado': 'Condenado',
    'reserva': 'Reserva',
  };
  return labels[status] || status;
};
</script>

<style scoped>
.equipamento-card {
  background: white;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
  transition: transform 0.2s, box-shadow 0.2s;
  display: flex;
  flex-direction: column;
}

.equipamento-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.card-image {
  position: relative;
  width: 100%;
  height: 180px;
  background: #f3f4f6;
  overflow: hidden;
}

.card-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.no-image {
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #9ca3af;
}

.no-image i {
  font-size: 48px;
}

.igp-badge {
  position: absolute;
  top: 12px;
  right: 12px;
  background: #3b82f6;
  color: white;
  padding: 8px 12px;
  border-radius: 6px;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 2px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
}

.igp-label {
  font-size: 10px;
  font-weight: 600;
  letter-spacing: 0.5px;
}

.igp-value {
  font-size: 20px;
  font-weight: 700;
}

.card-content {
  padding: 16px;
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.card-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  gap: 8px;
}

.card-title {
  font-size: 16px;
  font-weight: 600;
  color: #1f2937;
  margin: 0;
  line-height: 1.3;
}

.classe-badge {
  background: #e5e7eb;
  color: #374151;
  padding: 4px 8px;
  border-radius: 4px;
  font-size: 11px;
  font-weight: 600;
  flex-shrink: 0;
}

.card-info {
  display: flex;
  flex-direction: column;
  gap: 6px;
}

.info-row {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 13px;
  color: #6b7280;
}

.info-row i {
  width: 16px;
  color: #9ca3af;
}

.classificacao-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding-top: 8px;
  border-top: 1px solid #e5e7eb;
}

.classificacao-label {
  font-size: 12px;
  font-weight: 500;
  color: #6b7280;
}

.classificacao-badge {
  padding: 4px 12px;
  border-radius: 12px;
  font-size: 11px;
  font-weight: 700;
  letter-spacing: 0.5px;
}

.fatores-igp {
  display: flex;
  flex-direction: column;
  gap: 4px;
}

.fator-item {
  cursor: help;
}

.fator-bar {
  height: 4px;
  background: #e5e7eb;
  border-radius: 2px;
  overflow: hidden;
}

.fator-fill {
  height: 100%;
  background: linear-gradient(90deg, #10b981, #f59e0b, #ef4444);
  transition: width 0.3s;
}

.status-row {
  display: flex;
  justify-content: center;
}

.status-badge {
  padding: 4px 12px;
  border-radius: 12px;
  font-size: 11px;
  font-weight: 600;
  color: white;
}

.card-actions {
  display: flex;
  gap: 8px;
  padding: 12px 16px;
  border-top: 1px solid #e5e7eb;
  background: #f9fafb;
}

.btn {
  padding: 6px 12px;
  border: none;
  border-radius: 4px;
  font-size: 13px;
  cursor: pointer;
  transition: all 0.2s;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  text-decoration: none;
  flex: 1;
}

.btn-sm {
  padding: 6px 10px;
}

.btn-primary {
  background: #3b82f6;
  color: white;
}

.btn-primary:hover {
  background: #2563eb;
}

.btn-secondary {
  background: #6b7280;
  color: white;
}

.btn-secondary:hover {
  background: #4b5563;
}

.btn-danger {
  background: #ef4444;
  color: white;
}

.btn-danger:hover {
  background: #dc2626;
}
</style>
