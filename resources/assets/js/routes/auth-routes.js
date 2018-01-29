const Login = resolve => {
    require.ensure(['../components/auth/Login.vue'], () => {
        resolve(require('../components/auth/Login.vue'));
    });
};

const EmailPassword = resolve => {
    require.ensure(['../components/auth/EmailPassword.vue'], () => {
        resolve(require('../components/auth/EmailPassword.vue'));
    });
};

const Welcome = resolve => {
    require.ensure(['../components/auth/Welcome.vue'], () => {
        resolve(require('../components/auth/Welcome.vue'));
    });
};

const resetPassword = resolve => {
    require.ensure(['../components/auth/ResetPassword.vue'], () => {
        resolve(require('../components/auth/ResetPassword.vue'));
    });
};

const emailList = resolve => {
    require.ensure(['../components/auth/EmailList.vue'], () => {
        resolve(require('../components/auth/EmailList.vue'));
    });
};

export const routes = [
    {path: '/', component: Welcome},
    {path: '/login', component: Login},
    {path: '/password/reset', component: EmailPassword},
    {path: '/password/reset/:token', component: resetPassword},
    {path: '/emails', component: emailList}
];

