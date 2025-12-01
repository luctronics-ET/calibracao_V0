<template>
  <div class="dashboard-layout">
    <!-- Sidebar -->
    <aside class="sidebar">
      <div class="logo">
        <i class="fas fa-tools"></i>
        <span>Sistema IGP</span>
      </div>
      
      <nav class="nav-menu">
        <router-link to="/vue/dashboard" class="nav-item" exact-active-class="active">
          <i class="fas fa-home"></i>
          <span>Dashboard</span>
        </router-link>
        
        <router-link to="/vue/equipamentos" class="nav-item" active-class="active">
          <i class="fas fa-cogs"></i>
          <span>Equipamentos</span>
        </router-link>
        
        <router-link to="/vue/calibracoes" class="nav-item" active-class="active">
          <i class="fas fa-certificate"></i>
          <span>Calibrações</span>
        </router-link>
        
        <router-link to="/vue/lotes" class="nav-item" active-class="active">
          <i class="fas fa-box"></i>
          <span>Lotes de Envio</span>
        </router-link>
        
        <router-link to="/vue/laboratorios" class="nav-item" active-class="active">
          <i class="fas fa-flask"></i>
          <span>Laboratórios</span>
        </router-link>

        <router-link to="/vue/locais" class="nav-item" active-class="active">
          <i class="fas fa-map-marker-alt"></i>
          <span>Locais</span>
        </router-link>

        <router-link to="/vue/transportes" class="nav-item" active-class="active">
          <i class="fas fa-truck"></i>
          <span>Transportes</span>
        </router-link>

        <router-link to="/vue/padroes" class="nav-item" active-class="active">
          <i class="fas fa-ruler"></i>
          <span>Padrões</span>
        </router-link>
        
        <router-link to="/vue/relatorios" class="nav-item" active-class="active">
          <i class="fas fa-chart-bar"></i>
          <span>Relatórios</span>
        </router-link>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
      <router-view />
    </main>
  </div>
</template>

<script>
export default {
  name: 'Dashboard'
}
</script>

<style scoped>
.dashboard-layout {
  display: flex;
  min-height: 100vh;
}

.sidebar {
  width: 260px;
  background: #1f2937;
  color: white;
  padding: 24px 0;
  position: fixed;
  height: 100vh;
  overflow-y: auto;
}

.logo {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 0 24px;
  margin-bottom: 32px;
}

.logo i {
  font-size: 28px;
  color: #3b82f6;
}

.logo span {
  font-size: 20px;
  font-weight: 700;
}

.nav-menu {
  display: flex;
  flex-direction: column;
  gap: 4px;
}

.nav-item {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 12px 24px;
  color: #d1d5db;
  text-decoration: none;
  transition: all 0.2s;
}

.nav-item:hover {
  background: rgba(255, 255, 255, 0.05);
  color: white;
}

.nav-item.active {
  background: rgba(59, 130, 246, 0.2);
  color: #3b82f6;
  border-left: 3px solid #3b82f6;
}

.nav-item i {
  font-size: 18px;
  width: 20px;
}

.main-content {
  flex: 1;
  margin-left: 260px;
  background: #f3f4f6;
  min-height: 100vh;
}
</style>
