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
                            <p v-if="verified">{{ $t("Email successfully verified.") }}</p>
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

export default {
  	name: 'VerifyEmail',
    components: {Sidebar},
    data: () => ({
    	form: new Form({
            id: '',
            hash: '',
    	}),
        loading: true,
        verified: null
  	}),
    mounted() {
        this.form.id = this.$route.params.id;
        this.form.hash = this.$route.params.hash;

        this.verify();
    },
    methods: {
        verify() {
			this.send()
			.then(() => {

			})
			.catch(() => {
                this.$router.push({name: 'Home', params: {locale: this.$i18n.locale}});
			})
    	},
        send() {
            let url = '/verify?expires='+this.$route.query.expires+'&signature='+this.$route.query.signature;
            return new Promise((resolve, reject) => {
                this.form.post(url).then(res => {
					const { data } = res.data;
                    this.loading = false;
					this.verified = data.success;
					resolve();
				}).catch(() => {
                    this.loading = false;
                    this.verified = false;
					reject();
				})
			})
		}
	},
    metaInfo() {
        return {
            title: this.$t("Verify email"),
            bodyAttrs: {
                class: 'full-page'
            }
        };
    }
}
</script>
