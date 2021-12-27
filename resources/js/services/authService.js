import { axios } from '@/js/axios';

class AuthService {
    profile() {
        return axios.get('/profile');
    }

    remove2fa() {
        return axios.delete('/2fa');
    }

    socialLogin(provider) {
        return axios.get('/login/'+provider);
    }

    socialLoginCallback(provider) {
        return axios.get('/profile');
    }

    logoutSession(id) {
        return axios.delete('/session/'+id);
    }

    socialLoginRemove(provider) {
        return axios.delete('/login/'+provider);
    }

    logout() {
        return axios.post('/logout');
    }
}

export default new AuthService();
