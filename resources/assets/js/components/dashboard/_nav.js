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
                    url: '/dashboard/template/add',
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
                    url: '/dashboard/router/add',
                    icon: 'icon-plus',
                },
                {
                    name: 'All routers',
                    url: '/dashboard/routers',
                    icon: 'fa fa-sitemap'
                }
            ]
        },


        {
            divider: true
        },
        {
            title: true,
            name: 'News Feeds'
        },


        {
            name: 'News Feeds',
            url: '/dashboard/newsfeed',
            icon: 'icon-feed',
            children: [
                {
                    name: 'Groups',
                    url: '/dashboard/groups',
                    icon: 'fa fa-bullhorn',
                    children: [
                        {
                            name: 'New group',
                            url: '/dashboard/newsfeed/group/add',
                            icon: 'fa fa-plus-square-o'
                        },

                        {
                            name: 'All groups',
                            url: '/dashboard/newsfeed/groups',
                            icon: 'fa fa-cubes'
                        },
                    ]
                },

                {
                    name: 'News cards',
                    url: '/dashboard/newsfeed/',
                    icon: 'fa fa-rss-square',
                    children: [
                        {
                            name: 'New news card',
                            url: '/dashboard/newsfeed/card/add',
                            icon: 'fa fa-plus-square-o'
                        },

                        {
                            name: 'All cards',
                            url: '/dashboard/newsfeed/cards',
                            icon: 'fa fa-newspaper-o'
                        },
                    ]


                },
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
