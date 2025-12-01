import { defineStore } from 'pinia'
import axios from 'axios'

export const useLocaisStore = defineStore('locais', {
  state: () => ({
    locais: [],
    local: null,
    loading: false,
    error: null
  }),

  actions: {
    async fetchLocais() {
      this.loading = true
      this.error = null
      try {
        const response = await axios.get('/api/locais')
        this.locais = response.data
      } catch (error) {
        this.error = error.response?.data?.message || 'Erro ao carregar locais'
        throw error
      } finally {
        this.loading = false
      }
    },

    async createLocal(data) {
      this.loading = true
      this.error = null
      try {
        const response = await axios.post('/api/locais', data)
        this.locais.push(response.data)
        return response.data
      } catch (error) {
        this.error = error.response?.data?.message || 'Erro ao criar local'
        throw error
      } finally {
        this.loading = false
      }
    },

    async updateLocal(id, data) {
      this.loading = true
      this.error = null
      try {
        const response = await axios.put(`/api/locais/${id}`, data)
        const index = this.locais.findIndex(l => l.id === id)
        if (index !== -1) this.locais[index] = response.data
        return response.data
      } catch (error) {
        this.error = error.response?.data?.message || 'Erro ao atualizar local'
        throw error
      } finally {
        this.loading = false
      }
    },

    async deleteLocal(id) {
      this.loading = true
      this.error = null
      try {
        await axios.delete(`/api/locais/${id}`)
        this.locais = this.locais.filter(l => l.id !== id)
      } catch (error) {
        this.error = error.response?.data?.message || 'Erro ao excluir local'
        throw error
      } finally {
        this.loading = false
      }
    }
  }
})
