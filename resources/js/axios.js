import axiosService from 'axios';
import store from './store/index';
import router from './router';
import i18n from './i18n';

const instance = axiosService.create({
    baseURL: `${window.location.origin}/api`,
    timeout: 25000,
    headers: {
        'X-Requested-With': 'XMLHttpRequest',
    },
})

instance.interceptors.response.use(response => response, error => {
    if (error.response.status === 401) {
        store.commit('removeUser');
        router.push({name: 'Login', params: {locale: i18n.locale}});
    }
    
    if (error.response.status === 403){
        router.push({name: 'Home', params: {locale: i18n.locale}})
    }

    if (error.response.status === 404){
        router.push({name: 'NotFound', params: {locale: i18n.locale}})
    }

    return Promise.reject(error)
    
}, { synchronous: true });

instance.interceptors.request.use((config) => {

    config.headers['X-Locale'] = i18n.locale;

    return config;
}, null, { synchronous: true });

export const axios = instance;

export const axiosOriginal = axiosService
