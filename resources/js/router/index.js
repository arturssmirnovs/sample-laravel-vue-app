import Vue from 'vue';
import VueRouter from 'vue-router';
import authRoutes from './routes/auth';
import profileRoutes from './routes/profile';
import projectsRoutes from './routes/projects';
import store from '@/js/store';
import AuthService from '@/js/services/authService';
import i18n from '@/js/i18n';

Vue.use(VueRouter);

const routes = [
    {
        path: '/:locale([a-z]{2}|[a-z]{2}-[A-Z]{2})?',
        component: {
            render(h) { return h('router-view') },
        },
        children: [
            ...authRoutes,
            ...profileRoutes,
            ...projectsRoutes,
            {
                name: 'Home',
                component: () => import('@/js/views/Home'),
                path: ''
            },
            {
                name: 'Privacy',
                component: () => import('@/js/views/Privacy'),
                path: 'privacy-policy'
            },
            {
                name: 'Terms',
                component: () => import('@/js/views/Terms'),
                path: 'terms-of-service'
            },
            {
                name: 'NotFound',
                component: () => import('@/js/views/NotFound'),
                path: 'not-found'
            },
            {
                path: ':pathMatch(.*)*',
                redirect: {
                    name: 'NotFound'
                }
            }
        ]
    }
]

const setUser = (next) => {
    return new Promise((resolve) => {
        const userLoaded = store.getters.userLoaded;
        const token = localStorage.getItem('accessToken');

        if (!userLoaded && token) {
            store.dispatch('addAccessToken', token);
            AuthService.profile().then((res) => {
                const { data } = res.data;
                store.dispatch('addUser', data);
            }).catch(() => {
                store.dispatch('removeAccessToken');
                next({name: 'Home', params: {locale: i18n.locale}});
            }).finally(() => {
                store.commit('userLoaded');
                resolve();
            })
        } else {
            store.commit('userLoaded');
            resolve();
        }
    });
}

const router = new VueRouter({
    mode: 'history',
    routes: routes,
})

router.beforeEach(async (to, from, next) => {

    if (to.params.locale) {
        i18n.locale = to.params.locale;
    }

    await setUser(next);

    const middlewares = to.meta.middlewares ?? [];
    const user = store.getters.user;

    middlewares.forEach(callback => {
        callback(next, user);
    });

    next();
});

export default router;
