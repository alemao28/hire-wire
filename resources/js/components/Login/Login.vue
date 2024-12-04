<template>
    <div class="container-fluid d-flex justify-content-center align-items-center" style="height: 100vh;">
      <div class="card shadow" style="width: 400px;">
        <div class="card-header text-center">
          <h3>Login</h3>
        </div>
        <div class="card-body">
          <form @submit.prevent="login">
            <div class="mb-3">
              <label for="email" class="form-label">E-mail</label>
              <input v-model="email" type="email" class="form-control" id="email" placeholder="Digite seu e-mail" required />
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Senha</label>
              <input v-model="password" type="password" class="form-control" id="password" placeholder="Digite sua senha" required />
            </div>
            <div v-if="message" class="alert alert-danger mt-2">{{ message }}</div>
            <button type="submit" class="btn btn-primary w-100">Entrar</button>
          </form>
          <p class="mt-3 text-center">
            Não tem uma conta? <router-link to="/cadastro">Cadastre-se</router-link>
          </p>
        </div>
      </div>
    </div>
  </template>
  
  <script src="./Login.js" />
  