
import { createApp } from 'vue'
import { createPinia } from 'pinia'
import axios from 'axios';
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap' // Importa o JavaScript do Bootstrap

import App from './App.vue'
import router from './router'

const app = createApp(App)

app.use(createPinia())
app.use(router)

app.mount('#app')


axios.defaults.withCredentials = true;
axios.defaults.baseURL = 'http://127.0.0.1:8000/api';
