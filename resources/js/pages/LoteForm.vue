<template>
  <div class="lote-form-page">
    <div class="form-header">
      <router-link to="/vue/lotes" class="back-link">
        <i class="fas fa-arrow-left"></i> Voltar
      </router-link>
      <h1>{{ isEdit ? 'Editar Lote' : 'Novo Lote' }}</h1>
    </div>

    <div v-if="loading" class="loading-container">
      <div class="spinner"></div>
    </div>

    <div v-if="error" class="alert alert-danger">
      {{ error }}
      <button @click="error = null" class="btn-close">&times;</button>
    </div>

    <form v-if="!loading" @submit.prevent="handleSubmit" class="form-container">
      <!-- Informações do Lote -->
      <div class="form-section">
        <h2>Informações do Lote</h2>
        <div class="form-grid">
          <div class="form-group">
            <label>Descrição *</label>
            <input v-model="form.descricao" type="text" required class="form-control" 
                   placeholder="Descrição do lote" />
          </div>

          <div class="form-group">
            <label>Data de Envio</label>
            <input v-model="form.data_envio" type="date" class="form-control" />
          </div>

          <div class="form-group">
            <label>Data Prevista de Retorno</label>
            <input v-model="form.data_retorno_prevista" type="date" class="form-control" />
          </div>

          <div class="form-group">
            <label>Data de Retorno Efetivo</label>
            <input v-model="form.data_retorno_efetivo" type="date" class="form-control" />
          </div>

          <div class="form-group">
            <label>Status</label>
            <select v-model="form.status" class="form-control">
              <option value="preparacao">Preparação</option>
              <option value="enviado">Enviado</option>
              <option value="em_calibracao">Em Calibração</option>
              <option value="retornado">Retornado</option>
              <option value="cancelado">Cancelado</option>
            </select>
          </div>
        </div>
      </div>

      <!-- Relacionamentos -->
      <div class="form-section">
        <h2>Relacionamentos</h2>
        <div class="form-grid">
          <div class="form-group">
            <label>Laboratório de Destino</label>
            <select v-model="form.laboratorio_destino_id" class="form-control">
              <option value="">Nenhum</option>
              <option v-for="lab in laboratorios" :key="lab.id" :value="lab.id">
                {{ lab.nome }}
              </option>
            </select>
          </div>

          <div class="form-group">
            <label>Contrato de Serviço</label>
            <select v-model="form.contrato_servico_id" class="form-control">
              <option value="">Nenhum</option>
              <option v-for="contrato in contratos" :key="contrato.id" :value="contrato.id">
                {{ contrato.numero_contrato }} - {{ contrato.fornecedor }}
              </option>
            </select>
          </div>

          <div class="form-group">
            <label>Transporte</label>
            <select v-model="form.transporte_id" class="form-control">
              <option value="">Nenhum</option>
              <option v-for="transp in transportes" :key="transp.id" :value="transp.id">
                {{ transp.tipo_transporte }} - {{ transp.empresa_transportadora }}
              </option>
            </select>
          </div>

          <div class="form-group">
            <label>Responsável pelo Envio</label>
            <input v-model="form.responsavel_envio" type="text" class="form-control" />
          </div>
        </div>
      </div>

      <!-- Seleção de Equipamentos -->
      <div class="form-section">
        <h2>Equipamentos no Lote</h2>
        <div class="equipamentos-selector">
          <div class="available-equipamentos">
            <h3>Disponíveis</h3>
            <div class="equipamentos-list">
              <div 
                v-for="equip in availableEquipamentos" 
                :key="equip.id" 
                class="equipamento-item"
                @click="addEquipamento(equip.id)"
              >
                <i class="fas fa-plus-circle"></i>
                {{ equip.tipo }} - {{ equip.codigo_interno }}
              </div>
            </div>
          </div>

          <div class="selected-equipamentos">
            <h3>Selecionados ({{ selectedEquipamentoIds.length }})</h3>
            <div class="equipamentos-list">
              <div 
                v-for="id in selectedEquipamentoIds" 
                :key="id" 
                class="equipamento-item selected"
                @click="removeEquipamento(id)"
              >
                <i class="fas fa-times-circle"></i>
                {{ getEquipamentoById(id)?.tipo }} - {{ getEquipamentoById(id)?.codigo_interno }}
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Observações -->
      <div class="form-section">
        <h2>Observações</h2>
        <div class="form-group full-width">
          <textarea v-model="form.observacoes" rows="4" class="form-control"></textarea>
        </div>
      </div>

      <!-- Ações -->
      <div class="form-actions">
        <router-link to="/vue/lotes" class="btn btn-secondary">
          Cancelar
        </router-link>
        <button type="submit" class="btn btn-primary" :disabled="loading || selectedEquipamentoIds.length === 0">
          <i class="fas fa-save"></i>
          {{ isEdit ? 'Salvar' : 'Criar Lote' }}
        </button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { useLotesStore } from '../stores/lotes';
import { useEquipamentosStore } from '../stores/equipamentos';
import { useLaboratoriosStore } from '../stores/laboratorios';
import { useLocaisStore } from '../stores/locais';

const router = useRouter();
const route = useRoute();
const lotesStore = useLotesStore();
const equipamentosStore = useEquipamentosStore();
const laboratoriosStore = useLaboratoriosStore();
const locaisStore = useLocaisStore();

const isEdit = computed(() => !!route.params.id);
const loading = ref(false);
const error = ref(null);

