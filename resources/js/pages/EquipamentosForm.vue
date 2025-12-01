<template>
  <div class="equipamento-form-page">
    <div class="form-header">
      <div>
        <router-link to="/vue/equipamentos" class="back-link">
          <i class="fas fa-arrow-left"></i> Voltar
        </router-link>
        <h1>{{ isEdit ? 'Editar Equipamento' : 'Novo Equipamento' }}</h1>
      </div>
    </div>

    <div v-if="loading" class="loading-container">
      <div class="spinner"></div>
      <p>{{ isEdit ? 'Carregando equipamento...' : 'Salvando...' }}</p>
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
            <label>Categoria Metrológica *</label>
            <input v-model="form.categoria_metrologica" type="text" required class="form-control" 
                   placeholder="Ex: Dimensional, Elétrica, Térmica" />
          </div>

          <div class="form-group">
            <label>Tipo *</label>
            <input v-model="form.tipo" type="text" required class="form-control" 
                   placeholder="Ex: Paquímetro, Multímetro" />
          </div>

          <div class="form-group">
            <label>Fabricante</label>
            <input v-model="form.fabricante" type="text" class="form-control" />
          </div>

          <div class="form-group">
            <label>Modelo</label>
            <input v-model="form.modelo" type="text" class="form-control" />
          </div>

          <div class="form-group">
            <label>Número de Série</label>
            <input v-model="form.numero_serie" type="text" class="form-control" />
          </div>

          <div class="form-group">
            <label>Código Interno *</label>
            <input v-model="form.codigo_interno" type="text" required class="form-control" />
          </div>

          <div class="form-group full-width">
            <label>Descrição</label>
            <textarea v-model="form.descricao" rows="3" class="form-control"></textarea>
          </div>
        </div>
      </div>

      <!-- Localização -->
      <div class="form-section">
        <h2>Localização</h2>
        <div class="form-grid">
          <div class="form-group">
            <label>Local de Dotação *</label>
            <select v-model="form.local_dotacao_id" required class="form-control">
              <option value="">Selecione</option>
              <option v-for="local in locais" :key="local.id" :value="local.id">
                {{ local.nome }}
              </option>
            </select>
          </div>

          <div class="form-group">
            <label>Localização Atual</label>
            <select v-model="form.localizacao_atual_id" class="form-control">
              <option value="">Selecione</option>
              <option v-for="local in locais" :key="local.id" :value="local.id">
                {{ local.nome }}
              </option>
            </select>
          </div>
        </div>
      </div>

      <!-- Características Metrológicas -->
      <div class="form-section">
        <h2>Características Metrológicas</h2>
        <div class="form-grid">
          <div class="form-group">
            <label>Classe de Exatidão</label>
            <input v-model="form.classe_exatidao" type="text" class="form-control" 
                   placeholder="Ex: 0.01, ±1%" />
          </div>

          <div class="form-group">
            <label>Resolução</label>
            <input v-model="form.resolucao" type="text" class="form-control" 
                   placeholder="Ex: 0.01mm, 1mV" />
          </div>

          <div class="form-group">
            <label>Intervalo de Medição Mínimo</label>
            <input v-model.number="form.intervalo_medicao_min" type="number" step="any" class="form-control" />
          </div>

          <div class="form-group">
            <label>Intervalo de Medição Máximo</label>
            <input v-model.number="form.intervalo_medicao_max" type="number" step="any" class="form-control" />
          </div>
        </div>
      </div>

      <!-- Condições Ambientais -->
      <div class="form-section">
        <h2>Condições de Operação</h2>
        <div class="form-grid">
          <div class="form-group">
            <label>Temperatura de Operação</label>
            <input v-model="form.cond_temp_operacao" type="text" class="form-control" 
                   placeholder="Ex: 15°C a 30°C" />
          </div>

          <div class="form-group">
            <label>Umidade de Operação</label>
            <input v-model="form.cond_umidade_operacao" type="text" class="form-control" 
                   placeholder="Ex: 30% a 80%" />
          </div>

          <div class="form-group full-width">
            <label>Restrições Ambientais</label>
            <textarea v-model="form.cond_ambiente_restricoes" rows="2" class="form-control" 
                      placeholder="Ex: Evitar vibração, manter longe de campos magnéticos"></textarea>
          </div>
        </div>
      </div>

      <!-- Calibração e Criticidade -->
      <div class="form-section">
        <h2>Calibração e Criticidade</h2>
        <div class="form-grid">
          <div class="form-group">
            <label>Criticidade do Equipamento</label>
            <select v-model="form.criticidade_equipamento" class="form-control">
              <option value="">Selecione</option>
              <option value="baixa">Baixa</option>
              <option value="media">Média</option>
              <option value="alta">Alta</option>
              <option value="critica">Crítica</option>
            </select>
          </div>

          <div class="form-group">
            <label>Intervalo de Calibração (meses)</label>
            <input v-model.number="form.intervalo_calibracao_meses" type="number" min="1" class="form-control" />
          </div>

          <div class="form-group">
            <label>Próxima Calibração Prevista</label>
            <input v-model="form.proxima_calibracao_prevista" type="date" class="form-control" />
          </div>

          <div class="form-group">
            <label>Custo Previsto de Calibração (R$)</label>
            <input v-model.number="form.custo_previsto_calibracao" type="number" step="0.01" class="form-control" />
          </div>

          <div class="form-group full-width">
            <label>Justificativa do Intervalo</label>
            <textarea v-model="form.justificativa_intervalo" rows="2" class="form-control"></textarea>
          </div>
        </div>
      </div>

      <!-- Bloqueio -->
      <div class="form-section">
        <h2>Status de Uso</h2>
        <div class="form-grid">
          <div class="form-group">
            <label class="checkbox-label">
              <input v-model="form.bloqueado_para_uso" type="checkbox" />
              Equipamento bloqueado para uso
            </label>
          </div>

          <div v-if="form.bloqueado_para_uso" class="form-group full-width">
            <label>Motivo do Bloqueio</label>
            <textarea v-model="form.motivo_bloqueio" rows="2" class="form-control" required></textarea>
          </div>
        </div>
      </div>

      <!-- Responsáveis -->
      <div class="form-section">
        <h2>Responsáveis</h2>
        <div class="form-grid">
          <div class="form-group">
            <label>Responsável Técnico</label>
            <input v-model="form.responsavel_tecnico" type="text" class="form-control" />
          </div>

          <div class="form-group">
            <label>Responsável pelo Cadastramento</label>
            <input v-model="form.responsavel_cadastramento" type="text" class="form-control" />
          </div>

          <div class="form-group full-width">
            <label>Observações de Auditoria</label>
            <textarea v-model="form.observacoes_auditoria" rows="3" class="form-control"></textarea>
          </div>
        </div>
      </div>

      <!-- Ações -->
      <div class="form-actions">
        <router-link to="/vue/equipamentos" class="btn btn-secondary">
          Cancelar
        </router-link>
        <button type="submit" class="btn btn-primary" :disabled="loading">
          <i class="fas fa-save"></i>
          {{ isEdit ? 'Salvar Alterações' : 'Criar Equipamento' }}
        </button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { useEquipamentosStore } from '../stores/equipamentos';
