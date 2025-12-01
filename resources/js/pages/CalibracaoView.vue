<template>
  <div class="page-container">
    <div v-if="loading" class="loading-state">
      <i class="fas fa-spinner fa-spin"></i>
      <p>Carregando...</p>
    </div>

    <div v-else-if="error" class="error-state">
      <i class="fas fa-exclamation-circle"></i>
      <p>{{ error }}</p>
      <button @click="router.push('/vue/calibracoes')" class="btn-primary">
        Voltar para Lista
      </button>
    </div>

    <div v-else>
      <div class="page-header">
        <div>
          <h1>
            <i class="fas fa-certificate"></i>
            Detalhes da Calibração
          </h1>
          <p class="subtitle">Certificado: {{ calibracao.numero_certificado }}</p>
        </div>
        <div class="header-actions">
          <button @click="router.push(`/vue/calibracoes/${calibracao.id}/editar`)" class="btn-primary">
            <i class="fas fa-edit"></i>
            Editar
          </button>
          <button @click="router.push('/vue/calibracoes')" class="btn-secondary">
            <i class="fas fa-arrow-left"></i>
            Voltar
          </button>
        </div>
      </div>

      <div class="content-grid">
        <!-- Informações Principais -->
        <div class="info-card">
          <h2><i class="fas fa-info-circle"></i> Informações Principais</h2>
          <div class="info-grid">
            <div class="info-item">
              <label>Equipamento</label>
              <p>{{ calibracao.equipamento?.tipo || '-' }}</p>
              <small v-if="calibracao.equipamento">
                Patrimônio: {{ calibracao.equipamento.num_patrimonio }}
              </small>
            </div>

            <div class="info-item">
              <label>Laboratório</label>
              <p>{{ calibracao.laboratorio?.nome || '-' }}</p>
              <small v-if="calibracao.laboratorio?.acreditado">
                <i class="fas fa-check-circle text-success"></i> Acreditado
              </small>
            </div>

            <div class="info-item">
              <label>Número do Certificado</label>
              <p class="highlight">{{ calibracao.numero_certificado }}</p>
            </div>

            <div class="info-item">
              <label>Resultado</label>
              <p>
                <span 
                  class="badge" 
                  :style="{ backgroundColor: getResultadoCor(calibracao.resultado) }"
                >
                  {{ getResultadoLabel(calibracao.resultado) }}
                </span>
              </p>
            </div>

            <div class="info-item">
              <label>Data da Calibração</label>
              <p>{{ formatDate(calibracao.data_calibracao) }}</p>
            </div>

            <div class="info-item">
              <label>Próxima Calibração</label>
              <p>{{ calibracao.data_proxima ? formatDate(calibracao.data_proxima) : 'Não definida' }}</p>
            </div>

            <div class="info-item">
              <label>Custo</label>
              <p>{{ calibracao.custo ? formatCurrency(calibracao.custo) : 'Não informado' }}</p>
            </div>

            <div class="info-item full-width" v-if="calibracao.observacoes">
              <label>Observações</label>
              <p class="observations">{{ calibracao.observacoes }}</p>
            </div>
          </div>
        </div>

        <!-- Upload de Certificado -->
        <div class="info-card">
          <h2><i class="fas fa-file-pdf"></i> Certificado</h2>
          
          <div v-if="calibracao.certificado_path" class="certificate-info">
            <div class="file-display">
              <i class="fas fa-file-pdf file-icon"></i>
              <div>
                <p class="file-name">Certificado anexado</p>
                <small>{{ calibracao.certificado_path }}</small>
              </div>
            </div>
            <a :href="`/storage/${calibracao.certificado_path}`" target="_blank" class="btn-secondary">
              <i class="fas fa-download"></i>
              Baixar
            </a>
          </div>

          <div v-else class="no-certificate">
            <i class="fas fa-file-pdf"></i>
            <p>Nenhum certificado anexado</p>
          </div>

          <div class="upload-section">
            <label for="certificate" class="upload-label">
              {{ calibracao.certificado_path ? 'Substituir certificado' : 'Anexar certificado' }}
            </label>
            <input 
              type="file" 
              id="certificate" 
              @change="handleFileUpload" 
              accept=".pdf"
              :disabled="uploading"
            />
            <p v-if="uploading" class="upload-status">
              <i class="fas fa-spinner fa-spin"></i> Enviando...
            </p>
          </div>
        </div>
      </div>

      <!-- Informações do Sistema -->
      <div class="info-card metadata">
        <h3><i class="fas fa-clock"></i> Informações do Sistema</h3>
        <div class="metadata-grid">
          <div>
            <label>Criado em</label>
            <p>{{ formatDateTime(calibracao.created_at) }}</p>
          </div>
          <div>
            <label>Última atualização</label>
            <p>{{ formatDateTime(calibracao.updated_at) }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { useCalibracoesStore } from '../stores/calibracoes'

const router = useRouter()
const route = useRoute()
const calibracoesStore = useCalibracoesStore()

const loading = ref(true)
const uploading = ref(false)

const calibracao = computed(() => calibracoesStore.calibracao)
const error = computed(() => calibracoesStore.error)

onMounted(async () => {
  try {
    await calibracoesStore.fetchCalibracao(route.params.id)
  } catch (err) {
    console.error('Erro ao carregar calibração:', err)
  } finally {
    loading.value = false
  }
})

const handleFileUpload = async (event) => {
  const file = event.target.files[0]
  if (!file) return

  if (file.type !== 'application/pdf') {
    alert('Por favor, selecione um arquivo PDF')
    return
  }

  if (file.size > 10 * 1024 * 1024) {
    alert('O arquivo deve ter no máximo 10MB')
    return
  }

  uploading.value = true

  try {
    await calibracoesStore.uploadCertificado(route.params.id, file)
    alert('Certificado enviado com sucesso!')
    await calibracoesStore.fetchCalibracao(route.params.id)
  } catch (err) {
    console.error('Erro ao enviar certificado:', err)
    alert(err.message || 'Erro ao enviar certificado')
  } finally {
    uploading.value = false
    event.target.value = ''
  }
}

const getResultadoCor = (resultado) => {
  return calibracoesStore.getResultadoCor(resultado)
}

const getResultadoLabel = (resultado) => {
  const labels = {
    conforme: 'Conforme',
    nao_conforme: 'Não Conforme',
    condicional: 'Condicional'
  }
  return labels[resultado] || resultado
}

const formatDate = (dateString) => {
  if (!dateString) return '-'
  return new Date(dateString).toLocaleDateString('pt-BR')
}

const formatDateTime = (dateString) => {
  if (!dateString) return '-'
  return new Date(dateString).toLocaleString('pt-BR')
}

const formatCurrency = (value) => {
  return new Intl.NumberFormat('pt-BR', {
    style: 'currency',
    currency: 'BRL'
  }).format(value)
}
</script>

<style scoped>
.page-container {
  padding: 24px;
}

.loading-state,
.error-state {
  text-align: center;
  padding: 48px;
  color: #6b7280;
}

.loading-state i,
.error-state i {
  font-size: 48px;
  margin-bottom: 16px;
}

.error-state i {
  color: #ef4444;
}

.page-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: 24px;
}

