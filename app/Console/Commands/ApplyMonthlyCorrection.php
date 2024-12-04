<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Account;

class ApplyMonthlyCorrection extends Command
{
    protected $signature = 'accounts:apply-correction';
    protected $description = 'Aplica a correção monetária mensal às contas.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Iniciando correção monetária...');
        $accounts = Account::all();

        foreach ($accounts as $account) {
            $correction = 0;

            switch ($account->type) {
                case 'poupanca':
                    $correction = $account->balance * 0.00001;
                    break;
                case 'corrente':
                    $correction = $account->balance * 0.001;
                    break;
                case 'investimentos':
                    $correction = $account->balance * 0.001;
                    break;
            }

            $account->balance += $correction;
            $account->save();
        }

        $this->info('Correção monetária aplicada com sucesso.');
    }
}