import { useLocaisStore } from '../stores/locais';

const router = useRouter();
const route = useRoute();
const equipamentosStore = useEquipamentosStore();
const locaisStore = useLocaisStore();

const isEdit = computed(() => !!route.params.id);
const loading = ref(false);
const error = ref(null);
const locais = ref([]);

const form = ref({
  categoria_metrologica: '',
  tipo: '',
  fabricante: '',
  modelo: '',
  numero_serie: '',
  codigo_interno: '',
  descricao: '',
  local_dotacao_id: '',
  localizacao_atual_id: '',
  classe_exatidao: '',
  resolucao: '',
  intervalo_medicao_min: null,
  intervalo_medicao_max: null,
  cond_temp_operacao: '',
  cond_umidade_operacao: '',
  cond_ambiente_restricoes: '',
  criticidade_equipamento: '',
  intervalo_calibracao_meses: 12,
  justificativa_intervalo: '',
  proxima_calibracao_prevista: '',
  custo_previsto_calibracao: null,
  bloqueado_para_uso: false,
  motivo_bloqueio: '',
  responsavel_tecnico: '',
  responsavel_cadastramento: '',
  observacoes_auditoria: ''
});

onMounted(async () => {
  try {
    loading.value = true;
    
    // Carregar locais
    await locaisStore.fetchLocais();
    locais.value = locaisStore.locais;
    
    // Se for edição, carregar equipamento
    if (isEdit.value) {
      const equipamento = await equipamentosStore.fetchEquipamento(route.params.id);
      Object.keys(form.value).forEach(key => {
        if (equipamento[key] !== undefined) {
          form.value[key] = equipamento[key];
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
      await equipamentosStore.updateEquipamento(route.params.id, form.value);
    } else {
      await equipamentosStore.createEquipamento(form.value);
    }

    router.push('/vue/equipamentos');
  } catch (err) {
    error.value = err.response?.data?.message || 'Erro ao salvar equipamento';
  } finally {
    loading.value = false;
  }
};
</script>

<style scoped>
.equipamento-form-page {
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
