<template>
  <div class="equipamento-view-page">
    <div class="view-header">
      <router-link to="/equipamentos" class="back-link">
        <i class="fas fa-arrow-left"></i> Voltar
      </router-link>
      <div class="header-actions">
        <router-link
          :to="`/equipamentos/${id}/editar`"
          class="btn btn-primary"
        >
          <i class="fas fa-edit"></i> Editar
        </router-link>
        <button @click="handleRecalcularIGP" class="btn btn-secondary">
          <i class="fas fa-calculator"></i> Recalcular IGP
        </button>
      </div>
    </div>

    <div v-if="store.loading" class="loading-container">
      <div class="spinner"></div>
      <p>Carregando equipamento...</p>
    </div>

    <div v-if="store.hasError" class="alert alert-danger">
      {{ store.error }}
      <button @click="store.clearError()" class="btn-close">&times;</button>
    </div>

    <div v-if="equipamento && !store.loading" class="content-grid">
      <!-- Card Principal -->
      <div class="main-card">
        <div class="equipment-header">
          <div class="image-container">
            <img
              v-if="equipamento.foto"
              :src="`/storage/${equipamento.foto}`"
              :alt="equipamento.tipo"
            />
            <div v-else class="no-image">
              <i class="fas fa-tools"></i>
            </div>
            <input
              ref="fotoInput"
              type="file"
              accept="image/*"
              style="display: none"
              @change="handleFotoUpload"
            />
            <button @click="$refs.fotoInput.click()" class="upload-btn">
              <i class="fas fa-camera"></i> Alterar Foto
            </button>
          </div>

          <div class="equipment-info">
            <div class="title-row">
              <h1>{{ equipamento.tipo }}</h1>
              <span class="classe-badge">{{ equipamento.classe }}</span>
            </div>
            
            <div class="info-grid">
              <div class="info-item">
                <span class="label">Fabricante:</span>
                <span class="value">{{ equipamento.fabricante || 'N/A' }}</span>
              </div>
              <div class="info-item">
                <span class="label">Modelo:</span>
                <span class="value">{{ equipamento.modelo || 'N/A' }}</span>
              </div>
              <div class="info-item">
                <span class="label">Nº Série:</span>
                <span class="value">{{ equipamento.numero_serie || 'N/A' }}</span>
              </div>
              <div class="info-item">
                <span class="label">Código Interno:</span>
                <span class="value">{{ equipamento.codigo_interno || 'N/A' }}</span>
              </div>
              <div class="info-item">
                <span class="label">Patrimônio:</span>
                <span class="value">{{ equipamento.patrimonio || 'N/A' }}</span>
              </div>
              <div class="info-item">
                <span class="label">Status:</span>
                <span
                  class="status-badge"
                  :style="{ background: store.getStatusCor(equipamento.status) }"
                >
                  {{ formatStatus(equipamento.status) }}
                </span>
              </div>
            </div>
          </div>
        </div>

        <!-- Matriz IGP -->
        <div class="igp-section">
          <h2>Matriz IGP</h2>
          <div class="igp-overview">
            <div class="igp-score">
              <span class="igp-label">IGP Total</span>
              <span class="igp-value">{{ equipamento.igp }}</span>
            </div>
            <div
              class="igp-classification"
              :style="{ background: store.getClassificacaoCor(equipamento.classificacao_igp) }"
            >
              {{ formatClassificacao(equipamento.classificacao_igp) }}
            </div>
          </div>

          <div class="fatores-list">
            <div class="fator-row">
              <span class="fator-name">Frequência de Uso</span>
              <div class="fator-bar-container">
                <div
                  class="fator-bar"
                  :style="{ width: `${(equipamento.frequencia_uso / 3) * 100}%` }"
                ></div>
              </div>
              <span class="fator-value">{{ equipamento.frequencia_uso }}/3</span>
            </div>

            <div class="fator-row">
              <span class="fator-name">Necessidade Crítica</span>
              <div class="fator-bar-container">
                <div
                  class="fator-bar"
                  :style="{ width: `${(equipamento.necessidade_critica / 3) * 100}%` }"
                ></div>
              </div>
              <span class="fator-value">{{ equipamento.necessidade_critica }}/3</span>
            </div>

            <div class="fator-row">
              <span class="fator-name">Abundância</span>
              <div class="fator-bar-container">
                <div
                  class="fator-bar"
                  :style="{ width: `${(equipamento.abundancia / 3) * 100}%` }"
                ></div>
              </div>
              <span class="fator-value">{{ equipamento.abundancia }}/3</span>
            </div>

            <div class="fator-row">
              <span class="fator-name">Custo de Indisponibilidade</span>
              <div class="fator-bar-container">
                <div
                  class="fator-bar"
                  :style="{ width: `${(equipamento.custo_indisponibilidade / 3) * 100}%` }"
                ></div>
              </div>
              <span class="fator-value">{{ equipamento.custo_indisponibilidade }}/3</span>
            </div>

            <div class="fator-row">
              <span class="fator-name">Criticidade Metrológica</span>
              <div class="fator-bar-container">
                <div
                  class="fator-bar"
                  :style="{ width: `${(equipamento.criticidade_metrologica / 3) * 100}%` }"
                ></div>
              </div>
              <span class="fator-value">{{ equipamento.criticidade_metrologica }}/3</span>
            </div>
          </div>
        </div>

        <!-- Especificações Técnicas -->
        <div class="specs-section" v-if="hasSpecs">
          <h2>Especificações Técnicas</h2>
          <div class="specs-grid">
            <div v-if="equipamento.faixa_nominal" class="spec-item">
              <span class="label">Faixa Nominal:</span>
              <span class="value">{{ equipamento.faixa_nominal }}</span>
            </div>
            <div v-if="equipamento.resolucao" class="spec-item">
              <span class="label">Resolução:</span>
              <span class="value">{{ equipamento.resolucao }}</span>
            </div>
            <div v-if="equipamento.incerteza_nominal" class="spec-item">
              <span class="label">Incerteza Nominal:</span>
              <span class="value">{{ equipamento.incerteza_nominal }}</span>
            </div>
            <div v-if="equipamento.altura_mm" class="spec-item">
              <span class="label">Dimensões (A×L×C):</span>
              <span class="value">
                {{ equipamento.altura_mm }}×{{ equipamento.largura_mm }}×{{ equipamento.comprimento_mm }} mm
              </span>
            </div>
            <div v-if="equipamento.tensao_v" class="spec-item">
              <span class="label">Tensão:</span>
              <span class="value">{{ equipamento.tensao_v }} V</span>
            </div>
            <div v-if="equipamento.potencia_w" class="spec-item">
              <span class="label">Potência:</span>
              <span class="value">{{ equipamento.potencia_w }} W</span>
            </div>
          </div>
        </div>

        <!-- Comentários -->
        <div v-if="equipamento.comentarios" class="comments-section">
          <h2>Comentários</h2>
          <p>{{ equipamento.comentarios }}</p>
        </div>
      </div>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Calibração -->
        <div class="info-card">
          <h3>Calibração</h3>
          <div class="card-content">
            <div class="info-item">
              <span class="label">Periodicidade:</span>
              <span class="value">{{ equipamento.periodicidade_meses || 12 }} meses</span>
            </div>
            <div class="info-item" v-if="equipamento.data_ultima_calibracao">
              <span class="label">Última Calibração:</span>
              <span class="value">{{ formatDate(equipamento.data_ultima_calibracao) }}</span>
            </div>
            <div class="info-item" v-if="equipamento.local_calibracao">
              <span class="label">Local:</span>
              <span class="value">{{ formatLocal(equipamento.local_calibracao) }}</span>
            </div>
            <div class="info-item" v-if="equipamento.certificado_status">
              <span class="label">Status Certificado:</span>
              <span
                class="badge"
                :class="`badge-${equipamento.certificado_status}`"
              >
                {{ formatCertificadoStatus(equipamento.certificado_status) }}
              </span>
            </div>
          </div>
        </div>

        <!-- Localização -->
        <div class="info-card" v-if="equipamento.localizacao">
          <h3>Localização</h3>
          <div class="card-content">
            <p>{{ equipamento.localizacao }}</p>
          </div>
        </div>

        <!-- Arquivos -->
        <div class="info-card">
          <h3>Documentos</h3>
          <div class="card-content">
            <div class="file-item">
              <i class="fas fa-file-pdf"></i>
              <span>Manual</span>
              <a
                v-if="equipamento.manual_pdf"
                :href="`/storage/${equipamento.manual_pdf}`"
                target="_blank"
                class="file-link"
              >
                Ver
              </a>
              <button v-else @click="$refs.manualInput.click()" class="file-upload-btn">
                Upload
              </button>
              <input
                ref="manualInput"
                type="file"
                accept="application/pdf"
                style="display: none"
                @change="(e) => handlePdfUpload(e, 'manual')"
              />
            </div>

            <div class="file-item">
              <i class="fas fa-file-pdf"></i>
              <span>Certificado</span>
              <a
                v-if="equipamento.certificado_pdf"
                :href="`/storage/${equipamento.certificado_pdf}`"
                target="_blank"
                class="file-link"
              >
                Ver
              </a>
              <button v-else @click="$refs.certificadoInput.click()" class="file-upload-btn">
                Upload
              </button>
              <input
                ref="certificadoInput"
                type="file"
                accept="application/pdf"
                style="display: none"
                @change="(e) => handlePdfUpload(e, 'certificado')"
              />
            </div>
          </div>
        </div>

        <!-- Calibrações (relacionadas) -->
        <div class="info-card" v-if="equipamento.calibracoes?.length > 0">
          <h3>Histórico de Calibrações</h3>
          <div class="card-content">
            <div
              v-for="calibracao in equipamento.calibracoes.slice(0, 5)"
              :key="calibracao.id"
              class="calibracao-item"
            >
              <span class="calibracao-date">{{ formatDate(calibracao.data_calibracao) }}</span>
              <span class="calibracao-lab">{{ calibracao.laboratorio?.nome || 'N/A' }}</span>
            </div>
            <p v-if="equipamento.calibracoes.length > 5" class="more-info">
              + {{ equipamento.calibracoes.length - 5 }} mais
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { useEquipamentosStore } from '../stores/equipamentos';

