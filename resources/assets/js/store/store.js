import Vue from 'vue';
import Vuex from 'vuex';
import login from './modules/login'
import home from './modules/home'
import state from './modules/state'

Vue.use(Vuex);

export const store = new Vuex.Store({

    modules: {
        state,
        login,
        home
    },


});