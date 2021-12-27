import { axios } from '@/js/axios';

class targetsService {
    index() {
        return axios.get('/targets');
    }
    store() {
        return axios.post('/targets');
    }
    update(id) {
        return axios.put('/targets/'+id);
    }
    show(id) {
        return axios.get('/targets/'+id);
    }
    destroy(id) {
        return axios.delete('/targets/'+id);
    }
}

export default new targetsService();