const props = defineProps({
  id: {
    type: String,
    required: true,
  },
});

const router = useRouter();
const store = useEquipamentosStore();

const equipamento = computed(() => store.currentEquipamento);

const hasSpecs = computed(() => {
  return equipamento.value && (
    equipamento.value.faixa_nominal ||
    equipamento.value.resolucao ||
    equipamento.value.incerteza_nominal ||
    equipamento.value.altura_mm ||
    equipamento.value.tensao_v ||
    equipamento.value.potencia_w
  );
});

onMounted(async () => {
  try {
    await store.fetchEquipamento(props.id);
  } catch (error) {
    console.error('Erro ao carregar equipamento:', error);
    router.push('/equipamentos');
  }
});

const handleRecalcularIGP = async () => {
  try {
    await store.recalcularIGP(props.id);
    alert('IGP recalculado com sucesso!');
  } catch (error) {
    console.error('Erro ao recalcular IGP:', error);
  }
};

const handleFotoUpload = async (event) => {
  const file = event.target.files[0];
  if (file) {
    try {
      await store.uploadFoto(props.id, file);
      alert('Foto atualizada com sucesso!');
    } catch (error) {
      alert('Erro ao enviar foto: ' + error.message);
    }
  }
};

const handlePdfUpload = async (event, tipo) => {
  const file = event.target.files[0];
  if (file) {
    try {
      await store.uploadPdf(props.id, file, tipo);
      alert('PDF enviado com sucesso!');
    } catch (error) {
      alert('Erro ao enviar PDF: ' + error.message);
    }
  }
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

const formatClassificacao = (classificacao) => {
  const labels = {
    'alta': 'ALTA PRIORIDADE',
    'media': 'MÉDIA PRIORIDADE',
    'baixa': 'BAIXA PRIORIDADE',
  };
  return labels[classificacao] || classificacao?.toUpperCase();
};

const formatLocal = (local) => {
  const labels = {
    'interno': 'Interno',
    'externo': 'Externo',
  };
  return labels[local] || local;
};

const formatCertificadoStatus = (status) => {
  const labels = {
    'valido': 'Válido',
    'vencido': 'Vencido',
    'pendente': 'Pendente',
  };
  return labels[status] || status;
};

const formatDate = (date) => {
  if (!date) return 'N/A';
  return new Date(date).toLocaleDateString('pt-BR');
};
</script>

<style scoped>
.equipamento-view-page {
  padding: 24px;
  max-width: 1400px;
  margin: 0 auto;
}

.view-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 24px;
}

