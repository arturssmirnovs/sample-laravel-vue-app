import { axios } from '@/js/axios';

class TranslationService {
    messages(params) {
        return axios.get('/translations/messages', {
            params: params
        });
    }
}

export default new TranslationService();