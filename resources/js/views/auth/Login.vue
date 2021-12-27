<template>
    <main id="content" role="main" class="flex-grow-1">
        <div class="container-fluid">
            <div class="row">
                <Sidebar />
                <div class="col-lg-7 col-xl-8 d-flex justify-content-center align-items-center min-vh-lg-100">
                    <div class="flex-grow-1 mx-auto" style="max-width: 28rem;">
                        <div class="text-center mb-5 mb-md-7">
                            <h1 class="h2">{{ $t("Welcome back") }}</h1>
                            <p>{{ $t("Login to manage your account.") }}</p>
                        </div>
                        <form @submit.prevent="login" @keydown="form.onKeydown($event)">
                            <div class="mb-3">
                                <label for="email" class="form-label">{{ $t("Your email") }}</label>
                                <input id="email" v-model="form.email" type="text" name="email" class="form-control" :placeholder="$t('Enter your email')">
                                <HasError :form="form" field="email" />
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label for="password" class="form-label">{{ $t("Your password") }}</label>

                                    <router-link :to="{name: 'Forgot', params: {locale: $i18n.locale}}" class="form-label-link">{{ $t("Forgot Password?") }}</router-link>
                                </div>
                                <input id="password" v-model="form.password" type="password" name="password" class="form-control" :placeholder="$t('Enter your password')">
                                <HasError :form="form" field="password" />
                            </div>
                            <div class="d-grid mb-3">
                                <Button :form="form" class="btn btn-primary btn-lg">{{ $t("Log In") }}</Button>
                            </div>
                            <div class="d-grid mb-3">
                                <span class="divider-center">{{ $t("OR") }}</span>
                            </div>
                            <div class="d-grid mb-3">
                                <a class="btn btn-white btn-lg" href="#" @click.prevent="socialLogin('github')"><span class="d-flex justify-content-center align-items-center"><img class="avatar avatar-xss me-2" src="/assets/svg/brands/github-icon.svg" alt="Image Description">{{ $t("Sign in with Google") }}</span></a>
                            </div>
                            <div class="d-grid mb-3">
                                <a class="btn btn-white btn-lg" href="#"><span class="d-flex justify-content-center align-items-center"><img class="avatar avatar-xss me-2" src="/assets/svg/brands/google-icon.svg" alt="Image Description">{{ $t("Sign in with Google") }}</span></a>
                            </div>
                            <div class="d-grid mb-3">
                                <a class="btn btn-white btn-lg" href="#"><span class="d-flex justify-content-center align-items-center"><img class="avatar avatar-xss me-2" src="/assets/svg/brands/google-icon.svg" alt="Image Description">{{ $t("Sign in with Facebook") }}</span></a>
                            </div>
                            <div class="d-grid mb-4">
                                <a class="btn btn-white btn-lg" href="#"><span class="d-flex justify-content-center align-items-center"><img class="avatar avatar-xss me-2" src="/assets/svg/brands/google-icon.svg" alt="Image Description">{{ $t("Sign in with Linkedin") }}</span></a>
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
import AuthService from '@/js/services/authService';
import Sidebar from "../../components/auth/Sidebar";

export default {
  	name: 'LoginView',
    components: {Sidebar},
    data: () => ({
    	form: new Form({
      		email: '',
      		password: ''
    	})
  	}),
	methods: {
        socialLogin(provider) {
            AuthService.socialLogin(provider).then((res) => {
                const { data } = res.data;
                window.location.href = data.url;
            }).catch(() => {

            })
        },
		login() {
			this.signin()
			.then(() => {
				return this.getUserData();
			})
			.then(() => {
				this.$router.push({name: 'Home', params: {locale: this.$i18n.locale}});
			})
			.catch(() => {
                if (this.form.errors.get('code')) {
                    this.$router.push({name: 'code2fa', params: {locale: this.$i18n.locale}});
                } else {

                }
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
		signin() {
			return new Promise((resolve, reject) => {
				this.form.post('/login').then(res => {
					const { data } = res.data;
					this.$store.dispatch('addAccessToken', data.access_token);
					resolve();
				}).catch(() => {
					reject();
				})
			})
		}
	},
    metaInfo() {
        return {
            title: this.$t("Log in"),
            bodyAttrs: {
                class: 'full-page'
            }
        };
    }
}
</script>
