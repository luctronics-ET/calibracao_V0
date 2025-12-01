import { defineStore } from 'pinia'
import axios from 'axios'

export const useLaboratoriosStore = defineStore('laboratorios', {
  state: () => ({
    laboratorios: [],
    laboratorio: null,
    loading: false,
    error: null
  }),

  actions: {
    async fetchLaboratorios() {
      this.loading = true
      this.error = null
      try {
        const response = await axios.get('/api/laboratorios')
        this.laboratorios = response.data
      } catch (error) {
        this.error = error.response?.data?.message || 'Erro ao carregar laboratórios'
        throw error
      } finally {
        this.loading = false
      }
    },

    async createLaboratorio(data) {
      this.loading = true
      this.error = null
      try {
        const response = await axios.post('/api/laboratorios', data)
        this.laboratorios.push(response.data)
        return response.data
      } catch (error) {
        this.error = error.response?.data?.message || 'Erro ao criar laboratório'
        throw error
      } finally {
        this.loading = false
      }
    },

    async updateLaboratorio(id, data) {
      this.loading = true
      this.error = null
      try {
        const response = await axios.put(`/api/laboratorios/${id}`, data)
        const index = this.laboratorios.findIndex(l => l.id === id)
        if (index !== -1) this.laboratorios[index] = response.data
        return response.data
      } catch (error) {
        this.error = error.response?.data?.message || 'Erro ao atualizar laboratório'
        throw error
      } finally {
        this.loading = false
      }
    },

    async deleteLaboratorio(id) {
      this.loading = true
      this.error = null
      try {
        await axios.delete(`/api/laboratorios/${id}`)
        this.laboratorios = this.laboratorios.filter(l => l.id !== id)
      } catch (error) {
        this.error = error.response?.data?.message || 'Erro ao excluir laboratório'
        throw error
      } finally {
        this.loading = false
      }
    }
  }
})
