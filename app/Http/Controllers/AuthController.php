<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Remover a máscara do CPF
        $cpf = preg_replace('/[^0-9]/', '', $request->cpf);

        $existingUser = User::where('cpf', $cpf)->first();

        if ($existingUser) {
            return response()->json(['message' => 'Este CPF já está cadastrado.'], 400);
        }

        // Validação de CPF e E-mail únicos
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'cpf' => 'required|unique:users',  // Validação de CPF
            'email' => 'required|string|email|max:255|unique:users',  // Validação de E-mail
            'password' => 'required|string|min:8|confirmed',  // Senha com confirmação
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $user = User::create([
            'name' => $request->name,
            'cpf' => $cpf,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Gerar o token de autenticação
        $token = $user->createToken('AppToken')->accessToken;

        return response()->json(['message' => 'Usuário cadastrado com sucesso!', 'token' => $token, 'user' => $user], 201);
    }

    public function login(Request $request)
    {
        // Validação dos dados de entrada
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Credenciais para autenticação
        $credentials = $request->only('email', 'password');

        // Tentar autenticar o usuário
        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Credenciais inválidas'], 401);
        }

        // Gerar token de acesso para o usuário autenticado
        $user = Auth::user();
        $token = $user->createToken('AppToken')->accessToken;  // Gerando o token

        // Retornar resposta com token
        return response()->json([
            'message' => 'Login bem-sucedido',
            'token' => $token,  // Retorna o token gerado
            'user' => $user,    // Retorna as informações do usuário
        ], 200);
    }
}
