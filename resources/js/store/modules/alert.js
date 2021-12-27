export default {
    state: {
        alertObj: {
            success: false,
            message: ''
        }
    },
    mutations: {
        addAlertObj(state, data) {
            state.alertObj = data;
        },
        clearAlertObj(state) {
            state.alertObj = {
                success: false,
                message: ''
            }
        }
    },
    actions: {
        setAlert({commit}, data) {
            commit('addAlertObj', data);
        },
        clearAlert({commit}) {
            commit('clearAlertObj');
        }
    },
    getters: {
        alrtObj(state) {
            return state.alertObj;
        }
    }
}
