import { createRouter, createWebHistory } from 'vue-router';
import HomeView from '../components/HomeView.vue';
import Login from '../components/LoginForm.vue';
import Registro from '../components/RegistroForm.vue';
import Produtos from '../components/ProdutosForm.vue';

const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView,
  },
  {
    path: '/login',
    name: 'login',
    component: Login,
  },
  {
    path: '/registro',
    name: 'registro',
    component: Registro,
  },
  {
    path: '/produtos',
    name: 'produtos',
    component: Produtos,
  },
];

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
});

export default router;
