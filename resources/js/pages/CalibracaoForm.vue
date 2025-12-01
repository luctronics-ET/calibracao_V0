<template>
  <div class="calibracao-form-page">
    <div class="form-header">
      <router-link to="/vue/calibracoes" class="back-link">
        <i class="fas fa-arrow-left"></i> Voltar
      </router-link>
      <h1>{{ isEdit ? 'Editar Calibração' : 'Nova Calibração' }}</h1>
    </div>

    <div v-if="loading" class="loading-container">
      <div class="spinner"></div>
    </div>

    <div v-if="error" class="alert alert-danger">
      {{ error }}
      <button @click="error = null" class="btn-close">&times;</button>
    </div>

    <form v-if="!loading" @submit.prevent="handleSubmit" class="form-container">
      <!-- Informações Básicas -->
      <div class="form-section">
        <h2>Informações Básicas</h2>
        <div class="form-grid">
          <div class="form-group">
            <label>Equipamento *</label>
            <select v-model="form.equipamento_id" required class="form-control">
              <option value="">Selecione</option>
              <option v-for="equip in equipamentos" :key="equip.id" :value="equip.id">
                {{ equip.tipo }} - {{ equip.codigo_interno }}
              </option>
            </select>
          </div>

          <div class="form-group">
            <label>Data da Calibração *</label>
            <input v-model="form.data_calibracao" type="date" required class="form-control" />
          </div>

          <div class="form-group">
            <label>Laboratório *</label>
            <select v-model="form.laboratorio_id" required class="form-control">
              <option value="">Selecione</option>
              <option v-for="lab in laboratorios" :key="lab.id" :value="lab.id">
                {{ lab.nome }}
              </option>
            </select>
          </div>

          <div class="form-group">
            <label>Status</label>
            <select v-model="form.status" class="form-control">
              <option value="pendente">Pendente</option>
              <option value="em_andamento">Em Andamento</option>
              <option value="concluida">Concluída</option>
              <option value="aprovada">Aprovada</option>
              <option value="reprovada">Reprovada</option>
            </select>
          </div>
        </div>
      </div>

      <!-- Campos RBC -->
      <div class="form-section">
        <h2>Informações RBC (Rede Brasileira de Calibração)</h2>
        <div class="form-grid">
          <div class="form-group">
            <label>Código RBC do Laboratório</label>
            <input v-model="form.rbc_codigo_laboratorio" type="text" class="form-control" 
                   placeholder="Ex: RBC-001" />
          </div>

          <div class="form-group">
            <label>Método de Calibração RBC</label>
            <input v-model="form.rbc_metodo_calibracao" type="text" class="form-control" />
          </div>

          <div class="form-group">
            <label>Incerteza Prevista RBC</label>
            <input v-model="form.rbc_incerteza_prevista" type="text" class="form-control" 
                   placeholder="Ex: ±0.01mm" />
          </div>

          <div class="form-group">
            <label>Capacidade de Medição RBC (CMC)</label>
            <input v-model="form.rbc_capacidade_medicao" type="text" class="form-control" />
          </div>

          <div class="form-group">
            <label class="checkbox-label">
              <input v-model="form.conformidade_ilac_p14" type="checkbox" />
              Conformidade ILAC-P14
            </label>
          </div>
        </div>
      </div>

      <!-- Relacionamentos -->
      <div class="form-section">
        <h2>Relacionamentos (Opcional)</h2>
        <div class="form-grid">
          <div class="form-group">
            <label>Lote</label>
            <select v-model="form.lote_id" class="form-control">
              <option value="">Nenhum</option>
              <option v-for="lote in lotes" :key="lote.id" :value="lote.id">
                Lote #{{ lote.id }} - {{ lote.descricao }}
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
            <label>Localização Atual</label>
            <select v-model="form.localizacao_atual_id" class="form-control">
              <option value="">Nenhuma</option>
              <option v-for="local in locais" :key="local.id" :value="local.id">
                {{ local.nome }}
              </option>
            </select>
          </div>
        </div>
      </div>

      <!-- Datas e Previsões -->
      <div class="form-section">
        <h2>Datas e Previsões</h2>
        <div class="form-grid">
          <div class="form-group">
            <label>Próxima Calibração Sugerida</label>
            <input v-model="form.proxima_calibracao_sugerida" type="date" class="form-control" />
          </div>

          <div class="form-group full-width">
            <label>Observações</label>
            <textarea v-model="form.observacoes" rows="4" class="form-control"></textarea>
          </div>
        </div>
      </div>

      <!-- Ações -->
      <div class="form-actions">
        <router-link to="/vue/calibracoes" class="btn btn-secondary">
          Cancelar
        </router-link>
        <button type="submit" class="btn btn-primary" :disabled="loading">
          <i class="fas fa-save"></i>
          {{ isEdit ? 'Salvar' : 'Criar Calibração' }}
        </button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { useCalibracoesStore } from '../stores/calibracoes';
