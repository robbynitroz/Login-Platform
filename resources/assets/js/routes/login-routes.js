const platformLogin = resolve => {
    require.ensure(['../components/platform/Login.vue'], () => {
        resolve(require('../components/platform/Login.vue'));
    });
};

const platformResetPassword = resolve => {
    require.ensure(['../components/platform/EmailPassword.vue'], () => {
        resolve(require('../components/platform/EmailPassword.vue'));
    });
};

const Welcome = resolve => {
    require.ensure(['../components/platform/Welcome.vue'], () => {
        resolve(require('../components/platform/Welcome.vue'));
    });
};



export const routes = [
    {path: '/', component: Welcome},
    {path: '/login', component: platformLogin},
    {path: '/password/reset', component: platformResetPassword},


];

