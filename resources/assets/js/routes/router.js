const loginHome = resolve => {
    require.ensure(['../components/clients/Home.vue'], () => {
        resolve(require('../components/clients/Home.vue'));
    });
};




export const routes = [
    {path: '/clients', component: loginHome },

];


const login = resolve => {
    require.ensure(['../components/platform/Login.vue'], () => {
        resolve(require('../components/platform/Login.vue'));
    });
};


export const authRoutes = [
    {path: '/login', component: login },

]
