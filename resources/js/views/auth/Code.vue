<template>
    <main id="content" role="main" class="flex-grow-1">
        <div class="container-fluid">
            <div class="row">
                <Sidebar />
                <div class="col-lg-7 col-xl-8 d-flex justify-content-center align-items-center min-vh-lg-100">
                    <div class="flex-grow-1 mx-auto" style="max-width: 28rem;">
                        <div class="text-center mb-5 mb-md-7">
                            <h1 class="h2">{{ $t("Welcome back") }}</h1>
                            <p>{{ $t("2FA required for your account.") }}</p>
                        </div>
                        <form @submit.prevent="reset" @keydown="form.onKeydown($event)">
                            <div class="mb-3">
                                <label for="code" class="form-label">{{ $t("Code") }}</label>
                                <input id="code" v-model="form.code" type="text" name="code" class="form-control" :placeholder="$t('Enter your code')">
                                <HasError :form="form" field="code" />
                            </div>
                            <div class="d-grid mb-3">
                                <Button :form="form" class="btn btn-primary btn-lg">
                                    {{ $t("Verify") }}
                                </Button>
                            </div>
                            <div class="text-center">
                                <p>{{ $t("Didn't get the code?") }} <router-link :to="{name: 'Login', params: {locale: $i18n.locale}}" class="link">{{ $t("Try again.") }}</router-link></p>
                            </div>
                        </form>
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
    name: 'code2fa',
    components: {Sidebar},
    data: () => ({
        form: new Form({
            code: '',
        }),
        loading: false,
        status: null
    }),
    methods: {
        reset() {
            this.send()
                .then(() => {
                    return this.getUserData();
                })
                .then(() => {
                    this.$router.push({name: 'Home', params: {locale: this.$i18n.locale}});
                })
                .catch(() => {

                })
        },
        send() {
            return new Promise((resolve, reject) => {
                this.form.post('/code').then(res => {
                    const { data } = res.data;
                    this.$store.dispatch('addAccessToken', data.access_token);
                    resolve();
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
            title: this.$t("Reset password"),
            bodyAttrs: {
                class: 'full-page'
            }
        };
    }
}
</script>
