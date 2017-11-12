const Login = resolve => {
    require.ensure(['../components/platform/Login.vue'], () => {
        resolve(require('../components/platform/Login.vue'));
    });
};

const EmailPassword = resolve => {
    require.ensure(['../components/platform/EmailPassword.vue'], () => {
        resolve(require('../components/platform/EmailPassword.vue'));
    });
};

const Welcome = resolve => {
    require.ensure(['../components/platform/Welcome.vue'], () => {
        resolve(require('../components/platform/Welcome.vue'));
    });
};

const resetPassword = resolve => {
    require.ensure(['../components/platform/ResetPassword.vue'], () => {
        resolve(require('../components/platform/ResetPassword.vue'));
    });
};

export const routes = [
    {path: '/', component: Welcome},
    {path: '/login', component: Login},
    {path: '/password/reset', component: EmailPassword},
    {path: '/password/reset/:token', component: resetPassword}
];

