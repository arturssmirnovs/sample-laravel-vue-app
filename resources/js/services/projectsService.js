import { axios } from '@/js/axios';

class projectsService {
    index() {
        return axios.get('/projects');
    }
    store() {
        return axios.post('/projects');
    }
    update(id) {
        return axios.put('/projects/'+id);
    }
    show(id) {
        return axios.get('/projects/'+id);
    }
    destroy(id) {
        return axios.delete('/projects/'+id);
    }
}

export default new projectsService();
