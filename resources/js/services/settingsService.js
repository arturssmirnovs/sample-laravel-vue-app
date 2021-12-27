import { axios } from '@/js/axios';

class SettingsService {
    public() {
        return axios.get('/settings/public');
    }
}

export default new SettingsService();