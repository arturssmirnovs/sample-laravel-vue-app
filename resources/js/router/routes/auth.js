import { guest, user } from '../middlewares';

export default [
    {
        path: 'dashboard',
        component: () => import('@/js/views/Dashboard'),
        name: 'Dashboard',
        meta: {
            middlewares: [ user ]
        }
    },
    {
        path: 'login',
        component: () => import('@/js/views/auth/Login'),
        name: 'Login',
        meta: {
            middlewares: [ guest ]
        }
    },
    {
        path: 'login/2fa',
        component: () => import('@/js/views/auth/Code'),
        name: 'code2fa',
        meta: {
            middlewares: [ ]
        }
    },
    {
        path: 'login/:provider/callback',
        component: () => import('@/js/views/auth/SocialCallback'),
        name: 'SocialCallback',
        meta: {
            middlewares: [ ]
        }
    },
    {
        path: 'register',
        component: () => import('@/js/views/auth/Register'),
        name: 'Register',
        meta: {
            middlewares: [ guest ]
        }
    },
    {
        path: 'reset-password',
        component: () => import('@/js/views/auth/Forgot'),
        name: 'Forgot',
        meta: {
            middlewares: [ guest ]
        }
    },
    {
        path: 'reset-password/:token',
        component: () => import('@/js/views/auth/Reset'),
        name: 'Reset',
        meta: {
            middlewares: [ guest ]
        }
    },
    {
        path: 'verify/:id/:hash',
        component: () => import('@/js/views/auth/Verify'),
        name: 'Verify',
        meta: {
            middlewares: [ ]
        }
    },
]
