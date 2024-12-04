<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Account; 

class UserController extends Controller
{
    // Exibir dados do usuário autenticado
    public function show(Request $request)
    {
        return response()->json($request->user(), 200);
    }

    // Exibir as contas do usuário
    public function getAccount(Request $request)
    {
        $user = Auth::user();  // Obtém o usuário autenticado

        // Caso tenha conta associada
        $account = Account::where('user_id', $user->id)->first();

        // Retorna as informações da conta
        return response()->json(['account' => $account], 200);
    }
}