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

            },
            {
                path: '/dashboard/hotel/add',
                name: 'Add Hotel',

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



