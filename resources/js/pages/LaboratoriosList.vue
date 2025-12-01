<template>
  <div class="page-container">
    <div class="page-header">
      <h1>
        <i class="fas fa-flask"></i>
        Laboratórios
      </h1>
      <router-link to="/vue/laboratorios/novo" class="btn-primary">
        <i class="fas fa-plus"></i>
        Novo Laboratório
      </router-link>
    </div>

    <!-- Filtros -->
    <div class="filters-bar">
      <div class="search-box">
        <i class="fas fa-search"></i>
        <input 
          type="text" 
          v-model="searchTerm" 
          @input="debounceSearch"
          placeholder="Buscar por nome ou CNPJ..."
        />
      </div>

      <select v-model="filters.acreditado" @change="applyFilters">
        <option value="">Todos</option>
        <option value="1">Acreditados</option>
        <option value="0">Não Acreditados</option>
      </select>

      <button @click="clearFilters" class="btn-clear">
        <i class="fas fa-times"></i>
        Limpar Filtros
      </button>
    </div>

    <!-- Loading -->
    <div v-if="loading" class="loading-state">
      <i class="fas fa-spinner fa-spin"></i>
      <p>Carregando laboratórios...</p>
    </div>

    <!-- Lista Vazia -->
    <div v-else-if="!loading && laboratorios.length === 0" class="empty-state">
      <i class="fas fa-flask"></i>
      <h3>Nenhum laboratório encontrado</h3>
      <p>Comece cadastrando o primeiro laboratório</p>
      <router-link to="/vue/laboratorios/novo" class="btn-primary">
        <i class="fas fa-plus"></i>
        Criar Primeiro Laboratório
      </router-link>
    </div>

    <!-- Tabela de Laboratórios -->
    <div v-else class="table-container">
      <table class="data-table">
        <thead>
          <tr>
            <th>Nome</th>
            <th>CNPJ</th>
            <th>Cidade/Estado</th>
            <th>Endereço</th>
            <th>CEP</th>
            <th>Telefone</th>
            <th>E-mail</th>
            <th>Contato</th>
            <th>Acreditado</th>
            <th>Nº Acreditação</th>
            <th class="actions-col">Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="laboratorio in laboratorios" :key="laboratorio.id">
            <td><strong>{{ laboratorio.nome }}</strong></td>
            <td>{{ formatCNPJ(laboratorio.cnpj) }}</td>
            <td>{{ laboratorio.cidade }} - {{ laboratorio.estado }}</td>
            <td>{{ laboratorio.endereco }}</td>
            <td>{{ laboratorio.cep || '-' }}</td>
            <td>{{ laboratorio.telefone || '-' }}</td>
            <td>{{ laboratorio.email || '-' }}</td>
            <td>{{ laboratorio.contato || '-' }}</td>
            <td>
              <span v-if="laboratorio.acreditado" class="badge badge-success">
                <i class="fas fa-check-circle"></i> Sim
              </span>
              <span v-else class="badge badge-secondary">Não</span>
            </td>
            <td>{{ laboratorio.numero_acreditacao || '-' }}</td>
            <td class="actions-col">
              <router-link :to="`/vue/laboratorios/${laboratorio.id}/editar`" class="btn-icon" title="Editar">
                <i class="fas fa-edit"></i>
              </router-link>
              <button @click="handleDelete(laboratorio.id)" class="btn-icon btn-danger" title="Excluir">
                <i class="fas fa-trash"></i>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useLaboratoriosStore } from '../stores/laboratorios'

const laboratoriosStore = useLaboratoriosStore()

const searchTerm = ref('')
let searchTimeout = null

const laboratorios = computed(() => laboratoriosStore.laboratorios)
const loading = computed(() => laboratoriosStore.loading)
const filters = computed(() => laboratoriosStore.filters)

onMounted(() => {
  laboratoriosStore.fetchLaboratorios()
})

const debounceSearch = () => {
  clearTimeout(searchTimeout)
  searchTimeout = setTimeout(() => {
    laboratoriosStore.setFilter('search', searchTerm.value)
    applyFilters()
  }, 500)
}

