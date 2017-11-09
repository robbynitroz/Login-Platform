const platformLogin = resolve => {
    require.ensure(['../components/platform/Login.vue'], () => {
        resolve(require('../components/platform/Login.vue'));
    });
};

const platformResetPassword = resolve => {
    require.ensure(['../components/platform/RestorePassword.vue'], () => {
        resolve(require('../components/platform/RestorePassword.vue'));
    });
};



export const routes = [
    {path: '/login', component: platformLogin},
    {path: '/password/reset', component: platformResetPassword},


];
