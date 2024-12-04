import { createApp } from 'vue';
import AppComponent  from '../app.vue';
import router from '../router';
import 'bootstrap/dist/css/bootstrap.min.css';
import VueMask from "vue-the-mask";

const appInstance  = createApp(AppComponent);
appInstance.use(VueMask);
appInstance.use(router);
appInstance.mount('#app');