.back-link {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  color: #6b7280;
  text-decoration: none;
  font-size: 14px;
  transition: color 0.2s;
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
  grid-template-columns: 1fr 350px;
  gap: 24px;
}

.main-card,
.info-card {
  background: white;
  border-radius: 8px;
  padding: 24px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.equipment-header {
  display: grid;
  grid-template-columns: 300px 1fr;
  gap: 24px;
  margin-bottom: 32px;
}

.image-container {
  position: relative;
}

.image-container img {
  width: 100%;
  height: 300px;
  object-fit: cover;
  border-radius: 8px;
}

.no-image {
  width: 100%;
  height: 300px;
  background: #f3f4f6;
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #9ca3af;
}

.no-image i {
  font-size: 64px;
}

.upload-btn {
  position: absolute;
  bottom: 12px;
  left: 12px;
  right: 12px;
  padding: 8px;
  background: rgba(0, 0, 0, 0.7);
  color: white;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-size: 13px;
  transition: background 0.2s;
}

.upload-btn:hover {
  background: rgba(0, 0, 0, 0.85);
}

.title-row {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-bottom: 20px;
}

.title-row h1 {
  font-size: 28px;
  font-weight: 700;
  color: #1f2937;
  margin: 0;
}

.classe-badge {
  background: #3b82f6;
  color: white;
  padding: 6px 12px;
  border-radius: 6px;
  font-size: 14px;
  font-weight: 600;
}

.info-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 16px;
}

