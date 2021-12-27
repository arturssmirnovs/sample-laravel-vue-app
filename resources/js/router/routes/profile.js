import {user} from '../middlewares';

export default [
    {
        path: 'profile',
        component: () => import('@/js/views/profile/Index'),
        name: 'Profile',
        meta: {
            middlewares: [ user ]
        }
    },
    {
        path: 'profile/password',
        component: () => import('@/js/views/profile/Security'),
        name: 'ProfilePassword',
        meta: {
            middlewares: [ user ]
        }
    },
    {
        path: 'profile/notifications',
        component: () => import('@/js/views/profile/Notifications'),
        name: 'ProfileNotifications',
        meta: {
            middlewares: [ user ]
        }
    },
    {
        path: 'profile/preferences',
        component: () => import('@/js/views/profile/Preferences'),
        name: 'ProfilePreferences',
        meta: {
            middlewares: [ user ]
        }
    },
    {
        path: 'profile/teams',
        component: () => import('@/js/views/profile/Teams'),
        name: 'ProfileTeams',
        meta: {
            middlewares: [ user ]
        }
    },
]
