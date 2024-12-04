<template>
    <div class="container my-5">
        <h1 class="text-center mb-4">Dashboard</h1>
        <!-- Botão de Logout -->
        <div class="d-flex justify-content-end mb-4">
            <button class="btn btn-danger" @click="logout">
                Logout
            </button>
        </div>


        <!-- Carregando -->
        <div v-if="loading" class="text-center">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Carregando...</span>
            </div>
        </div>

        <!-- Criação de Conta -->
        <div v-else>
            <h2 class="mb-4">Suas Contas</h2>
            <button v-if="canCreateAccount" class="btn btn-success mb-4"
                @click="showCreateAccountForm = !showCreateAccountForm">
                Criar Nova Conta
            </button>

            <!-- Formulário de Criação de Conta -->
            <div v-if="showCreateAccountForm" class="card mb-4 p-3">
                <h5 class="card-title">Criar Nova Conta</h5>
                <form @submit.prevent="createAccount">
                    <div class="mb-3">
                        <label for="accountType" class="form-label">Tipo de Conta</label>
                        <select v-model="newAccount.type" class="form-select" id="accountType" required>
                            <option value="poupanca">Conta Poupança</option>
                            <option value="corrente">Conta Corrente</option>
                            <option value="investimentos">Conta Investimentos</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Criar Conta</button>
                </form>
            </div>

            <!-- Lista de Contas -->
            <div v-if="accounts && Array.isArray(accounts) && accounts.length">
                <div class="row g-3">
                    <div class="col-md-4" v-for="account in accounts" :key="account.id">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title text-capitalize">
                                    {{ account.type }}
                                </h5>
                                <p v-if="!visibleBalances[account.id]" class="blurred-balance">
                                    R$ ******
                                </p>
                                <p v-else class="card-text">
                                    <strong>Saldo:</strong> R$ {{ parseFloat(account.balance || 0).toFixed(2) }}
                                </p>
                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-primary btn-sm" @click="deposit(account.id)">
                                        Depositar
                                    </button>
                                    <!-- <button class="btn btn-secondary btn-sm" @click="checkBalance(account.id)">
                                        Consultar Saldo
                                    </button> -->
                                    <button class="btn btn-secondary btn-sm" @click="toggleBalance(account.id)">
                                        {{ visibleBalances[account.id] ? 'Esconder Saldo' : 'Ver Saldo' }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Mensagem de Feedback -->
            <div v-if="message" class="alert alert-info mt-4">
                {{ message }}
            </div>
        </div>
    </div>
</template>


<script src="./Dashboard.js" />