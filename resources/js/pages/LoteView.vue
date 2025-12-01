<template>
  <div class="page-container">
    <div v-if="loading" class="loading-state">
      <i class="fas fa-spinner fa-spin"></i>
      <p>Carregando...</p>
    </div>

    <div v-else-if="error" class="error-state">
      <i class="fas fa-exclamation-circle"></i>
      <p>{{ error }}</p>
      <button @click="router.push('/vue/lotes')" class="btn-primary">
        Voltar para Lista
      </button>
    </div>

    <div v-else>
      <div class="page-header">
        <div>
          <h1>
            <i class="fas fa-box"></i>
            Detalhes do Lote
          </h1>
          <p class="subtitle">{{ lote.numero_lote }}</p>
        </div>
        <div class="header-actions">
          <button @click="router.push(`/vue/lotes/${lote.id}/editar`)" class="btn-primary">
            <i class="fas fa-edit"></i>
            Editar
          </button>
          <button @click="router.push('/vue/lotes')" class="btn-secondary">
            <i class="fas fa-arrow-left"></i>
            Voltar
          </button>
        </div>
      </div>

      <div class="content-grid">
        <!-- Informações do Lote -->
        <div class="info-card">
          <h2><i class="fas fa-info-circle"></i> Informações do Lote</h2>
          <div class="info-grid">
            <div class="info-item">
              <label>Número do Lote</label>
              <p class="highlight">{{ lote.numero_lote }}</p>
            </div>

            <div class="info-item">
              <label>Status</label>
              <p>
                <span 
                  class="badge" 
                  :style="{ backgroundColor: getStatusCor(lote.status) }"
                >
                  {{ getStatusLabel(lote.status) }}
                </span>
              </p>
            </div>

            <div class="info-item">
              <label>Laboratório</label>
              <p>{{ lote.laboratorio?.nome || '-' }}</p>
              <small v-if="lote.laboratorio?.acreditado">
                <i class="fas fa-check-circle text-success"></i> Acreditado
              </small>
            </div>

            <div class="info-item">
              <label>Data de Envio</label>
              <p>{{ formatDate(lote.data_envio) }}</p>
            </div>

            <div class="info-item">
              <label>Data de Recebimento</label>
              <p>{{ lote.data_recebimento ? formatDate(lote.data_recebimento) : 'Não recebido' }}</p>
            </div>

            <div class="info-item">
              <label>Total de Equipamentos</label>
              <p>{{ lote.itens?.length || 0 }} item(ns)</p>
            </div>

            <div class="info-item full-width" v-if="lote.observacoes">
              <label>Observações</label>
              <p class="observations">{{ lote.observacoes }}</p>
            </div>
          </div>
        </div>

        <!-- Gerenciar Equipamentos -->
        <div class="info-card">
          <h2><i class="fas fa-cogs"></i> Adicionar Equipamento</h2>
          
          <div class="add-equipment-section">
            <select v-model="selectedEquipamento" class="equipment-select">
              <option value="">Selecione um equipamento</option>
              <option 
                v-for="equipamento in availableEquipamentos" 
                :key="equipamento.id" 
                :value="equipamento.id"
              >
                {{ equipamento.tipo }} - {{ equipamento.num_patrimonio }}
              </option>
            </select>
            <button 
              @click="handleAddEquipamento" 
              class="btn-add"
              :disabled="!selectedEquipamento || adding"
            >
              <i class="fas" :class="adding ? 'fa-spinner fa-spin' : 'fa-plus'"></i>
              Adicionar
            </button>
          </div>
        </div>
      </div>

      <!-- Equipamentos no Lote -->
      <div class="info-card">
        <h2><i class="fas fa-list"></i> Equipamentos no Lote</h2>
        
        <div v-if="!lote.itens || lote.itens.length === 0" class="no-items">
          <i class="fas fa-box-open"></i>
          <p>Nenhum equipamento adicionado ao lote</p>
        </div>

        <div v-else class="equipment-list">
          <div v-for="item in lote.itens" :key="item.id" class="equipment-item">
            <div class="equipment-info">
              <i class="fas fa-cog"></i>
              <div>
                <p class="equipment-name">{{ item.equipamento?.tipo || 'Equipamento' }}</p>
                <small>Patrimônio: {{ item.equipamento?.num_patrimonio }}</small>
              </div>
            </div>
            <button 
              @click="handleRemoveEquipamento(item.id)" 
              class="btn-remove"
              :disabled="removing === item.id"
            >
              <i class="fas" :class="removing === item.id ? 'fa-spinner fa-spin' : 'fa-trash'"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Informações do Sistema -->
      <div class="info-card metadata">
        <h3><i class="fas fa-clock"></i> Informações do Sistema</h3>
        <div class="metadata-grid">
          <div>
            <label>Criado em</label>
            <p>{{ formatDateTime(lote.created_at) }}</p>
          </div>
          <div>
            <label>Última atualização</label>
            <p>{{ formatDateTime(lote.updated_at) }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { useLotesStore } from '../stores/lotes'
import { useEquipamentosStore } from '../stores/equipamentos'

const router = useRouter()
const route = useRoute()
const lotesStore = useLotesStore()
const equipamentosStore = useEquipamentosStore()

const loading = ref(true)
const adding = ref(false)
const removing = ref(null)
const selectedEquipamento = ref('')

const lote = computed(() => lotesStore.lote)
const error = computed(() => lotesStore.error)
const equipamentos = computed(() => equipamentosStore.equipamentos)

const availableEquipamentos = computed(() => {
  const idsNoLote = lote.value.itens?.map(item => item.equipamento_id) || []
  return equipamentos.value.filter(eq => !idsNoLote.includes(eq.id))
})

onMounted(async () => {
  try {
    await lotesStore.fetchLote(route.params.id)
    await equipamentosStore.fetchEquipamentos(1, 1000)
  } catch (err) {
    console.error('Erro ao carregar lote:', err)
  } finally {
    loading.value = false
  }
})

const handleAddEquipamento = async () => {
  if (!selectedEquipamento.value) return
  
  adding.value = true
  try {
    await lotesStore.addEquipamento(route.params.id, selectedEquipamento.value)
    alert('Equipamento adicionado com sucesso!')
    selectedEquipamento.value = ''
    await lotesStore.fetchLote(route.params.id)
  } catch (err) {
    console.error('Erro ao adicionar equipamento:', err)
    alert(err.message || 'Erro ao adicionar equipamento')
  } finally {
    adding.value = false
  }
}

const handleRemoveEquipamento = async (itemId) => {
  if (!confirm('Remover equipamento do lote?')) return
  
  removing.value = itemId
  try {
    await lotesStore.removeEquipamento(route.params.id, itemId)
    alert('Equipamento removido com sucesso!')
    await lotesStore.fetchLote(route.params.id)
  } catch (err) {
    console.error('Erro ao remover equipamento:', err)
    alert(err.message || 'Erro ao remover equipamento')
  } finally {
    removing.value = null
  }
}

const getStatusCor = (status) => {
  return lotesStore.getStatusCor(status)
}

const getStatusLabel = (status) => {
  const labels = {
    preparacao: 'Em Preparação',
    enviado: 'Enviado',
    recebido: 'Recebido',
    concluido: 'Concluído',
    cancelado: 'Cancelado'
  }
  return labels[status] || status
}

const formatDate = (dateString) => {
  if (!dateString) return '-'
  return new Date(dateString).toLocaleDateString('pt-BR')
}

const formatDateTime = (dateString) => {
  if (!dateString) return '-'
  return new Date(dateString).toLocaleString('pt-BR')
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

.info-card h2,
.info-card h3 {
  font-size: 18px;
  font-weight: 600;
  color: #1f2937;
  margin-bottom: 20px;
  display: flex;
  align-items: center;
  gap: 8px;
}

.info-card h2 i,
.info-card h3 i {
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

.add-equipment-section {
  display: flex;
  gap: 12px;
}

.equipment-select {
  flex: 1;
  padding: 10px 12px;
  border: 1px solid #d1d5db;
  border-radius: 6px;
  font-size: 14px;
}

.btn-add {
  padding: 10px 20px;
  background: #10b981;
  color: white;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  transition: background 0.2s;
  display: flex;
  align-items: center;
  gap: 8px;
  font-weight: 500;
}

.btn-add:hover:not(:disabled) {
  background: #059669;
}

.btn-add:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.no-items {
  text-align: center;
  padding: 32px;
  color: #9ca3af;
}

.no-items i {
  font-size: 48px;
  margin-bottom: 12px;
  opacity: 0.5;
}

.equipment-list {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.equipment-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 12px;
  background: #f9fafb;
  border-radius: 6px;
  border: 1px solid #e5e7eb;
}

.equipment-info {
  display: flex;
  align-items: center;
  gap: 12px;
}

.equipment-info i {
  font-size: 24px;
  color: #9ca3af;
}

.equipment-name {
  font-weight: 500;
  color: #1f2937;
  margin-bottom: 2px;
}

.equipment-info small {
  font-size: 13px;
  color: #6b7280;
}

.btn-remove {
  padding: 8px 12px;
  background: #fee2e2;
  color: #dc2626;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  transition: background 0.2s;
}

.btn-remove:hover:not(:disabled) {
  background: #fecaca;
}

.btn-remove:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.metadata {
  grid-column: 1 / -1;
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
