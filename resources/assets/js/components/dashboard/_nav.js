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
          icon: 'icon-puzzle'
        },
        {
          name: 'Show hotels',
          url: '/dashboard/hotels',
          icon: 'icon-puzzle'
        },
      ]
    },
    {
      name: 'Login templates',
      url: '/templates',
      icon: 'icon-screen-tablet',
      children: [
        {
          name: 'Font Awesome',
          url: '/icons/font-awesome',
          icon: 'icon-star',
          badge: {
            variant: 'secondary',
            text: '4.7'
          }
        },
        {
          name: 'Simple Line Icons',
          url: '/icons/simple-line-icons',
          icon: 'icon-star'
        }
      ]
    },
    {
      name: 'Routers',
      url: '/routers',
      icon: 'fa fa-wifi',
      /*badge: {
        variant: 'primary',
        text: 'NEW'
      }*/
    },
    {
      name: 'Charts',
      url: '/charts',
      icon: 'icon-pie-chart'
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
      url: '/settings',
      icon: 'icon-settings',
      children: [
        {
          name: 'Login',
          url: '/pages/login',
          icon: 'icon-star'
        },
        {
          name: 'Register',
          url: '/pages/register',
          icon: 'icon-star'
        },
        {
          name: 'Error 404',
          url: '/pages/404',
          icon: 'icon-star'
        },
        {
          name: 'Error 500',
          url: '/pages/500',
          icon: 'icon-star'
        }
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
