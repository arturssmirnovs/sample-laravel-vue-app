<template>
    <header id="header" class="navbar navbar-expand-lg navbar-end navbar-light navbar-show-hide">
        <div class="container navbar-topbar">
            <nav class="js-mega-menu navbar-nav-wrap">
                <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#topbarNavDropdown" aria-controls="topbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="d-flex justify-content-between align-items-center small">
                        <span class="navbar-toggler-text">{{ $t("Topbar") }}</span>
                        <span class="navbar-toggler-default"><i class="bi-chevron-down ms-2"></i></span>
                        <span class="navbar-toggler-toggled"><i class="bi-chevron-up ms-2"></i></span>
                    </span>
                </button>

                <div id="topbarNavDropdown" class="navbar-nav-wrap-collapse collapse navbar-collapse navbar-topbar-collapse">
                    <div class="navbar-toggler-wrapper">
                        <div class="navbar-topbar-toggler d-flex justify-content-between align-items-center">
                            <span class="navbar-toggler-text small">{{ $t("Topbar") }}</span>
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topbarNavDropdown" aria-controls="topbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                                <i class="bi-x"></i>
                            </button>
                        </div>
                    </div>

                    <ul class="navbar-nav" v-if="!isAuthenticated">
                        <li class="nav-item">
                            <router-link :to="{name: 'Login', params: {locale: $i18n.locale}}" class="nav-link" aria-label="Front">
                                {{ $t("Sign in") }}
                            </router-link>
                        </li>
                        <li class="hs-has-mega-menu nav-item">
                            <router-link :to="{name: 'Register', params: {locale: $i18n.locale}}" class="nav-link" aria-label="Front">
                                {{ $t("Register") }}
                            </router-link>
                        </li>
                    </ul>
                    <ul class="navbar-nav" v-else>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                {{ user.current_team.name }}
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#" @click="switchTeam(team)" v-for="team in user.teams">{{ team.name }}</a>
                                <div class="dropdown-divider"></div>
                                <router-link class="dropdown-item" :to="{name: 'ProfileTeams', params: {locale: $i18n.locale}}">{{ $t("Create new team") }}</router-link>
                            </div>
                        </li>
                        <li class="nav-item">
                            <router-link :to="{name: 'Profile', params: {locale: $i18n.locale}}" class="nav-link" aria-label="Front">
                                {{ $t("Edit profile") }}
                            </router-link>
                        </li>
                        <li class="hs-has-mega-menu nav-item">
                            <a class="nav-link" href="#" @click.prevent="logout">
                                {{ $t("Log out") }}
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>

        <div class="container">
            <nav class="js-mega-menu navbar-nav-wrap">
                <router-link :to="{name: 'Home', params: {locale: $i18n.locale}}" class="navbar-brand" aria-label="Front">
                    <img class="navbar-brand-logo" src="/assets/svg/logos/logo.svg" alt="Logo">
                </router-link>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-default"><i class="bi-list"></i></span>
                    <span class="navbar-toggler-toggled"><i class="bi-x"></i></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <div class="navbar-absolute-top-scroller">
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <router-link :to="{name: 'Home', params: {locale: $i18n.locale}}" class="nav-link">
                                    {{ $t("Home") }}
                                </router-link>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ $t("HR") }}
                                </a>
                                <div class="dropdown-menu">
                                    <router-link class="dropdown-item" :to="{name: 'ProfileTeams', params: {locale: $i18n.locale}}">{{ $t("Setting one") }}</router-link>
                                    <router-link class="dropdown-item" :to="{name: 'ProfileTeams', params: {locale: $i18n.locale}}">{{ $t("Setting two") }}</router-link>
                                    <router-link class="dropdown-item" :to="{name: 'ProfileTeams', params: {locale: $i18n.locale}}">{{ $t("Setting three") }}</router-link>
                                </div>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ $t("Finances") }}
                                </a>
                                <div class="dropdown-menu">
                                    <router-link class="dropdown-item" :to="{name: 'ProfileTeams', params: {locale: $i18n.locale}}">{{ $t("Setting one") }}</router-link>
                                    <router-link class="dropdown-item" :to="{name: 'ProfileTeams', params: {locale: $i18n.locale}}">{{ $t("Setting two") }}</router-link>
                                    <router-link class="dropdown-item" :to="{name: 'ProfileTeams', params: {locale: $i18n.locale}}">{{ $t("Setting three") }}</router-link>
                                </div>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ $t("Others") }}
                                </a>
                                <div class="dropdown-menu">
                                    <router-link class="dropdown-item" :to="{name: 'ProfileTeams', params: {locale: $i18n.locale}}">{{ $t("Setting one") }}</router-link>
                                    <router-link class="dropdown-item" :to="{name: 'ProfileTeams', params: {locale: $i18n.locale}}">{{ $t("Setting two") }}</router-link>
                                    <router-link class="dropdown-item" :to="{name: 'ProfileTeams', params: {locale: $i18n.locale}}">{{ $t("Setting three") }}</router-link>
                                </div>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ $t("Settings") }}
                                </a>
                                <div class="dropdown-menu">
                                    <router-link class="dropdown-item" :to="{name: 'ProfileTeams', params: {locale: $i18n.locale}}">{{ $t("Setting one") }}</router-link>
                                    <router-link class="dropdown-item" :to="{name: 'ProfileTeams', params: {locale: $i18n.locale}}">{{ $t("Setting two") }}</router-link>
                                    <router-link class="dropdown-item" :to="{name: 'ProfileTeams', params: {locale: $i18n.locale}}">{{ $t("Setting three") }}</router-link>
                                </div>
                            </li>

                            <li class="nav-item">
                                <router-link class="btn btn-primary btn-transition" :to="{name: 'Dashboard', params: {locale: $i18n.locale}}">
                                    {{ $t("Dashboard") }}
                                </router-link>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </header>
</template>

<script>
import { mapGetters } from 'vuex';
import AuthService from '@/js/services/authService';
import teamsService from "../services/teamsService";

export default {
    data: () => ({

    }),
    methods: {
        switchTeam(team) {
            teamsService.switchTeam(team.id).finally(() => {
                AuthService.profile().then((res) => {
                    const { data } = res.data;
                    this.$store.dispatch('addUser', data);
                }).catch(() => {

                })
            });
        },
        logout() {
            AuthService.logout().finally(() => {
                this.$store.dispatch('removeAccessToken');
                this.$router.go();
            });
        }
    },
    computed: {
        ...mapGetters(['locales', 'isAuthenticated', 'user'])
    }
}
</script>
