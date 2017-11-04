require('./bootstrap');

import Vue from 'vue';



const login = resolve => {
    require.ensure(['./components/platform/Login.vue'], () => {
        resolve(require('./components/platform/Login.vue'));
    });
};



new Vue({
    el: '#app',
    components:{
        login,
    }
});

