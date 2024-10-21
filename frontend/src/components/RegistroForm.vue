<template>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-4">
        <h2 class="text-center">Cadastro</h2>
        <form @submit.prevent="registrar">
          <div class="form-group mb-3">
            <input v-model="nome" class="form-control" type="text" placeholder="Nome" required />
          </div>
          <div class="form-group mb-3">
            <input v-model="email" class="form-control" type="email" placeholder="Email" required />
          </div>
          <div class="form-group mb-3">
            <input v-model="senha" class="form-control" type="password" placeholder="Senha" required />
          </div>
          <button type="submit" class="btn btn-primary w-100">Cadastrar</button>
          <p v-if="errorMessage" class="text-danger mt-3">{{ errorMessage }}</p>
        </form>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { ref } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

export default {
  setup() {
    const nome = ref('');
    const email = ref('');
    const senha = ref('');
    const errorMessage = ref('');
    const router = useRouter();

    const setCsrfToken = async () => {
      await axios.get('http://127.0.0.1:8000/sanctum/csrf-cookie');
    };

    const registrar = async () => {
      try {
        await setCsrfToken();

        const response = await axios.post('http://127.0.0.1:8000/api/registrar', {
          nome: nome.value,
          email: email.value,
          senha: senha.value,
        });

        console.log('Registro com sucesso:', response.data);
        router.push({ name: 'home' }); // Redirecionar após o registro
      } catch (error: any) {
        console.error('Erro no registro:', error.response?.data);
        if (error.response) {
          errorMessage.value = error.response.data.message || 'Erro no registro.';
        } else {
          errorMessage.value = 'Erro ao conectar com a API.';
        }
      }
    };

    return {
      nome,
      email,
      senha,
      registrar,
      errorMessage,
    };
  },
};
</script>
