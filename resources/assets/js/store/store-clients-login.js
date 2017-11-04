import Vue from 'vue';
import Vuex from 'vuex';
import login from './modules/clients-login/login'
import home from './modules/clients-login/home'


Vue.use(Vuex);

export default new Vuex.Store({

    modules: {
            login,
            home
    },

});