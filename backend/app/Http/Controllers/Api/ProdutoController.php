<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProdutoRequest;
use App\Models\Produto;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class ProdutoController extends Controller
{

    public function listaProdutos(): JsonResponse
    {
        $produtos = Produto::with('categoria')->get();

        if ($produtos->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Lista de produtos está vazia.'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $produtos
        ]);
    }


    public function criarProduto(ProdutoRequest $request): JsonResponse
    {
        try {
            $produto = Produto::create($request->validated());

            return response()->json([
                'status' => true,
                'message' => 'Produto criado com sucesso.',
                'data' => $produto,
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao criar o produto. Tente novamente.',
            ], 500);
        }
    }


    public function obterProduto(int $id): JsonResponse
    {
        try {
            $produto = Produto::with('categoria')->findOrFail($id);

            return response()->json([
                'status' => true,
                'data' => $produto->only('id', 'nome', 'descricao', 'categoria_id'),
            ]);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Produto não encontrado.',
            ], 404);
        }
    }


    public function atualizarProduto(ProdutoRequest $request, int $id): JsonResponse
    {
        try {
            $produto = Produto::findOrFail($id);

            if (Produto::where('nome', $request->name)->where('id', '!=', $id)->exists()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Já existe um produto com este nome.',
                ], 409);
            }

            $produto->update($request->only('nome', 'descricao', 'categoria_id'));

            return response()->json([
                'status' => true,
                'data' => $produto,
            ]);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Produto não encontrado.',
            ], 404);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao atualizar o produto. Tente novamente.',
            ], 500);
        }
    }


    public function deletarProduto(int $id): JsonResponse
    {
        try {
            $produto = Produto::findOrFail($id);
            $produto->delete();

            return response()->json([
                'status' => true,
                'message' => 'Produto deletado com sucesso.',
            ], 200);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Produto não encontrado.',
            ], 404);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao deletar o produto. Tente novamente.',
            ], 500);
        }
    }
}