const applyFilters = () => {
  laboratoriosStore.fetchLaboratorios()
}

const clearFilters = () => {
  searchTerm.value = ''
  laboratoriosStore.clearFilters()
  laboratoriosStore.fetchLaboratorios()
}

const handleDelete = async (id) => {
  if (!confirm('Tem certeza que deseja excluir este laboratório?')) return
  
  try {
    await laboratoriosStore.deleteLaboratorio(id)
    alert('Laboratório excluído com sucesso!')
  } catch (error) {
    alert(error.message || 'Erro ao excluir laboratório')
  }
}

const formatCNPJ = (cnpj) => {
  if (!cnpj) return ''
  return cnpj.replace(/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/, '$1.$2.$3/$4-$5')
}
</script>

<style scoped>
.page-container {
  padding: 24px;
}

.page-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
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

.filters-bar {
  display: flex;
  gap: 12px;
  margin-bottom: 24px;
  flex-wrap: wrap;
}

.search-box {
  position: relative;
  flex: 1;
  min-width: 300px;
}

.search-box i {
  position: absolute;
  left: 12px;
  top: 50%;
  transform: translateY(-50%);
  color: #9ca3af;
}

.search-box input {
  width: 100%;
  padding: 10px 12px 10px 40px;
  border: 1px solid #d1d5db;
  border-radius: 6px;
  font-size: 14px;
}

.filters-bar select {
  padding: 10px 12px;
  border: 1px solid #d1d5db;
  border-radius: 6px;
  font-size: 14px;
  background: white;
}

.btn-clear {
  padding: 10px 16px;
  background: #f3f4f6;
  border: 1px solid #d1d5db;
  border-radius: 6px;
  cursor: pointer;
  transition: all 0.2s;
  display: flex;
  align-items: center;
  gap: 8px;
}

.btn-clear:hover {
  background: #e5e7eb;
}

.loading-state,
.empty-state {
  text-align: center;
  padding: 48px;
  color: #6b7280;
}

.loading-state i,
.empty-state i {
  font-size: 64px;
  margin-bottom: 16px;
  opacity: 0.5;
}

.empty-state h3 {
  font-size: 20px;
  color: #1f2937;
  margin-bottom: 8px;
}

.empty-state p {
  margin-bottom: 24px;
}

.table-container {
  background: white;
  border-radius: 8px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
  overflow-x: auto;
  margin-bottom: 24px;
}

.data-table {
  width: 100%;
  border-collapse: collapse;
}

.data-table thead {
  background: #f9fafb;
  border-bottom: 2px solid #e5e7eb;
}

.data-table th {
  padding: 12px 16px;
  text-align: left;
  font-weight: 600;
  color: #374151;
  font-size: 14px;
  white-space: nowrap;
}

.data-table tbody tr {
  border-bottom: 1px solid #e5e7eb;
  transition: background-color 0.2s;
}

.data-table tbody tr:hover {
  background-color: #f9fafb;
}

.data-table td {
  padding: 12px 16px;
  color: #1f2937;
  font-size: 14px;
}

.actions-col {
  width: 120px;
  text-align: center;
}

.badge {
  display: inline-block;
  padding: 4px 12px;
  border-radius: 12px;
  color: white;
  font-size: 12px;
  font-weight: 500;
  white-space: nowrap;
}

.badge-success {
  background: #10b981;
}

.badge-secondary {
  background: #6b7280;
}

.btn-icon {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 32px;
  height: 32px;
  border: none;
  border-radius: 6px;
  background: #3b82f6;
  color: white;
  cursor: pointer;
  transition: all 0.2s;
  text-decoration: none;
  margin: 0 4px;
}

.btn-icon:hover {
  background: #2563eb;
}

.btn-icon.btn-danger {
  background: #ef4444;
}

.btn-icon.btn-danger:hover {
  background: #dc2626;
}

.btn-primary {
  padding: 10px 20px;
  background: #3b82f6;
  color: white;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  transition: background 0.2s;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  font-weight: 500;
}

.btn-primary:hover {
  background: #2563eb;
}
</style>
