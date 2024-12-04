import { createRouter, createWebHistory } from 'vue-router';
import Login from './js/components/Login/Login.vue';
import CadastroUser from './js/components/CadastroUser/CadastroUser.vue';
import Dashboard from './js/components/Dashboard/Dashboard.vue';

const routes = [
    {
        path: "/dashboard",
        name: "dashboard",
        component: Dashboard,
        // beforeEnter: (to, from, next) => {
        //     if (!localStorage.getItem("auth_token")) {
        //         next({ name: "login" }); 
        //     } else {
        //         next(); 
        //     }
        // },
    },
    {
        path: '/',
        name: 'login',
        component: Login,
    },
    {
        path: '/cadastro',
        name: 'cadastro',
        component: CadastroUser,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
