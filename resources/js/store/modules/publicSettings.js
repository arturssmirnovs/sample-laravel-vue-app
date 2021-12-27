export default {
    state: {
        defaultLocale: null,
        locales: [],
        providers: [],
        timezones: [],
        languages: [],
        genders: [],
        countries: [],
    },
    mutations: {
        setDefaultLocale(state, locale) {
            state.defaultLocale = locale;
        },
        setDefaultProviders(state, locale) {
            state.providers = locale;
        },
        setLocales(state, locales) {
            state.locales = locales;
        },
        setTimezones(state, data) {
            state.timezones = data;
        },
        setLanguages(state, data) {
            state.languages = data;
        },
        setGenders(state, data) {
            state.genders = data;
        },
        setCountries(state, data) {
            state.countries = data;
        }
    },
    actions: {
        addDefaultLocale({ commit }, locale) {
            commit('setDefaultLocale', locale);
        },
        addDefaultProviders({ commit }, locale) {
            commit('setDefaultProviders', locale);
        },
        addLocales({ commit }, locales) {
            commit('setLocales', locales);
        },
        addTimezones({ commit }, data) {
            commit('setTimezones', data);
        },
        addLanguages({ commit }, data) {
            commit('setLanguages', data);
        },
        addGenders({ commit }, data) {
            commit('setGenders', data);
        },
        addCountries({ commit }, data) {
            commit('setCountries', data);
        }
    },
    getters: {
        defaultLocale(state) {
            return state.defaultLocale;
        },
        locales(state) {
            return state.locales;
        },
        providers(state) {
            return state.providers;
        },
        timezones(state) {
            return state.timezones;
        },
        languages(state) {
            return state.languages;
        },
        genders(state) {
            return state.genders;
        },
        countries(state) {
            return state.countries;
        }
    }
}
