<template>
  <div class="page-container">
    <div class="page-header">
      <h1>
        <i class="fas fa-flask"></i>
        {{ isEditing ? 'Editar' : 'Novo' }} Laboratório
      </h1>
    </div>

    <div v-if="loading" class="loading-state">
      <i class="fas fa-spinner fa-spin"></i>
      <p>Carregando...</p>
    </div>

    <div v-else class="form-card">
      <form @submit.prevent="handleSubmit">
        <h2 class="section-title">Informações Básicas</h2>
        <div class="form-grid">
          <div class="form-group full-width">
            <label for="nome">Nome do Laboratório *</label>
            <input 
              type="text" 
              id="nome" 
              v-model="form.nome" 
              required
              placeholder="Ex: MetroLab Calibrações"
            />
          </div>

          <div class="form-group">
            <label for="cnpj">CNPJ *</label>
            <input 
              type="text" 
              id="cnpj" 
              v-model="form.cnpj" 
              required
              placeholder="00.000.000/0000-00"
              maxlength="18"
            />
          </div>

          <div class="form-group">
            <label for="telefone">Telefone</label>
            <input 
              type="text" 
              id="telefone" 
              v-model="form.telefone"
              placeholder="(00) 0000-0000"
            />
          </div>

          <div class="form-group">
            <label for="email">E-mail</label>
            <input 
              type="email" 
              id="email" 
              v-model="form.email"
              placeholder="contato@laboratorio.com.br"
            />
          </div>

          <div class="form-group">
            <label for="contato">Pessoa de Contato</label>
            <input 
              type="text" 
              id="contato" 
              v-model="form.contato"
              placeholder="Nome do responsável"
            />
          </div>
        </div>

        <h2 class="section-title">Endereço</h2>
        <div class="form-grid">
          <div class="form-group full-width">
            <label for="endereco">Logradouro *</label>
            <input 
              type="text" 
              id="endereco" 
              v-model="form.endereco" 
              required
              placeholder="Rua, Av., etc"
            />
          </div>

          <div class="form-group">
            <label for="cidade">Cidade *</label>
            <input 
              type="text" 
              id="cidade" 
              v-model="form.cidade" 
              required
              placeholder="Nome da cidade"
            />
          </div>

          <div class="form-group">
            <label for="estado">Estado *</label>
            <select id="estado" v-model="form.estado" required>
              <option value="">Selecione</option>
              <option value="AC">Acre</option>
              <option value="AL">Alagoas</option>
              <option value="AP">Amapá</option>
              <option value="AM">Amazonas</option>
              <option value="BA">Bahia</option>
              <option value="CE">Ceará</option>
              <option value="DF">Distrito Federal</option>
              <option value="ES">Espírito Santo</option>
              <option value="GO">Goiás</option>
              <option value="MA">Maranhão</option>
              <option value="MT">Mato Grosso</option>
              <option value="MS">Mato Grosso do Sul</option>
              <option value="MG">Minas Gerais</option>
              <option value="PA">Pará</option>
              <option value="PB">Paraíba</option>
              <option value="PR">Paraná</option>
              <option value="PE">Pernambuco</option>
              <option value="PI">Piauí</option>
              <option value="RJ">Rio de Janeiro</option>
              <option value="RN">Rio Grande do Norte</option>
              <option value="RS">Rio Grande do Sul</option>
              <option value="RO">Rondônia</option>
              <option value="RR">Roraima</option>
              <option value="SC">Santa Catarina</option>
              <option value="SP">São Paulo</option>
              <option value="SE">Sergipe</option>
              <option value="TO">Tocantins</option>
            </select>
          </div>

          <div class="form-group">
            <label for="cep">CEP</label>
            <input 
              type="text" 
              id="cep" 
              v-model="form.cep"
              placeholder="00000-000"
              maxlength="9"
            />
          </div>
        </div>

        <h2 class="section-title">Acreditação</h2>
        <div class="form-grid">
          <div class="form-group checkbox-group full-width">
            <label class="checkbox-label">
              <input 
                type="checkbox" 
                v-model="form.acreditado"
              />
              <span>Laboratório acreditado</span>
            </label>
          </div>

          <div class="form-group full-width" v-if="form.acreditado">
            <label for="numero_acreditacao">Número da Acreditação</label>
            <input 
              type="text" 
              id="numero_acreditacao" 
              v-model="form.numero_acreditacao"
              placeholder="Ex: CRL-0000"
            />
          </div>
        </div>

        <div class="form-actions">
          <button type="button" @click="handleCancel" class="btn-secondary">
            Cancelar
          </button>
          <button type="submit" class="btn-primary" :disabled="submitting">
            <i class="fas" :class="submitting ? 'fa-spinner fa-spin' : 'fa-save'"></i>
            {{ submitting ? 'Salvando...' : 'Salvar' }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { useLaboratoriosStore } from '../stores/laboratorios'

const router = useRouter()
const route = useRoute()
const laboratoriosStore = useLaboratoriosStore()

const loading = ref(true)
const submitting = ref(false)

const isEditing = computed(() => !!route.params.id)

const form = ref({
  nome: '',
  cnpj: '',
  endereco: '',
  cidade: '',
  estado: '',
  cep: '',
  telefone: '',
  email: '',
  contato: '',
  acreditado: false,
  numero_acreditacao: ''
})

onMounted(async () => {
  try {
    if (isEditing.value) {
      await laboratoriosStore.fetchLaboratorio(route.params.id)
      const laboratorio = laboratoriosStore.laboratorio
      
      form.value = {
        nome: laboratorio.nome,
        cnpj: laboratorio.cnpj,
        endereco: laboratorio.endereco,
        cidade: laboratorio.cidade,
        estado: laboratorio.estado,
        cep: laboratorio.cep || '',
        telefone: laboratorio.telefone || '',
        email: laboratorio.email || '',
        contato: laboratorio.contato || '',
        acreditado: !!laboratorio.acreditado,
        numero_acreditacao: laboratorio.numero_acreditacao || ''
      }
    }
  } catch (error) {
    console.error('Erro ao carregar dados:', error)
    alert('Erro ao carregar dados do formulário')
  } finally {
    loading.value = false
  }
})

const handleSubmit = async () => {
  submitting.value = true
  
  try {
    const data = {
      ...form.value,
      acreditado: form.value.acreditado ? 1 : 0
    }
    
    if (isEditing.value) {
      await laboratoriosStore.updateLaboratorio(route.params.id, data)
      alert('Laboratório atualizado com sucesso!')
    } else {
      await laboratoriosStore.createLaboratorio(data)
      alert('Laboratório criado com sucesso!')
    }
    
    router.push('/vue/laboratorios')
  } catch (error) {
    console.error('Erro ao salvar:', error)
    alert(error.message || 'Erro ao salvar laboratório')
  } finally {
    submitting.value = false
  }
}

const handleCancel = () => {
  router.push('/vue/laboratorios')
}
</script>

<style scoped>
.page-container {
  padding: 24px;
}

.page-header {
  margin-bottom: 24px;
}

.page-header h1 {
  font-size: 28px;
  font-weight: 700;
  color: #1f2937;
  display: flex;
  align-items: center;
  gap: 12px;
}

.page-header h1 i {
  color: #3b82f6;
}

.loading-state {
  text-align: center;
  padding: 48px;
  color: #6b7280;
}

.loading-state i {
  font-size: 48px;
  margin-bottom: 16px;
}

.form-card {
  background: white;
  border-radius: 8px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
  padding: 24px;
}

.section-title {
  font-size: 18px;
  font-weight: 600;
  color: #1f2937;
  margin: 24px 0 16px 0;
  padding-bottom: 8px;
  border-bottom: 2px solid #e5e7eb;
}

.section-title:first-child {
  margin-top: 0;
}

.form-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 20px;
  margin-bottom: 24px;
}

