import { createApp } from "vue";
import { createPinia } from "pinia";
import axios from "axios";
import router from "./router";
import Dashboard from "./components/Dashboard.vue";

// Configurar Axios
axios.defaults.baseURL = window.location.origin;
axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
axios.defaults.headers.common["Accept"] = "application/json";

const app = createApp(Dashboard);
const pinia = createPinia();

app.use(pinia);
app.use(router);

app.mount("#vue-root");
