<template>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-4">
        <h2 class="text-center">Entrar</h2>
        <form @submit.prevent="login">
          <div class="form-group mb-3">
            <input v-model="nome" class="form-control" type="text" placeholder="Nome" required />
          </div>
          <div class="form-group mb-3">
            <input v-model="email" class="form-control" type="email" placeholder="Email" required />
          </div>
          <div class="form-group mb-3">
            <input v-model="senha" class="form-control" type="password" placeholder="Senha" required />
          </div>
          <button type="submit" class="btn btn-primary w-100">Acessar</button>
          <p v-if="errorMessage" class="text-danger mt-3">{{ errorMessage }}</p>
        </form>
      </div>
    </div>
  </div>
</template>


<script lang="ts">

import { useRouter } from 'vue-router'
import { ref } from 'vue'
import axios from 'axios'

export default {
  setup() {
    const nome = ref('')
    const email = ref('')
    const senha = ref('')
    const errorMessage = ref('')
    const router = useRouter()

    const setCsrfToken = async () => {
      await axios.get('http://127.0.0.1:8000/sanctum/csrf-cookie')
    }

    const loading = ref(false);

    const login = async () => {
      loading.value = true;
      errorMessage.value = '';
      try {
        await setCsrfToken();
        const response = await axios.post('/login', {
            nome: nome.value,
            email: email.value,
            senha: senha.value,
        });
        console.log('Login com sucesso:', response.data);
        router.push({ name: 'home' });
      } catch (error: any) {
        console.error('Erro no login:', error.response?.data);
        if (error.response) {
            errorMessage.value = error.response.data.message || 'Erro no login.';
        } else {
            errorMessage.value = 'Erro ao conectar com a API.';
        }
      } finally {
        loading.value = false;
      }
    };

    return {
      nome,
      email,
      senha,
      login,
      errorMessage,
    }
  }
}

</script>
