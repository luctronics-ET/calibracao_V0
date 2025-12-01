import { defineStore } from 'pinia'
import axios from 'axios'

export const useLotesStore = defineStore('lotes', {
  state: () => ({
    lotes: [],
    lote: null,
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
    async fetchLotes() {
      this.loading = true
      this.error = null
      try {
        const response = await axios.get('/api/lotes')
        this.lotes = response.data.data
        this.pagination = {
          current_page: response.data.current_page,
          last_page: response.data.last_page,
          per_page: response.data.per_page,
          total: response.data.total
        }
      } catch (error) {
        this.error = error.response?.data?.message || 'Erro ao carregar lotes'
        throw error
      } finally {
        this.loading = false
      }
    },

    async fetchLote(id) {
      this.loading = true
      this.error = null
      try {
        const response = await axios.get(`/api/lotes/${id}`)
        this.lote = response.data
        return response.data
      } catch (error) {
        this.error = error.response?.data?.message || 'Erro ao carregar lote'
        throw error
      } finally {
        this.loading = false
      }
    },

    async createLote(data) {
      this.loading = true
      this.error = null
      try {
        const response = await axios.post('/api/lotes', data)
        this.lotes.unshift(response.data)
        return response.data
      } catch (error) {
        this.error = error.response?.data?.message || 'Erro ao criar lote'
        throw error
      } finally {
        this.loading = false
      }
    },

    async updateLote(id, data) {
      this.loading = true
      this.error = null
      try {
        const response = await axios.put(`/api/lotes/${id}`, data)
        const index = this.lotes.findIndex(l => l.id === id)
        if (index !== -1) this.lotes[index] = response.data
        this.lote = response.data
        return response.data
      } catch (error) {
        this.error = error.response?.data?.message || 'Erro ao atualizar lote'
        throw error
      } finally {
        this.loading = false
      }
    },

    async deleteLote(id) {
      this.loading = true
      this.error = null
      try {
        await axios.delete(`/api/lotes/${id}`)
        this.lotes = this.lotes.filter(l => l.id !== id)
      } catch (error) {
        this.error = error.response?.data?.message || 'Erro ao excluir lote'
        throw error
      } finally {
        this.loading = false
      }
    }
  }
})
