import { axios } from '@/js/axios';

class teamsService {
    index() {
        return axios.get('/teams');
    }
    store() {
        return axios.post('/teams');
    }
    update(id) {
        return axios.put('/teams/'+id);
    }
    show(id) {
        return axios.get('/teams/'+id);
    }
    destroy(id) {
        return axios.delete('/teams/'+id);
    }
    switchTeam(id) {
        return axios.post('/teams/switch/'+id);
    }
}

export default new teamsService();
