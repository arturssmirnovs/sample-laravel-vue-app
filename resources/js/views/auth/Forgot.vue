<template>
    <main id="content" role="main" class="flex-grow-1">
        <div class="container-fluid">
            <div class="row">
                <Sidebar />
                <div class="col-lg-7 col-xl-8 d-flex justify-content-center align-items-center min-vh-lg-100">
                    <div class="flex-grow-1 mx-auto" style="max-width: 28rem;">
                        <div class="text-center mb-5 mb-md-7">
                            <h1 class="h2">{{ $t("Welcome back") }}</h1>
                            <p>{{ $t("Enter your email & we will send you instruction there.") }}</p>
                        </div>
                        <form @submit.prevent="reset" @keydown="form.onKeydown($event)">
                            <div class="mb-3">
                                <label for="email" class="form-label">{{ $t("Your email") }}</label>
                                <input id="email" v-model="form.email" type="text" name="email" class="form-control" :placeholder="$t('Enter your email')">
                                <HasError :form="form" field="email" />
                            </div>
                            <div class="d-grid mb-3">
                                <Button :form="form" class="btn btn-primary btn-lg">
                                    {{ $t("Reset password") }}
                                </Button>
                            </div>
                            <div class="text-center">
                                <p>{{ $t("Don't have an account yet?") }} <router-link :to="{name: 'Register', params: {locale: $i18n.locale}}" class="link">{{ $t("Sign up here") }}</router-link></p>
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
    name: 'Forgot',
    components: {Sidebar},
    data: () => ({
        form: new Form({
            email: '',
        }),
        loading: false,
        status: null
    }),
    methods: {
        reset() {
            this.send()
                .then(() => {
                    this.form.email = '';
                    this.$store.dispatch('setAlert', {success: true, message: this.$t('Please check your email. (We have sent instructions if account exists.)')});
                })
                .catch(() => {

                })
        },
        send() {
            return new Promise((resolve, reject) => {
                this.form.post('/forgot').then(res => {
                    const { data } = res.data;
                    resolve();
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
