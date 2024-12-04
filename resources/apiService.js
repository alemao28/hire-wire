import axios from 'axios';

// Configuração do Axios
const api = axios.create({
    baseURL: 'http://localhost:8000/api', // URL da API Laravel
    headers: {
        'Accept': 'application/json',
    },
});

// Adicionar o token do usuário
api.interceptors.request.use(config => {
    const token = localStorage.getItem('token'); // Token armazenado
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
});

export default api;
