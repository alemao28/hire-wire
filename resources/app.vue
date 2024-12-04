<template>
    <div id="app">
        <router-view :logout="logout"></router-view>
    </div>
</template>

<script>
import axios from 'axios';
export default {
    name: "AppComponent",
    mounted() {
        const token = localStorage.getItem("auth_token");

        if (token) {
            this.setAuthToken(token);
        } else {
            this.redirectToLogin();
        }
    },
    computed: {
        // Verifica se o usuário está autenticado
        isAuthenticated() {
            return !!localStorage.getItem("auth_token");
        }
    },
    methods: {
        setAuthToken(token) {
            axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
        },

        redirectToLogin() {
            this.$router.push({ name: "login" });
        },

        // Método de logout
        logout() {
            // Remove o token do localStorage
            localStorage.removeItem("auth_token");

            // Remove o token das configurações do Axios
            delete axios.defaults.headers.common["Authorization"];

            // Redireciona para a página de login
            this.redirectToLogin();
        },
    },
};
</script>

<style scoped>
/* Estilos globais, se necessário */
</style>