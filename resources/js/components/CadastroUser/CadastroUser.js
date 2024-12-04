import axios from 'axios';
import './CadastroUser.css';
import { cpf } from 'cpf-cnpj-validator';

// export default {
//     data() {
//         return {
//             name: '',
//             cpf: '',
//             email: '',
//             password: '',
//             password_confirmation: '',
//             message: '',
//         };
//     },
//     methods: {
//         submitForm() {
//             axios
//                 .post('/api/register', {
//                     name: this.name,
//                     cpf: this.cpf,
//                     email: this.email,
//                     password: this.password,
//                     password_confirmation: this.password_confirmation,
//                 })
//                 .then((response) => {
//                     this.message = 'Usuário cadastrado com sucesso!';
//                 })
//                 .catch((error) => {
//                     this.message = 'Erro no cadastro: ' + error.response.data.errors;
//                 });
//         },
//     },
// };

export default {
    data() {
        return {
            name: '',
            cpf: '',
            email: '',
            password: '',
            password_confirmation: '',
            message: '',
        };
    },
    methods: {
        validarCPF(cpfNumber) {
            if (cpfNumber.length == 14 && cpf.isValid(cpfNumber)) {
                return true; // CPF válido
            } else {
                return false; // CPF inválido
            }
        },
        validateForm() {
            // Verificando se a senha e a confirmação da senha são iguais
            if (this.password !== this.password_confirmation) {
                this.message = 'As senhas não coincidem!';
                return false;
            }
            if (!this.validarCPF(this.cpf)) {
                this.message = 'CPF inválido!';
                return false;
            }
            if (this.password.length < 8) {
                this.message = 'A senha deve ter pelo menos 8 caracteres.';
                return false;
            }
            this.message = '';
            return true;
        },
        async submitForm() {
            if (!this.validateForm()) {
                return;
            }

            try {
                const response = await axios.post('/api/register', {
                    name: this.name,
                    cpf: this.cpf,
                    email: this.email,
                    password: this.password,
                    password_confirmation: this.password_confirmation,
                });
         
                localStorage.setItem('auth_token', response.data.token);
                this.message = 'Cadastro realizado com sucesso!';
                this.$router.push({ name: 'dashboard' });
            } catch (error) {
                if (error.response && error.response.data && error.response.data.message) {
                    this.message = error.response.data.message;
                } else {
                    this.message = 'Erro ao cadastrar. Tente novamente.';
                }
            }
        },
    },
};