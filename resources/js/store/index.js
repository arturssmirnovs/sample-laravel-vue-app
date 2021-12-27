import Vue from 'vue'
import Vuex from 'vuex'
import publicSettings from './modules/publicSettings';
import user from './modules/user';
import alert from './modules/alert';
import teams from './modules/teams';
import projects from './modules/projects';

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        projects,
        teams,
        publicSettings,
        user,
        alert
    }
})
