import { defineStore } from 'pinia'
import axios from 'axios'

export const useEquipamentosStore = defineStore('equipamentos', {
  state: () => ({
    equipamentos: [],
    equipamento: null,
    loading: false,
    error: null,
    pagination: {
      current_page: 1,
      last_page: 1,
      per_page: 20,
      total: 0
    }
  }),

  actions: {
    async fetchEquipamentos(params = {}) {
      this.loading = true
      this.error = null
      try {
        const response = await axios.get('/api/equipamentos', { params })
        this.equipamentos = response.data.data
        this.pagination = {
          current_page: response.data.current_page,
          last_page: response.data.last_page,
          per_page: response.data.per_page,
          total: response.data.total
        }
      } catch (error) {
        this.error = error.response?.data?.message || 'Erro ao carregar equipamentos'
        throw error
      } finally {
        this.loading = false
      }
    },

    async fetchEquipamento(id) {
      this.loading = true
      this.error = null
      try {
        const response = await axios.get(`/api/equipamentos/${id}`)
        this.equipamento = response.data
        return response.data
      } catch (error) {
        this.error = error.response?.data?.message || 'Erro ao carregar equipamento'
        throw error
      } finally {
        this.loading = false
      }
    },

    async createEquipamento(data) {
      this.loading = true
      this.error = null
      try {
        const response = await axios.post('/api/equipamentos', data)
        this.equipamentos.unshift(response.data.data)
        return response.data
      } catch (error) {
        this.error = error.response?.data?.message || 'Erro ao criar equipamento'
        throw error
      } finally {
        this.loading = false
      }
    },

    async updateEquipamento(id, data) {
      this.loading = true
      this.error = null
      try {
        const response = await axios.put(`/api/equipamentos/${id}`, data)
        const index = this.equipamentos.findIndex(e => e.id === id)
        if (index !== -1) this.equipamentos[index] = response.data.data
        this.equipamento = response.data.data
        return response.data
      } catch (error) {
        this.error = error.response?.data?.message || 'Erro ao atualizar equipamento'
        throw error
      } finally {
        this.loading = false
      }
    },

    async deleteEquipamento(id) {
      this.loading = true
      this.error = null
      try {
        await axios.delete(`/api/equipamentos/${id}`)
        this.equipamentos = this.equipamentos.filter(e => e.id !== id)
      } catch (error) {
        this.error = error.response?.data?.message || 'Erro ao excluir equipamento'
        throw error
      } finally {
        this.loading = false
      }
    }
  }
})