.info-item {
  display: flex;
  flex-direction: column;
  gap: 4px;
}

.info-item .label {
  font-size: 13px;
  font-weight: 500;
  color: #6b7280;
}

.info-item .value {
  font-size: 15px;
  color: #1f2937;
}

.status-badge {
  padding: 4px 12px;
  border-radius: 12px;
  font-size: 12px;
  font-weight: 600;
  color: white;
  display: inline-block;
  width: fit-content;
}

.igp-section,
.specs-section,
.comments-section {
  margin-top: 32px;
  padding-top: 32px;
  border-top: 1px solid #e5e7eb;
}

.igp-section h2,
.specs-section h2,
.comments-section h2 {
  font-size: 18px;
  font-weight: 600;
  color: #1f2937;
  margin: 0 0 20px 0;
}

.igp-overview {
  display: flex;
  align-items: center;
  gap: 20px;
  margin-bottom: 24px;
}

.igp-score {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 20px 30px;
  background: #f3f4f6;
  border-radius: 12px;
}

.igp-label {
  font-size: 13px;
  font-weight: 600;
  color: #6b7280;
  letter-spacing: 0.5px;
}

.igp-value {
  font-size: 48px;
  font-weight: 700;
  color: #1f2937;
}

.igp-classification {
  padding: 16px 32px;
  border-radius: 12px;
  color: white;
  font-size: 20px;
  font-weight: 700;
  letter-spacing: 1px;
}

.fatores-list {
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.fator-row {
  display: grid;
  grid-template-columns: 200px 1fr 60px;
  align-items: center;
  gap: 16px;
}

.fator-name {
  font-size: 14px;
  font-weight: 500;
  color: #374151;
}

.fator-bar-container {
  height: 24px;
  background: #e5e7eb;
  border-radius: 12px;
  overflow: hidden;
}

.fator-bar {
  height: 100%;
  background: linear-gradient(90deg, #10b981, #f59e0b, #ef4444);
  transition: width 0.3s;
}

.fator-value {
  font-size: 14px;
  font-weight: 600;
  color: #1f2937;
  text-align: right;
}

.specs-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 16px;
}

.spec-item {
  display: flex;
  flex-direction: column;
  gap: 4px;
}

.spec-item .label {
  font-size: 13px;
  font-weight: 500;
  color: #6b7280;
}

.spec-item .value {
  font-size: 15px;
  color: #1f2937;
}

.comments-section p {
  color: #4b5563;
  line-height: 1.6;
}

.sidebar {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.info-card h3 {
  font-size: 16px;
  font-weight: 600;
  color: #1f2937;
  margin: 0 0 16px 0;
}

.card-content {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.badge {
  padding: 4px 8px;
  border-radius: 4px;
  font-size: 12px;
  font-weight: 600;
  display: inline-block;
  width: fit-content;
}

.badge-valido {
  background: #d1fae5;
  color: #065f46;
}

.badge-vencido {
  background: #fee2e2;
  color: #991b1b;
}

.badge-pendente {
  background: #fef3c7;
  color: #92400e;
}

.file-item {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 12px;
  background: #f9fafb;
  border-radius: 6px;
}

.file-item i {
  color: #ef4444;
  font-size: 18px;
}

.file-item span {
  flex: 1;
  font-size: 14px;
  color: #374151;
}

.file-link {
  color: #3b82f6;
  text-decoration: none;
  font-size: 13px;
  font-weight: 500;
}

.file-link:hover {
  text-decoration: underline;
}

.file-upload-btn {
  padding: 4px 12px;
  background: #3b82f6;
  color: white;
  border: none;
  border-radius: 4px;
  font-size: 12px;
  cursor: pointer;
  transition: background 0.2s;
}

.file-upload-btn:hover {
  background: #2563eb;
}

.calibracao-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 8px 12px;
  background: #f9fafb;
  border-radius: 6px;
  font-size: 13px;
}

.calibracao-date {
  font-weight: 500;
  color: #1f2937;
}

.calibracao-lab {
  color: #6b7280;
}

.more-info {
  text-align: center;
  color: #6b7280;
  font-size: 13px;
  margin: 0;
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

.loading-container {
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

.alert {
  padding: 12px 16px;
  border-radius: 6px;
  margin-bottom: 20px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.alert-danger {
  background: #fee2e2;
  color: #991b1b;
  border: 1px solid #fecaca;
}

.btn-close {
  background: transparent;
  border: none;
  font-size: 20px;
  cursor: pointer;
  color: inherit;
  padding: 0;
  width: 24px;
  height: 24px;
}

@media (max-width: 1024px) {
  .content-grid {
    grid-template-columns: 1fr;
  }

  .equipment-header {
    grid-template-columns: 1fr;
  }
}
</style>
