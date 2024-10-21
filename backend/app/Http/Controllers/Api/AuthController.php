<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UsuarioRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function registrar(UsuarioRequest $request)
    {
        try {
            $usuario = User::create([
                'name' => $request->nome,
                'email' => $request->email,
                'password' => Hash::make($request->senha),
            ]);

            $token = $usuario->createToken($usuario->name)->plainTextToken;

            return response()->json([
                'status' => true,
                'message' => 'Usuário registrado com sucesso.',
                'data' => [
                    'usuario' => $usuario,
                    'token' => $token
                ]
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao registrar o usuário'
            ], 500);
        }
    }


    public function login(Request $request)
    {
        try {
            $usuario = User::where('email', $request->email)->first();

            if (!$usuario || !Hash::check($request->senha, $usuario->password)) {
                return response()->json([
                    'status' => false,
                    'message' => 'As informações fornecidas estão incorretas.'
                ], 401);
            }

            $token = $usuario->createToken($usuario->name)->plainTextToken;

            return response()->json([
                'status' => true,
                'message' => 'Login realizado com sucesso.',
                'data' => [
                    'usuario' => $usuario,
                    'token' => $token
                ]
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao realizar login.'
            ], 500);
        }
    }


    public function logout(Request $request)
    {
        try {
            $request->user()->tokens()->delete();

            return response()->json([
                'status' => true,
                'message' => 'Sessão encerrada com sucesso.'
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao encerrar a sessão.'
            ], 500);
        }
    }
}
