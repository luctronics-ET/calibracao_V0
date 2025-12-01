import { defineStore } from 'pinia'
import axios from 'axios'

export const useCalibracoes Store = defineStore('calibracoes', {
  state: () => ({
    calibracoes: [],
    calibracao: null,
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
    async fetchCalibracoes(params = {}) {
      this.loading = true
      this.error = null
      try {
        const response = await axios.get('/api/calibracoes', { params })
        this.calibracoes = response.data.data
        this.pagination = {
          current_page: response.data.current_page,
          last_page: response.data.last_page,
          per_page: response.data.per_page,
          total: response.data.total
        }
      } catch (error) {
        this.error = error.response?.data?.message || 'Erro ao carregar calibrações'
        throw error
      } finally {
        this.loading = false
      }
    },

    async fetchCalibracao(id) {
      this.loading = true
      this.error = null
      try {
        const response = await axios.get(`/api/calibracoes/${id}`)
        this.calibracao = response.data
        return response.data
      } catch (error) {
        this.error = error.response?.data?.message || 'Erro ao carregar calibração'
        throw error
      } finally {
        this.loading = false
      }
    },

    async createCalibracao(data) {
      this.loading = true
      this.error = null
      try {
        const response = await axios.post('/api/calibracoes', data)
        this.calibracoes.unshift(response.data)
        return response.data
      } catch (error) {
        this.error = error.response?.data?.message || 'Erro ao criar calibração'
        throw error
      } finally {
        this.loading = false
      }
    },

    async updateCalibracao(id, data) {
      this.loading = true
      this.error = null
      try {
        const response = await axios.put(`/api/calibracoes/${id}`, data)
        const index = this.calibracoes.findIndex(c => c.id === id)
        if (index !== -1) this.calibracoes[index] = response.data
        this.calibracao = response.data
        return response.data
      } catch (error) {
        this.error = error.response?.data?.message || 'Erro ao atualizar calibração'
        throw error
      } finally {
        this.loading = false
      }
    },

    async deleteCalibracao(id) {
      this.loading = true
      this.error = null
      try {
        await axios.delete(`/api/calibracoes/${id}`)
        this.calibracoes = this.calibracoes.filter(c => c.id !== id)
      } catch (error) {
        this.error = error.response?.data?.message || 'Erro ao excluir calibração'
        throw error
      } finally {
        this.loading = false
      }
    },

    async uploadCertificado(id, file) {
      const formData = new FormData()
      formData.append('certificado', file)
      
      try {
        const response = await axios.post(`/api/calibracoes/${id}/upload-certificado`, formData, {
          headers: { 'Content-Type': 'multipart/form-data' }
        })
        return response.data
      } catch (error) {
        throw error
      }
    }
  }
})
