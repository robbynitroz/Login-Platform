const Dashboard = resolve => {
    require.ensure(['../components/dashboard/Dashboard.vue'], () => {
        resolve(require('../components/dashboard/Dashboard.vue'));
    });
};

const Home = resolve => {
    require.ensure(['../components/dashboard/Home.vue'], () => {
        resolve(require('../components/dashboard/Home.vue'));
    });
};


const Hotels = resolve => {
    require.ensure(['../components/dashboard/Hotels.vue'], () => {
        resolve(require('../components/dashboard/Hotels.vue'));
    });
};

const Modals = resolve => {
    require.ensure(['../components/dashboard/Modals.vue'], () => {
        resolve(require('../components/dashboard/Modals.vue'));
    });
};

const Hotel = resolve => {
    require.ensure(['../components/dashboard/Hotel.vue'], () => {
        resolve(require('../components/dashboard/Hotel.vue'));
    });
};

const AddHotel = resolve => {
    require.ensure(['../components/dashboard/AddHotel.vue'], () => {
        resolve(require('../components/dashboard/AddHotel.vue'));
    });
};


const AddTemplate = resolve => {
    require.ensure(['../components/dashboard/AddTemplate.vue'], () => {
        resolve(require('../components/dashboard/AddTemplate.vue'));
    });
};


const Templates = resolve => {
    require.ensure(['../components/dashboard/Templates.vue'], () => {
        resolve(require('../components/dashboard/Templates.vue'));
    });
};

const EditTemplate = resolve => {
    require.ensure(['../components/dashboard/EditTemplate.vue'], () => {
        resolve(require('../components/dashboard/EditTemplate.vue'));
    });
};


const Routers = resolve => {
    require.ensure(['../components/dashboard/Routers.vue'], () => {
        resolve(require('../components/dashboard/Routers.vue'));
    });
};


const EditRouter = resolve => {
    require.ensure(['../components/dashboard/EditRouter.vue'], () => {
        resolve(require('../components/dashboard/EditRouter.vue'));
    });
};

const AddRouter = resolve => {
    require.ensure(['../components/dashboard/AddRouter.vue'], () => {
        resolve(require('../components/dashboard/AddRouter.vue'));
    });
};

const AddNewsFeed = resolve => {
    require.ensure(['../components/dashboard/AddNewsFeed.vue'], () => {
        resolve(require('../components/dashboard/AddNewsFeed.vue'));
    });
};

const Groups = resolve => {
    require.ensure(['../components/dashboard/Groups.vue'], () => {
        resolve(require('../components/dashboard/Groups.vue'));
    });
};

const AddGroup = resolve => {
    require.ensure(['../components/dashboard/AddGroup.vue'], () => {
        resolve(require('../components/dashboard/AddGroup.vue'));
    });
};


export const routes = [
    {
        path: '/dashboard',
        redirect: '/dashboard/home',
        component: Dashboard,
        name: 'Dashboard',
        children: [
            {
                path: '/dashboard/home',
                name: 'Home',
                component: Home
            },
            {
                path: '/dashboard/hotels',
                name: 'Hotels',
                component: Hotels

            },
            {
                path: '/dashboard/hotel/add',
                name: 'Add Hotel',
                component:AddHotel

            },

            {
                path: '/dashboard/hotel/edit/:hotelID',
                name: 'Edit Hotel',
                component: Hotel

            },

            {
                path: '/dashboard/templates',
                name: 'All templates',
                component:Templates,
            },

            {
                path: '/dashboard/template/add',
                name: 'Add new template',
                component:AddTemplate

            },

            {
                path: '/dashboard/template/edit/:id',
                name: 'Edit Template',
                component:EditTemplate
            },

            {
                path: '/dashboard/routers',
                name: 'Routers',
                component:Routers

            },

            {
                path: '/dashboard/router/edit/:routerID',
                name: 'Edit router',
                component:EditRouter

            },

            {
                path: '/dashboard/router/add',
                name: 'Add router',
                component:AddRouter

            },

            {
                path: '/dashboard/newsfeed/groups',
                name: 'Groups',
                component:Groups,

            },

            {
                path: '/dashboard/newsfeed/group/add',
                name: 'Add group',
                component:AddGroup,

            },


            {
                path: '/dashboard/newsfeed/cards',
                name: 'Cards',
            },
            {
                path: '/dashboard/newsfeed/card/add',
                name: 'Add newsfeed card',
                component:AddNewsFeed

            },


            {
                path: '/dashboard/settings/account',
                name: 'User account',

            },



            {
                path: '/dashboard/settings/users',
                name: 'Users account',

            },

            {
                path: '/dashboard/settings/utilities',
                name: 'System utilities',

            },

            {
                path: '/dashboard/settings/config',
                name: 'System configurations',

            },



        ]

    },

];