.page-header h1 {
  font-size: 28px;
  font-weight: 700;
  color: #1f2937;
  display: flex;
  align-items: center;
  gap: 12px;
  margin-bottom: 4px;
}

.page-header h1 i {
  color: #3b82f6;
}

.subtitle {
  color: #6b7280;
  font-size: 14px;
}

.header-actions {
  display: flex;
  gap: 12px;
}

.content-grid {
  display: grid;
  grid-template-columns: 2fr 1fr;
  gap: 24px;
  margin-bottom: 24px;
}

.info-card {
  background: white;
  border-radius: 8px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
  padding: 24px;
}

.info-card h2 {
  font-size: 18px;
  font-weight: 600;
  color: #1f2937;
  margin-bottom: 20px;
  display: flex;
  align-items: center;
  gap: 8px;
}

.info-card h2 i {
  color: #3b82f6;
}

.info-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 20px;
}

.info-item {
  display: flex;
  flex-direction: column;
}

.info-item.full-width {
  grid-column: 1 / -1;
}

.info-item label {
  font-size: 12px;
  font-weight: 500;
  color: #6b7280;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  margin-bottom: 4px;
}

.info-item p {
  font-size: 16px;
  color: #1f2937;
  font-weight: 500;
}

.info-item small {
  font-size: 13px;
  color: #6b7280;
  margin-top: 2px;
}

.highlight {
  color: #3b82f6 !important;
}

.observations {
  white-space: pre-wrap;
  line-height: 1.6;
}

.badge {
  display: inline-block;
  padding: 4px 12px;
  border-radius: 12px;
  color: white;
  font-size: 14px;
  font-weight: 500;
}

.text-success {
  color: #10b981;
}

.certificate-info {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 16px;
  background: #f9fafb;
  border-radius: 6px;
  margin-bottom: 20px;
}

.file-display {
  display: flex;
  align-items: center;
  gap: 12px;
}

.file-icon {
  font-size: 32px;
  color: #ef4444;
}

.file-name {
  font-weight: 500;
  color: #1f2937;
  margin-bottom: 2px;
}

.no-certificate {
  text-align: center;
  padding: 32px;
  color: #9ca3af;
}

.no-certificate i {
  font-size: 48px;
  margin-bottom: 12px;
  opacity: 0.5;
}

.upload-section {
  margin-top: 16px;
}

.upload-label {
  display: block;
  font-weight: 500;
  color: #374151;
  margin-bottom: 8px;
}

.upload-section input[type="file"] {
  display: block;
  width: 100%;
  padding: 10px;
  border: 1px dashed #d1d5db;
  border-radius: 6px;
  cursor: pointer;
}

.upload-status {
  margin-top: 8px;
  color: #3b82f6;
  font-size: 14px;
}

.metadata {
  grid-column: 1 / -1;
}

.metadata h3 {
  font-size: 16px;
  font-weight: 600;
  color: #1f2937;
  margin-bottom: 16px;
  display: flex;
  align-items: center;
  gap: 8px;
}

.metadata-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 16px;
}

.metadata-grid label {
  display: block;
  font-size: 12px;
  font-weight: 500;
  color: #6b7280;
  text-transform: uppercase;
  margin-bottom: 4px;
}

.metadata-grid p {
  font-size: 14px;
  color: #1f2937;
}

.btn-primary,
.btn-secondary {
  padding: 10px 20px;
  border-radius: 6px;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.2s;
  border: none;
  display: inline-flex;
  align-items: center;
  gap: 8px;
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
  background: #f3f4f6;
  color: #374151;
}

.btn-secondary:hover {
  background: #e5e7eb;
}

@media (max-width: 768px) {
  .page-header {
    flex-direction: column;
    gap: 16px;
  }

  .content-grid {
    grid-template-columns: 1fr;
  }

  .info-grid {
    grid-template-columns: 1fr;
  }

  .metadata-grid {
    grid-template-columns: 1fr;
  }
}
</style>
