<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoriaRequest;
use App\Models\Categoria;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class CategoriaController extends Controller
{

    public function listaCategorias(): JsonResponse
    {

        $categorias = Categoria::all();

        if ($categorias->isEmpty()) {
            return response()->json([
                'status' =>  false,
                'message' => 'Lista de categoria está vazia.'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $categorias,
        ]);
    }


    public function criarCategoria(CategoriaRequest $request): JsonResponse
    {
        try {
            $categoria = Categoria::create($request->validated());

            return response()->json([
                'status' => true,
                'message' => 'Categoria criada com sucesso',
                'data' => $categoria,
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao criar a categoria. Tente novamente.',
            ], 500);
        }
    }


    public function obterCategoria(int $id): JsonResponse
    {
        try {
            $categoria = Categoria::findOrFail($id);

            return response()->json([
                'status' => true,
                'data' => $categoria->only('id', 'nome'),
            ]);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Categoria não encontrada.',
            ], 404);
        }
    }


    public function atualizarCategoria(CategoriaRequest $request, int $id): JsonResponse
    {
        try {

            $categoria = Categoria::findOrFail($id);

            if (Categoria::where('nome', $request->nome)->where('id', '!=', $id)->exists()) {
                return response()->json([
                    'status' => false,
                    'message' => 'A categoria com este nome já existe.',
                ], 409);
            }

            $categoria->update($request->validated());

            return response()->json([
                'status' => true,
                'message' => 'Categoria atualizada com sucesso.',
                'data' => $categoria,
            ]);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Categoria não encontrada.',
            ], 404);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao atualizar a categoria. Tente novamente.',
            ], 500);
        }
    }


    public function deletarCategoria(int $id): JsonResponse
    {
        try {
            $categoria = Categoria::findOrFail($id);
            $categoria->delete();

            return response()->json([
                'status' => true,
                'message' => 'Categoria deletada com sucesso.',
                'data' => $categoria
            ], 200);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Categoria não encontrada.',
            ], 404);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao deletar a categoria. Tente novamente.',
            ], 500);
        }
    }
}
