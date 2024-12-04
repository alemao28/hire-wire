import axios from 'axios';
import './Login.css';

export default {
    data() {
      return {
        email: '',
        password: '',
        message: '',
      };
    },
    methods: {
      async login() {
        try {
          // Requisição para autenticar o usuário
          const response = await axios.post('/api/login', {
            email: this.email,
            password: this.password,
          });
  
          // Armazenando o token de autenticação
          localStorage.setItem('auth_token', response.data.token);
  
          this.$router.push({ name: 'dashboard' });
        } catch (error) {
          // Exibe mensagem de erro caso algo dê errado
          this.message = 'E-mail ou senha inválidos. Tente novamente.';
        }
      },
    },
  };