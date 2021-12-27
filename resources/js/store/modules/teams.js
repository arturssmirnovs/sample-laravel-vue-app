export default {
    state: {
        teams: {}
    },
    mutations: {
        setTeams(state, data) {
            state.teams = data;
        }
    },
    actions: {
        addTeams({commit}, data) {
            commit('setTeams', data);
        }
    },
    getters: {
        teams(state) {
            return state.teams;
        }
    }
}
