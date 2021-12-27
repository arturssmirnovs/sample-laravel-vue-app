<template>
    <main id="content" role="main" class="flex-grow-1">
        <div class="container-fluid">
            <div class="row">
                <Sidebar />
                <div class="col-lg-7 col-xl-8 d-flex justify-content-center align-items-center min-vh-lg-100">
                    <div class="flex-grow-1 mx-auto" style="max-width: 28rem;">
                        <div class="text-center mb-5 mb-md-7">
                            <h1 class="h2">{{ $t("Welcome back") }}</h1>
                            <p>{{ $t("We are verifying you email, please wait a second or few.") }}</p>
                        </div>
                        <div class="text-center" v-if="loading">
                            <div class="spinner-grow text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        <div class="text-center" v-else>
                            <p v-if="loggedin">{{ $t("Email successfully verified.") }}</p>
                            <p v-else>{{ $t("Email not verified.") }}</p>
                            <div class="mt-5 mt-md-7">
                                <router-link :to="{name: 'Home', params: {locale: $i18n.locale}}" class="btn btn-primary">{{ $t("Go back home") }}</router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script>

import Form from '@/js/form';
import Sidebar from "../../components/auth/Sidebar";
import AuthService from '@/js/services/authService';

export default {
    name: 'SocialCallback',
    components: {Sidebar},
    data: () => ({
        form: new Form({
            code: '',
            provider: '',
        }),
        loading: true,
        loggedin: null
    }),
    mounted() {
        this.form.code = this.$route.query.code;
        this.form.provider = this.$route.params.provider;

        this.verify();
    },
    methods: {
        verify() {
            this.send()
                .then((data) => {
                    return this.getUserData();
                })
                .then(() => {
                    this.$router.push({name: 'Home', params: {locale: this.$i18n.locale}});
                })
                .catch(() => {
                    if (this.form.errors.get('code')) {
                        this.$router.push({name: 'code2fa', params: {locale: this.$i18n.locale}});
                    } else {
                        this.$router.push({name: 'Home', params: {locale: this.$i18n.locale}});
                        this.$store.dispatch('setAlert', {success: false, message: this.$t('Something went wrong, please try again.')});
                    }
                })
        },
        send() {
            let url = '/login/'+this.form.provider+'/callback';

            return new Promise((resolve, reject) => {
                this.form.post(url).then(res => {
                    const { data } = res.data;
                    this.$store.dispatch('addAccessToken', data.access_token);
                    resolve(data);
                }).catch(() => {
                    reject();
                })
            })
        },
        getUserData() {
            return new Promise((resolve, reject) => {
                AuthService.profile().then((res) => {
                    const { data } = res.data;
                    this.$store.dispatch('addUser', data);
                    resolve();
                }).catch(() => {
                    reject();
                })
            })
        },
    },
    metaInfo() {
        return {
            title: this.$t("Social login"),
            bodyAttrs: {
                class: 'full-page'
            }
        };
    }
}
</script>
