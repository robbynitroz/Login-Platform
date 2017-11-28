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

            },

            {
                path: '/dashboard/hotel/edit/:hotelID',
                name: 'Edit Hotel',

            },

            {
                path: '/dashboard/templates',
                name: 'All login templates',

            },

            {
                path: '/dashboard/template/:hotel_id',
                name: 'Login template by hotel',

            },

            {
                path: '/dashboard/routers',
                name: 'Routers',

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

/*import Vue from 'vue'
import Router from 'vue-router'

// Containers
import Full from '@/containers/Full'

// Views
import Dashboard from '@/views/Dashboard'
import Charts from '@/views/Charts'
import Widgets from '@/views/Widgets'

// Views - Components
import Buttons from '@/views/components/Buttons'
import SocialButtons from '@/views/components/SocialButtons'
import Cards from '@/views/components/Cards'
import Forms from '@/views/components/Forms'
import Modals from '@/views/components/Modals'
import Switches from '@/views/components/Switches'
import Tables from '@/views/components/Tables'

// Views - Icons
import FontAwesome from '@/views/icons/FontAwesome'
import SimpleLineIcons from '@/views/icons/SimpleLineIcons'

// Views - Pages
import Page404 from '@/views/pages/Page404'
import Page500 from '@/views/pages/Page500'
import Login from '@/views/pages/Login'
import Register from '@/views/pages/Register'*/



