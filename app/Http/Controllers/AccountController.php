<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    // Listar contas do usuário
    public function index(Request $request)
    {
        $user = Auth::user(); // Obter usuário autenticado

        if ($user) {
            $accounts = Account::where('user_id', $user->id)->get(); // Obter contas do usuário
            return response()->json(['accounts' => $accounts], 200); // Retorna as contas no formato JSON
        }

        return response()->json(['error' => 'Unauthorized'], 401); // Se não encontrar o usuário, retorna 401
    }

    // Exibir a primeira conta do usuário autenticado
    public function getAccount(Request $request)
    {
        $user = Auth::user(); // Obtém o usuário autenticado

        // Caso tenha conta associada
        $account = Account::where('user_id', $user->id)->first();

        if (!$account) {
            return response()->json(['message' => 'Nenhuma conta encontrada para este usuário.'], 404);
        }

        return response()->json(['account' => $account], 200);
    }

    // Realizar depósito
    public function deposit(Request $request, Account $account)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
        ]);

        if ($account->user_id !== Auth::id()) {
            return response()->json(['message' => 'Acesso não autorizado'], 403);
        }

        $amount = $validated['amount'];

        // Aplicar incremento para contas correntes e de investimentos
        if (in_array($account->type, ['corrente', 'investimentos'])) {
            $amount += 0.50;
        }

        $account->balance += $amount;
        $account->save();

        return response()->json(['message' => 'Depósito realizado com sucesso!', 'account' => $account]);
    }

    // Consultar saldo
    public function balance(Account $account)
    {
        if ($account->user_id !== Auth::id()) {
            return response()->json(['message' => 'Acesso não autorizado'], 403);
        }

        return response()->json(['balance' => $account->balance]);
    }

    public function applyMonthlyCorrection()
    {
        try {
            DB::transaction(function () {
                $accounts = Account::all(); // Obtém todas as contas

                foreach ($accounts as $account) {
                    $correction = 0;

                    // Calcula a correção com base no tipo de conta
                    switch ($account->type) {
                        case 'poupanca':
                            $correction = $account->balance * 0.00001; // 0,001%
                            break;
                        case 'corrente':
                            $correction = $account->balance * 0.001; // 0,1%
                            break;
                        case 'investimentos':
                            $correction = $account->balance * 0.001; // 0,1%
                            break;
                    }

                    // Aplica a correção
                    $account->balance += $correction;
                    $account->save();
                }
            });

            return response()->json(['message' => 'Correção monetária aplicada com sucesso.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao aplicar correção monetária: ' . $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        $user = Auth::user();
    
        // Valida os dados da requisição
        $validated = $request->validate([
            'type' => 'required|in:poupanca,corrente,investimentos',
        ]);
    
        // Verifica se o usuário já possui uma conta do mesmo tipo
        if ($user->accounts()->where('type', $validated['type'])->exists()) {
            return response()->json([
                'message' => 'Você já possui uma conta do tipo ' . $validated['type'] . '.',
            ], 400);
        }
    
        // Verifica se o número total de contas do usuário já atingiu o limite de 3
        if ($user->accounts()->count() >= 3) {
            return response()->json([
                'message' => 'Você já atingiu o limite máximo de 3 contas.',
            ], 400);
        }
    
        // Cria a nova conta
        $account = new Account();
        $account->user_id = $user->id;
        $account->type = $validated['type'];
        $account->balance = 0.00; // Saldo inicial
        $account->save();
    
        return response()->json([
            'message' => 'Conta criada com sucesso!',
            'account' => $account
        ], 201);
    }
    
}
