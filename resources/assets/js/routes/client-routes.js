const loginHome = resolve => {
    require.ensure(['../components/clients/Home.vue'], () => {
        resolve(require('../components/clients/Home.vue'));
    });
};



export const routes = [
    {path: '/clients', component: loginHome},

];



