export default {
    items: [
        {
            name: 'Dashboard',
            url: '/dashboard',
            icon: 'icon-speedometer',
            /*badge: {
              variant: 'primary',
              text: 'NEW'
            }*/
        },
        {
            title: true,
            name: 'Hotel management',
            class: '',
            wrapper: {
                element: '',
                attributes: {}
            }
        },
        {
            name: 'Hotels',
            url: '/hotels',
            icon: 'fa fa-building-o',
            children: [
                {
                    name: 'Add hotel',
                    url: '/dashboard/hotel/add',
                    icon: 'icon-plus'
                },
                {
                    name: 'Show hotels',
                    url: '/dashboard/hotels',
                    icon: 'icon-list'
                },


            ]
        },

        {
            name: 'Login templates',
            url: '/dashboard/templates',
            icon: 'icon-screen-tablet',
            children: [
                {
                    name: 'Add template',
                    url: '/dashboard/template/1',
                    icon: 'icon-plus',
                },
                {
                    name: 'All templates',
                    url: '/dashboard/templates',
                    icon: 'icon-docs'
                }
            ]
        },
        {
            name: 'Routers',
            url: '/dashboard/routers',
            icon: 'fa fa-wifi',
            children: [
                {
                    name: 'Add Router',
                    url: '/dashboard/template/1',
                    icon: 'icon-plus',
                },
                {
                    name: 'All routers',
                    url: '/dashboard/templates',
                    icon: 'fa fa-sitemap'
                }
            ]
        },
        {
            divider: true
        },
        {
            title: true,
            name: 'Settings'
        },
        {
            name: 'Settings',
            url: '/dashboard/settings',
            icon: 'icon-settings',
            children: [
                {
                    name: 'My account settings',
                    url: '/dashboard/settings/account',
                    icon: 'icon-user'
                },

                {
                    name: 'Users accounts',
                    url: '/dashboard/settings/users',
                    icon: 'fa fa-users'
                },

                {
                    name: 'System utilities',
                    url: '/dashboard/settings/utilities',
                    icon: 'fa fa-wrench'
                },
                {
                    name: 'System configurations',
                    url: '/dashboard/settings/config',
                    icon: 'fa fa-cogs'
                },

            ]
        },
        {
            name: 'Mikrotik status',
            url: '',
            icon: 'icon-compass',
            class: 'mt-auto',
            variant: 'success'
        },
        {
            name: 'Server status',
            url: '',
            icon: 'icon-cloud-download',
            variant: 'danger'
        }
    ]
}
