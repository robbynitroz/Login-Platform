require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
import { authRoutes } from './routes/router'


Vue.use(VueRouter);


export const router = new VueRouter({
    mode: 'history',
    authRoutes,
});


const login = resolve => {
    require.ensure(['./components/platform/Login.vue'], () => {
        resolve(require('./components/platform/Login.vue'));
    });
};




new Vue({
    el: '#app',
    router,
    components:{
        login
    }
});

