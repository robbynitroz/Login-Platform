/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
import { routes } from './routes/client-routes'
import store from './store/store-clients-login';

Vue.use(VueRouter);


const router = new VueRouter({
    mode: 'history',
    routes,
})




new Vue({
    el: '#app',
    store,
    router,
});





