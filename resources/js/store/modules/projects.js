export default {
    state: {
        projects: {}
    },
    mutations: {
        setProjects(state, data) {
            state.projects = data;
        }
    },
    actions: {
        addProjects({commit}, data) {
            commit('setProjects', data);
        }
    },
    getters: {
        projects(state) {
            return state.projects;
        }
    }
}
