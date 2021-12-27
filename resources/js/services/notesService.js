import { axios } from '@/js/axios';

class notesService {
    index() {
        return axios.get('/notes');
    }
    store() {
        return axios.post('/notes');
    }
    update(id) {
        return axios.put('/notes/'+id);
    }
    show(id) {
        return axios.get('/notes/'+id);
    }
    destroy(id) {
        return axios.delete('/notes/'+id);
    }
}

export default new notesService();