const equipamentos = ref([]);
const laboratorios = ref([]);
const contratos = ref([]);
const transportes = ref([]);
const selectedEquipamentoIds = ref([]);

const form = ref({
  descricao: '',
  data_envio: '',
  data_retorno_prevista: '',
  data_retorno_efetivo: '',
  status: 'preparacao',
  laboratorio_destino_id: '',
  contrato_servico_id: '',
  transporte_id: '',
  responsavel_envio: '',
  observacoes: ''
});

const availableEquipamentos = computed(() => {
  return equipamentos.value.filter(e => !selectedEquipamentoIds.value.includes(e.id));
});

const getEquipamentoById = (id) => {
  return equipamentos.value.find(e => e.id === id);
};

const addEquipamento = (id) => {
  if (!selectedEquipamentoIds.value.includes(id)) {
    selectedEquipamentoIds.value.push(id);
  }
};

const removeEquipamento = (id) => {
  const index = selectedEquipamentoIds.value.indexOf(id);
  if (index > -1) {
    selectedEquipamentoIds.value.splice(index, 1);
  }
};

onMounted(async () => {
  try {
    loading.value = true;
    
    await Promise.all([
      equipamentosStore.fetchEquipamentos().then(() => equipamentos.value = equipamentosStore.equipamentos),
      laboratoriosStore.fetchLaboratorios().then(() => laboratorios.value = laboratoriosStore.laboratorios)
    ]);
    
    if (isEdit.value) {
      const lote = await lotesStore.fetchLote(route.params.id);
      Object.keys(form.value).forEach(key => {
        if (lote[key] !== undefined) {
          form.value[key] = lote[key];
        }
      });
      if (lote.equipamento_ids) {
        selectedEquipamentoIds.value = lote.equipamento_ids;
      }
    }
  } catch (err) {
    error.value = err.message || 'Erro ao carregar dados';
  } finally {
    loading.value = false;
  }
});

const handleSubmit = async () => {
  if (selectedEquipamentoIds.value.length === 0) {
    error.value = 'Selecione pelo menos um equipamento';
    return;
  }

  try {
    loading.value = true;
    error.value = null;

    const payload = {
      ...form.value,
      equipamento_ids: selectedEquipamentoIds.value
    };

    if (isEdit.value) {
      await lotesStore.updateLote(route.params.id, payload);
    } else {
      await lotesStore.createLote(payload);
    }

    router.push('/vue/lotes');
  } catch (err) {
    error.value = err.response?.data?.message || 'Erro ao salvar lote';
  } finally {
    loading.value = false;
  }
};
</script>

<style scoped>
.lote-form-page {
  padding: 24px;
  max-width: 1200px;
  margin: 0 auto;
}

.form-header {
  margin-bottom: 24px;
}

.back-link {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  color: #6b7280;
  text-decoration: none;
  margin-bottom: 12px;
  font-size: 14px;
}

.back-link:hover {
  color: #3b82f6;
}

h1 {
  font-size: 28px;
  font-weight: 700;
  color: #1f2937;
  margin: 0;
}

.form-container {
  display: flex;
  flex-direction: column;
  gap: 24px;
}

.form-section {
  background: white;
  padding: 24px;
  border-radius: 8px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.form-section h2 {
  font-size: 18px;
  font-weight: 600;
  color: #1f2937;
  margin: 0 0 20px 0;
  padding-bottom: 12px;
  border-bottom: 2px solid #e5e7eb;
}

.form-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 20px;
}

.form-group {
  display: flex;
  flex-direction: column;
}

.form-group.full-width {
  grid-column: 1 / -1;
}

.form-group label {
  font-size: 14px;
  font-weight: 500;
  color: #374151;
  margin-bottom: 6px;
}

.form-control {
  padding: 10px 12px;
  border: 1px solid #d1d5db;
  border-radius: 6px;
  font-size: 14px;
  transition: border-color 0.2s;
}

.form-control:focus {
  outline: none;
  border-color: #3b82f6;
  box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

textarea.form-control {
  resize: vertical;
  font-family: inherit;
}

.equipamentos-selector {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;
}

.equipamentos-selector h3 {
  font-size: 14px;
  font-weight: 600;
  color: #374151;
  margin-bottom: 12px;
}

.equipamentos-list {
  max-height: 300px;
  overflow-y: auto;
  border: 1px solid #e5e7eb;
  border-radius: 6px;
  padding: 8px;
}

.equipamento-item {
  padding: 10px 12px;
  margin-bottom: 8px;
  background: #f9fafb;
  border-radius: 6px;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 14px;
  transition: all 0.2s;
}

.equipamento-item:hover {
  background: #e5e7eb;
}

.equipamento-item.selected {
  background: #dbeafe;
  color: #1e40af;
}

.equipamento-item i {
  color: #6b7280;
}

.equipamento-item.selected i {
  color: #1e40af;
}

.form-actions {
  display: flex;
  gap: 12px;
  justify-content: flex-end;
  padding: 20px;
  background: white;
  border-radius: 8px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.btn {
  padding: 10px 20px;
  border: none;
  border-radius: 6px;
  font-size: 14px;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.2s;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  text-decoration: none;
}

.btn-primary {
  background: #3b82f6;
  color: white;
}

.btn-primary:hover:not(:disabled) {
  background: #2563eb;
}

.btn-secondary {
  background: #e5e7eb;
  color: #374151;
}

.btn-secondary:hover {
  background: #d1d5db;
}

.btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
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
</style>
