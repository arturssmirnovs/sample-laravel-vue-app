<template>
    <div class="card flex-grow-1 mb-5">
        <div class="card-body">
            <div class="d-none d-lg-block text-center mb-5">
                <div class="avatar avatar-xxl avatar-circle mb-3">
                    <img class="avatar-img" :src="image" alt="Image Description">
                    <img v-if="user.email_verified_at" class="avatar-status avatar-lg-status" src="/assets/svg/illustrations/top-vendor.svg" alt="Image Description" data-bs-toggle="tooltip" data-bs-placement="top" title="Verified user">
                </div>
                <h4 class="card-title mb-0">{{ user.name }} {{ user.surname }}</h4>
                <p class="card-text small">{{ user.email }}</p>
            </div>

            <span class="text-cap">{{ $t("Account") }}</span>

            <ul class="nav nav-sm nav-tabs nav-vertical mb-5">
                <li class="nav-item">
                    <router-link :to="{name: 'Profile', params: {locale: $i18n.locale}}" class="nav-link active"><i class="bi-person-badge nav-icon"></i> {{ $t("Personal info") }}</router-link>
                </li>
				<li class="nav-item">
					<router-link :to="{name: 'ProfilePassword', params: {locale: $i18n.locale}}" class="nav-link"><i class="bi-shield-shaded nav-icon"></i> {{ $t("Security") }}</router-link>
				</li>
				<li class="nav-item">
					<router-link :to="{name: 'ProfileNotifications', params: {locale: $i18n.locale}}" class="nav-link"><i class="bi-bell nav-icon"></i> {{ $t("Notifications") }}</router-link>
				</li>
				<li class="nav-item">
					<router-link :to="{name: 'ProfilePreferences', params: {locale: $i18n.locale}}" class="nav-link"><i class="bi-sliders nav-icon"></i> {{ $t("Preferences") }}</router-link>
				</li>
            </ul>

			<span class="text-cap">{{ $t("Settings") }}</span>

			<ul class="nav nav-sm nav-tabs nav-vertical mb-5">
				<li class="nav-item">
					<router-link :to="{name: 'ProfileTeams', params: {locale: $i18n.locale}}" class="nav-link"><i class="bi-people nav-icon"></i> {{ $t("Teams") }}</router-link>
				</li>
			</ul>

			<span class="text-cap">{{ $t("Others") }}</span>

			<ul class="nav nav-sm nav-tabs nav-vertical">
				<li class="nav-item">
					<a @click="logout" class="nav-link"><i class="bi-box-arrow-right nav-icon"></i> {{ $t("Log out") }}</a>
				</li>
			</ul>
        </div>
    </div>
</template>

<script>
import {mapGetters} from "vuex";
import AuthService from '@/js/services/authService';

export default {
    computed: {
        ...mapGetters(['isAuthenticated', 'user']),
		image: function () {
			if (this.user.picture) {
				return "/storage/picture/"+this.user.picture;
			}
			return "/assets/img/no-image.png";
		}
    },
	methods: {
		logout() {
			AuthService.logout().then((res) => {

			}).catch(() => {

			})
		},
	}
}
</script>
