<template>
  <div class="container mt-5">
    <h1 class="mb-4">Cadastrar Categoria e Produto</h1>
    <form @submit.prevent="cadastrarCategoriaEProduto">
      <div class="mb-3">
        <input
          type="text"
          v-model="nomeCategoria"
          class="form-control"
          placeholder="Nome da Categoria"
          required
        />
      </div>
      <div class="mb-3">
        <input
          type="text"
          v-model="nomeProduto"
          class="form-control"
          placeholder="Nome do Produto"
          required
        />
      </div>
      <div class="mb-3">
        <input
          type="text"
          v-model="descricaoProduto"
          class="form-control"
          placeholder="Descrição do Produto"
          required
        />
      </div>
      <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>

    <div v-if="mensagem" :class="['alert', erro ? 'alert-danger' : 'alert-success']">
      {{ mensagem }}
    </div>
  </div>
</template>

<script lang="ts">
import { ref } from 'vue';
import axios from 'axios';

export default {
  setup() {
    const nomeCategoria = ref('');
    const nomeProduto = ref('');
    const descricaoProduto = ref('');
    const mensagem = ref('');
    const erro = ref(false);

    const cadastrarCategoriaEProduto = async () => {
      try {
        const categoriaResponse = await axios.post('/categorias', {
          nome: nomeCategoria.value,
        });

        if (categoriaResponse.data.status) {
          const produtoResponse = await axios.post('/produtos', {
            nome: nomeProduto.value,
            descricao: descricaoProduto.value,
            categoria_id: categoriaResponse.data.data.id,
          });

          if (produtoResponse.data.status) {
            mensagem.value = 'Categoria e Produto criados com sucesso!';
            erro.value = false;
            nomeCategoria.value = '';
            nomeProduto.value = '';
            descricaoProduto.value = '';
          }
        }
      } catch (error) {
        mensagem.value = error.response?.data?.message || 'Erro ao criar categoria ou produto.';
        erro.value = true;
      }
    };

    return {
      nomeCategoria,
      nomeProduto,
      descricaoProduto,
      mensagem,
      erro,
      cadastrarCategoriaEProduto,
    };
  },
};
</script>

<style scoped>
</style>
