<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImagemRequest;
use App\Models\Imagem;
use Illuminate\Http\Request;
use Exception;

class ImagemController extends Controller
{
    public function uploadImagem(ImagemRequest $request)
    {
        try {
            $file = $request->file('imagem');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('imagens'), $filename);

            $imagem = Imagem::create([
                'imagem_id' => $request->imagem_id,
                'imagem_type' => $request->imagem_type,
                'filename' => $filename,
                'url' => asset('imagens/' . $filename),
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Imagem upload com sucesso.',
                'data' => $imagem,
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao fazer upload da imagem'
            ], 500);
        }
    }
}