import { useEquipamentosStore } from '../stores/equipamentos';
import { useLaboratoriosStore } from '../stores/laboratorios';
import { useLotesStore } from '../stores/lotes';
import { useLocaisStore } from '../stores/locais';

const router = useRouter();
const route = useRoute();
const calibracoesStore = useCalibracoesStore();
const equipamentosStore = useEquipamentosStore();
const laboratoriosStore = useLaboratoriosStore();
const lotesStore = useLotesStore();
const locaisStore = useLocaisStore();

const isEdit = computed(() => !!route.params.id);
const loading = ref(false);
const error = ref(null);

const equipamentos = ref([]);
const laboratorios = ref([]);
const lotes = ref([]);
const contratos = ref([]);
const locais = ref([]);

const form = ref({
  equipamento_id: '',
  data_calibracao: '',
  laboratorio_id: '',
  rbc_codigo_laboratorio: '',
  rbc_metodo_calibracao: '',
  rbc_incerteza_prevista: '',
  rbc_capacidade_medicao: '',
  conformidade_ilac_p14: false,
  status: 'pendente',
  lote_id: '',
  contrato_servico_id: '',
  localizacao_atual_id: '',
  proxima_calibracao_sugerida: '',
  observacoes: ''
});

onMounted(async () => {
  try {
    loading.value = true;
    
    await Promise.all([
      equipamentosStore.fetchEquipamentos().then(() => equipamentos.value = equipamentosStore.equipamentos),
      laboratoriosStore.fetchLaboratorios().then(() => laboratorios.value = laboratoriosStore.laboratorios),
      lotesStore.fetchLotes().then(() => lotes.value = lotesStore.lotes),
      locaisStore.fetchLocais().then(() => locais.value = locaisStore.locais)
    ]);
    
    if (isEdit.value) {
      const calibracao = await calibracoesStore.fetchCalibracao(route.params.id);
      Object.keys(form.value).forEach(key => {
        if (calibracao[key] !== undefined) {
          form.value[key] = calibracao[key];
        }
      });
    }
  } catch (err) {
    error.value = err.message || 'Erro ao carregar dados';
  } finally {
    loading.value = false;
  }
});

const handleSubmit = async () => {
  try {
    loading.value = true;
    error.value = null;

    if (isEdit.value) {
      await calibracoesStore.updateCalibracao(route.params.id, form.value);
    } else {
      await calibracoesStore.createCalibracao(form.value);
    }

    router.push('/vue/calibracoes');
  } catch (err) {
    error.value = err.response?.data?.message || 'Erro ao salvar calibração';
  } finally {
    loading.value = false;
  }
};
</script>

<style scoped>
.calibracao-form-page {
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

.checkbox-label {
  display: flex;
  align-items: center;
  gap: 8px;
  cursor: pointer;
}

.checkbox-label input[type="checkbox"] {
  width: 18px;
  height: 18px;
  cursor: pointer;
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
