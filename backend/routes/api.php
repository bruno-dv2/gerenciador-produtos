<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoriaController;
use App\Http\Controllers\Api\ImagemController;
use App\Http\Controllers\Api\ProdutoController;
use Illuminate\Support\Facades\Route;


Route::post('/upload-imagem', [ImagemController::class, 'uploadImagem']);


Route::post('/registrar', [AuthController::class, 'registrar']);

Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');



Route::prefix('/categorias')->middleware('auth:sanctum')->group(function () {

    Route::get('/', [CategoriaController::class, 'listaCategorias']);

    Route::post('/', [CategoriaController::class, 'criarCategoria']);

    Route::get('/{id}', [CategoriaController::class, 'obterCategoria']);

    Route::put('/{id}', [CategoriaController::class, 'atualizarCategoria']);

    Route::delete('/{id}', [CategoriaController::class, 'deletarCategoria']);
});



Route::prefix('/produtos')->middleware('auth:sanctum')->group(function () {

    Route::get('/', [ProdutoController::class, 'listaProdutos']);

    Route::post('/', [ProdutoController::class, 'criarProduto']);

    Route::get('/{id}', [ProdutoController::class, 'obterProduto']);

    Route::put('/{id}', [ProdutoController::class, 'atualizarProduto']);

    Route::delete('/{id}', [ProdutoController::class, 'deletarProduto']);
});
