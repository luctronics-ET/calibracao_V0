import { createRouter, createWebHistory } from "vue-router";
import DashboardHome from "../pages/DashboardHome.vue";
import EquipamentosList from "../pages/EquipamentosList.vue";
import EquipamentosForm from "../pages/EquipamentosForm.vue";
import EquipamentosView from "../pages/EquipamentosView.vue";
import CalibracoesList from "../pages/CalibracoesList.vue";
import CalibracaoForm from "../pages/CalibracaoForm.vue";
import CalibracaoView from "../pages/CalibracaoView.vue";
import LotesList from "../pages/LotesList.vue";
import LoteForm from "../pages/LoteForm.vue";
import LoteView from "../pages/LoteView.vue";
import LaboratoriosList from "../pages/LaboratoriosList.vue";
import LaboratorioForm from "../pages/LaboratorioForm.vue";

const routes = [
  {
    path: "/vue",
    redirect: "/vue/dashboard",
  },
  {
    path: "/vue/dashboard",
    name: "dashboard",
    component: DashboardHome,
  },
  // Equipamentos
  {
    path: "/vue/equipamentos",
    name: "equipamentos.list",
    component: EquipamentosList,
  },
  {
    path: "/vue/equipamentos/novo",
    name: "equipamentos.create",
    component: EquipamentosForm,
  },
  {
    path: "/vue/equipamentos/:id",
    name: "equipamentos.view",
    component: EquipamentosView,
    props: true,
  },
  {
    path: "/vue/equipamentos/:id/editar",
    name: "equipamentos.edit",
    component: EquipamentosForm,
    props: true,
  },
  // Calibrações
  {
    path: "/vue/calibracoes",
    name: "calibracoes.list",
    component: CalibracoesList,
  },
  {
    path: "/vue/calibracoes/nova",
    name: "calibracoes.create",
    component: CalibracaoForm,
  },
  {
    path: "/vue/calibracoes/:id",
    name: "calibracoes.view",
    component: CalibracaoView,
    props: true,
  },
  {
    path: "/vue/calibracoes/:id/editar",
    name: "calibracoes.edit",
    component: CalibracaoForm,
    props: true,
  },
  // Lotes
  {
    path: "/vue/lotes",
    name: "lotes.list",
    component: LotesList,
  },
  {
    path: "/vue/lotes/novo",
    name: "lotes.create",
    component: LoteForm,
  },
  {
    path: "/vue/lotes/:id",
    name: "lotes.view",
    component: LoteView,
    props: true,
  },
  {
    path: "/vue/lotes/:id/editar",
    name: "lotes.edit",
    component: LoteForm,
    props: true,
  },
  // Laboratórios
  {
    path: "/vue/laboratorios",
    name: "laboratorios.list",
    component: LaboratoriosList,
  },
  {
    path: "/vue/laboratorios/novo",
    name: "laboratorios.create",
    component: LaboratorioForm,
  },
  {
    path: "/vue/laboratorios/:id/editar",
    name: "laboratorios.edit",
    component: LaboratorioForm,
    props: true,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
