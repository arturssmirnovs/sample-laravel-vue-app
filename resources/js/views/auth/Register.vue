<template>
    <main id="content" role="main" class="flex-grow-1">
        <div class="container-fluid">
            <div class="row">
                <Sidebar />
                <div class="col-lg-7 col-xl-8 d-flex justify-content-center align-items-center min-vh-lg-100">
                    <div class="flex-grow-1 mx-auto" style="max-width: 28rem;">
                        <div class="text-center mb-5 mb-md-7">
                            <h1 class="h2">{{ $t("Welcome to Front") }}</h1>
                            <p>{{ $t("Fill out the form to get started.") }}</p>
                        </div>
                        <form @submit.prevent="register" @keydown="form.onKeydown($event)">
                            <div class="mb-3">
                                <label for="name" class="form-label">{{ $t("Your name") }}</label>
                                <input id="name" v-model="form.name" type="text" name="name" class="form-control" :placeholder="$t('Enter your name')">
                                <HasError :form="form" field="name" />
                            </div>
                            <div class="mb-3">
                                <label for="surname" class="form-label">{{ $t("Your surname") }}</label>
                                <input id="surname" v-model="form.surname" type="text" name="surname" class="form-control" :placeholder="$t('Enter your surname')">
                                <HasError :form="form" field="surname" />
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">{{ $t("Your email") }}</label>
                                <input id="email" v-model="form.email" type="text" name="email" class="form-control" :placeholder="$t('Enter your email')">
                                <HasError :form="form" field="email" />
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">{{ $t("Your password") }}</label>
                                <input id="password" v-model="form.password" type="password" name="password" class="form-control" :placeholder="$t('Enter your password')">
                                <HasError :form="form" field="password" />
                            </div>
                            <div class="form-check mb-3">
                                <input type="checkbox" class="form-check-input" id="signupHeroFormPrivacyCheck" v-model="form.agree">
                                <label class="form-check-label small" for="signupHeroFormPrivacyCheck"> {{ $t("By submitting this form I have read and acknowledged the") }} <router-link :to="{name: 'Privacy', params: {locale: $i18n.locale}}">{{ $t("Privacy policy") }}</router-link> {{ $t("&") }} <router-link :to="{name: 'Terms', params: {locale: $i18n.locale}}">{{ $t("Terms of service") }}</router-link></label>
                                <HasError :form="form" field="agree" />
                            </div>
                            <div class="d-grid mb-3">
                                <Button :form="form" class="btn btn-primary btn-lg">
                                    {{ $t("Sign up") }}
                                </Button>
                            </div>
                            <div class="d-grid mb-3">
                                <span class="divider-center">{{ $t("OR") }}</span>
                            </div>
                            <div class="d-grid mb-3">
                                <a class="btn btn-white btn-lg" href="#"><span class="d-flex justify-content-center align-items-center"><img class="avatar avatar-xss me-2" src="/assets/svg/brands/github-icon.svg" alt="Image Description">{{ $t("Sign in with Google") }}</span></a>
                            </div>
                            <div class="d-grid mb-3">
                                <a class="btn btn-white btn-lg" href="#"><span class="d-flex justify-content-center align-items-center"><img class="avatar avatar-xss me-2" src="/assets/svg/brands/google-icon.svg" alt="Image Description">{{ $t("Sign up with Google") }}</span></a>
                            </div>
                            <div class="d-grid mb-3">
                                <a class="btn btn-white btn-lg" href="#"><span class="d-flex justify-content-center align-items-center"><img class="avatar avatar-xss me-2" src="/assets/svg/brands/google-icon.svg" alt="Image Description">{{ $t("Sign up with Facebook") }}</span></a>
                            </div>
                            <div class="d-grid mb-4">
                                <a class="btn btn-white btn-lg" href="#"><span class="d-flex justify-content-center align-items-center"><img class="avatar avatar-xss me-2" src="/assets/svg/brands/google-icon.svg" alt="Image Description">{{ $t("Sign up with Linkedin") }}</span></a>
                            </div>
                            <div class="text-center">
                                <p>{{ $t("Already have an account?") }} <router-link :to="{name: 'Login', params: {locale: $i18n.locale}}" class="link">{{ $t("Log in here") }}</router-link></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script>

import AuthService from '@/js/services/authService';
import Form from '@/js/form';
import Sidebar from "../../components/auth/Sidebar";

export default {
  	name: 'RegisterView',
    components: {Sidebar},
    data: () => ({
    	form: new Form({
      		name: '',
            surname: '',
      		password: '',
      		email: '',
            agree: false
    	})
  	}),
  	methods: {
    	register() {
			this.signup()
			.then(() => {
				return this.getUserData();
			})
			.then(() => {
				this.$router.push({name: 'Home', params: {locale: this.$i18n.locale}});
			})
			.catch(() => {

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
        signup() {
			return new Promise((resolve, reject) => {
				this.form.post('/register').then(res => {
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
            title: this.$t("Register"),
            bodyAttrs: {
                class: 'full-page'
            }
        };
    }
}
</script>
