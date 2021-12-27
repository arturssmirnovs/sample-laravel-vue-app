import i18n from '@/js/i18n';

export const guest = (next, user) => {
    if (user) {
        next({name: 'Home', params: {locale: i18n.locale}})
    }
}

export const user = (next, user) => {
    if (!user) {
        next({name: 'Login', params: {locale: i18n.locale}})
    }
}
