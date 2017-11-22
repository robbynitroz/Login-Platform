const Dashboard = resolve => {
    require.ensure(['../components/dashboard/Dashboard.vue'], () => {
        resolve(require('../components/dashboard/Dashboard.vue'));
    });
};



export const routes = [
    {path: '/dashboard', component: Dashboard},

];