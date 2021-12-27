import { axios } from '@/js/axios';

export default {
    state: {
        accessToken: null,
        user: null,
        userLoaded: false,
        isAuthenticated: false
    },
    mutations: {
        setAccessToken(state, token) {
            state.accessToken = token;
        },
        userLoaded(state) {
            state.userLoaded = true;
        },
        setUser(state, user) {
            state.user = user;
            state.isAuthenticated = true;
        }
    },
    actions: {
        addAccessToken({ commit }, token) {
            axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
            localStorage.setItem('accessToken', token);
            commit('setAccessToken', token);
        },
        addUser({ commit }, user) {
            commit('setUser', user)
            commit('userLoaded')
        },
        removeAccessToken({ commit }) {
            localStorage.removeItem('accessToken');
            axios.defaults.headers.common['Authorization'] = ``;
            commit('setAccessToken', null);
        }
    },
    getters: {
        accessToken(state) {
            return state.accessToken;
        },
        user(state) {
            return state.user;
        },
        isAuthenticated(state) {
            return state.isAuthenticated;
        },
        userLoaded(state) {
            return state.userLoaded;
        }
    }
}