.form-group {
  display: flex;
  flex-direction: column;
}

.form-group.full-width {
  grid-column: 1 / -1;
}

.form-group label {
  font-weight: 500;
  color: #374151;
  margin-bottom: 8px;
}

.form-group input,
.form-group select {
  padding: 10px 12px;
  border: 1px solid #d1d5db;
  border-radius: 6px;
  font-size: 14px;
  transition: border-color 0.2s;
}

.form-group input:focus,
.form-group select:focus {
  outline: none;
  border-color: #3b82f6;
}

.checkbox-group {
  display: flex;
  align-items: center;
}

.checkbox-label {
  display: flex;
  align-items: center;
  gap: 10px;
  cursor: pointer;
  font-weight: 500;
  color: #374151;
}

.checkbox-label input[type="checkbox"] {
  width: 18px;
  height: 18px;
  cursor: pointer;
}

.form-actions {
  display: flex;
  gap: 12px;
  justify-content: flex-end;
  padding-top: 20px;
  border-top: 1px solid #e5e7eb;
}

.btn-primary,
.btn-secondary {
  padding: 10px 24px;
  border-radius: 6px;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.2s;
  border: none;
  display: flex;
  align-items: center;
  gap: 8px;
}

.btn-primary {
  background: #3b82f6;
  color: white;
}

.btn-primary:hover:not(:disabled) {
  background: #2563eb;
}

.btn-primary:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.btn-secondary {
  background: #f3f4f6;
  color: #374151;
}

.btn-secondary:hover {
  background: #e5e7eb;
}

@media (max-width: 768px) {
  .form-grid {
    grid-template-columns: 1fr;
  }
}
</style>
