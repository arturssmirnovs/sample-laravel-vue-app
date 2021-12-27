<template>
    <main id="content" role="main" class="flex-grow-1">
        <div class="container-fluid">
            <div class="row">
                <Sidebar />
                <div class="col-lg-7 col-xl-8 d-flex justify-content-center align-items-center min-vh-lg-100">
                    <div class="flex-grow-1 mx-auto" style="max-width: 28rem;">
                        <div class="text-center mb-5 mb-md-7">
                            <h1 class="h2">{{ $t("Welcome back") }}</h1>
                            <p>{{ $t("Almost there, enter you new password.") }}</p>
                        </div>

                        <form @submit.prevent="reset" @keydown="form.onKeydown($event)">
                            <div class="mb-3">
                                <label for="password" class="form-label">{{ $t("Your new password") }}</label>
                                <input id="password" v-model="form.password" type="password" name="password" class="form-control" :placeholder="$t('Enter your password')">
                                <HasError :form="form" field="password" />
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">{{ $t("Your new password again") }}</label>
                                <input id="password_confirmation" v-model="form.password_confirmation" type="password" name="password_confirmation" class="form-control" :placeholder="$t('Enter your password again')">
                                <HasError :form="form" field="password" />
                            </div>
                            <div class="d-grid mb-3">
                                <Button :form="form" class="btn btn-primary btn-lg">
                                    {{ $t("Change my password") }}
                                </Button>
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

export default {
    name: 'ResetPassword',
    components: {Sidebar},
    data: () => ({
        form: new Form({
            email: '',
            password: '',
            password_confirmation: '',
            token: '',
        })
    }),
    mounted() {
        this.form.token = this.$route.params.token;
        this.form.email = this.$route.query.email;
    },
    methods: {
        reset() {
            this.send()
                .then((data) => {
                    if (data.success) {
                        this.$store.dispatch('setAlert', {success: true, message: this.$t('Password changed, proceed to signing in.')});
                        this.$router.push({name: 'Login', params: {locale: this.$i18n.locale}});
                    } else {
                        this.$store.dispatch('setAlert', {success: false, message: this.$t('Something went wrong, please try again.')});
                    }
                })
                .catch(() => {

                })
        },
        send() {
            return new Promise((resolve, reject) => {
                this.form.post('/reset').then(res => {
                    const { data } = res.data;
                    resolve(data);
                }).catch(() => {
                    reject();
                })
            })
        }
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
