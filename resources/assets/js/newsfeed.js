require('./bootstrap');

import Vue from 'vue';
import BootstrapVue from 'bootstrap-vue';

import MainPage from './components/newsfeed/MainPage.vue'

Vue.use(BootstrapVue);


new Vue({
    el: '#app',
    components:{
        MainPage
    }
});


