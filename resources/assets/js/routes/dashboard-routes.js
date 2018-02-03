const Dashboard = resolve => {
    require.ensure(['../components/dashboard/Dashboard.vue'], () => {
        resolve(require('../components/dashboard/Dashboard.vue'));
    });
};

/*const Home = resolve => {
    require.ensure(['../components/dashboard/Home.vue'], () => {
        resolve(require('../components/dashboard/Home.vue'));
    });
};*/


const Hotels = resolve => {
    require.ensure(['../components/dashboard/Hotels.vue'], () => {
        resolve(require('../components/dashboard/Hotels.vue'));
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

const Home = resolve => {
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
const EditGroup = resolve => {
    require.ensure(['../components/dashboard/EditGroup.vue'], () => {
        resolve(require('../components/dashboard/EditGroup.vue'));
    });
};
const Cards = resolve => {
    require.ensure(['../components/dashboard/Cards.vue'], () => {
        resolve(require('../components/dashboard/Cards.vue'));
    });
};
const EditCard = resolve => {
    require.ensure(['../components/dashboard/EditNewsFeed.vue'], () => {
        resolve(require('../components/dashboard/EditNewsFeed.vue'));
    });
};

const EmailSettings = resolve => {
    require.ensure(['../components/dashboard/EmailSetting.vue'], () => {
        resolve(require('../components/dashboard/EmailSetting.vue'));
    });
};

const AddEmailSettings = resolve => {
    require.ensure(['../components/dashboard/AddEmailSetting.vue'], () => {
        resolve(require('../components/dashboard/AddEmailSetting.vue'));
    });
};

const EditEmailSettings = resolve => {
    require.ensure(['../components/dashboard/EditEmailSetting.vue'], () => {
        resolve(require('../components/dashboard/EditEmailSetting.vue'));
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
                path: '/dashboard/newsfeed/group/edit/:id',
                name: 'Edit group',
                component:EditGroup,
            },


            {
                path: '/dashboard/newsfeed/cards',
                name: 'Cards',
                component:Cards,
            },

            {
                path: '/dashboard/newsfeed/card/add',
                name: 'Add newsfeed card',
                component:AddNewsFeed
            },

            {
                path: '/dashboard/newsfeed/card/:id',
                name: 'Edit card',
                component:EditCard
            },

            {
                path: '/dashboard/settings/account',
                name: 'User account',
            },

            {
                path: '/dashboard/settings/email',
                name: 'Email list settings',
                component:EmailSettings
            },

            {
                path: '/dashboard/settings/email/add',
                name: 'Add Email list setting',
                component:AddEmailSettings
            },

            {
                path: '/dashboard/settings/email/:id',
                name: 'Edit Email list setting',
                component:EditEmailSettings
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




