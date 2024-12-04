<template>
    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="card shadow" style="width: 400px;">
            <div class="card-header text-center">
                <h3>Cadastro de Usuário</h3>
            </div>
            <div class="card-body">
                <form @submit.prevent="submitForm">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nome</label>
                        <input v-model="name" type="text" class="form-control" id="name" placeholder="Digite seu nome"
                            required />
                    </div>
                    <div class="mb-3">
                        <label for="cpf" class="form-label">CPF</label>
                        <input v-model="cpf" required v-mask="'###.###.###-##'" type="text"
                            class="form-control" id="cpf" placeholder="Digite seu CPF" />
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input v-model="email" type="email" class="form-control" id="email"
                            placeholder="Digite seu e-mail" required />
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Senha</label>
                        <input v-model="password" type="password" class="form-control" id="password"
                            placeholder="Digite sua senha" required />
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirmar Senha</label>
                        <input v-model="password_confirmation" type="password" class="form-control"
                            id="password_confirmation" placeholder="Confirme sua senha" required />
                    </div>
                    <div v-if="message" class="alert alert-warning mt-2">{{ message }}</div>
                    <button type="submit" class="btn btn-primary w-100">Cadastrar</button>
                </form>
                <p class="mt-3 text-center">
                    Já tem uma conta? <router-link to="/">Faça login</router-link>
                </p>
            </div>
        </div>
    </div>
</template>

<script src="./CadastroUser.js" />
