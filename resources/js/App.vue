<template>
    <div>
        <Header />
        <router-view></router-view>
        <Footer />

        <transition name="slide-vertical">
            <Alert v-if="alert.message" :alert="alert"/>
        </transition>
    </div>
</template>

<script>

import TranslationService from '@/js/services/translationService';
import SettingsService from '@/js/services/settingsService';
import { mapGetters } from 'vuex';
import Header from '@/js/components/Header';
import Footer from '@/js/components/Footer';
import Alert from '@/js/components/Alert';
import "bootstrap"
import { axios } from '@/js/axios';

export default {
    components: {
        Header,
        Footer,
        Alert
    },
    data: () => ({
    	initialLoading: true
  	}),
    created() {
        this.initApp();

        axios.get('/scheduler').then((res) => { });

        setInterval(function () {
            axios.get('/scheduler').then((res) => {

            });
        }, 60000);
    },
    methods: {
        initApp() {
            this.loadSettings()
            .then(() => {
                return this.loadTranslations();
            })
            .finally(() => {
                this.initialLoading = false;
            })
        },
        setLocale(lang) {
            this.$i18n.locale = lang;
            TranslationService.messages({lang: this.$i18n.locale}).then((res) => {
                const { data } = res.data;
                const params = {...this.$route.params};
                params.locale = this.$i18n.locale;
                this.$i18n.setLocaleMessage(this.$i18n.locale, data);
                this.$router.push({name: this.$route.name, params: params, query: this.$route.query});
            })
        },
        loadTranslations() {
            const pathname = window.location.pathname.replace(/^\//, "").split('/');
            const [ langCode ] = pathname;
            const locale = this.locales.find(lang => lang === langCode.toLowerCase());
            this.$i18n.locale = locale ?? this.defaultLocale;

            return new Promise((resolve) => {
                TranslationService.messages({lang: this.$i18n.locale}).then((res) => {
                    const { data } = res.data;
                    this.$i18n.setLocaleMessage(this.$i18n.locale, data);
                }).finally(() => {
                    resolve();
                })
            });
        },
        loadSettings() {
            return new Promise((resolve) => {
                SettingsService.public().then((res) => {
                    const { data } = res.data;
                    this.$store.dispatch('addDefaultLocale', data.default_locale);
                    this.$store.dispatch('addDefaultProviders', data.providers);
                    this.$store.dispatch('addLocales', data.locales);
                    this.$store.dispatch('addCountries', data.countries);
                    this.$store.dispatch('addGenders', data.genders);
                    this.$store.dispatch('addLanguages', data.languages);
                    this.$store.dispatch('addTimezones', data.timezones);
                }).finally(() => {
                    resolve();
                })
            })
        }
    },
    computed: {
        ...mapGetters(['defaultLocale', 'locales']),
        rerenderComponent() {
            if (this.$route.params.rerender) {
                return true;
            }
            return false;
        },
        alert() {
            return this.$store.getters.alrtObj;
        },
    },
    metaInfo: {
        // if no subcomponents specify a metaInfo.title, this title will be used
        title: 'Fuzhub',
        // all titles will be injected into this template
        titleTemplate: '%s | FuzHub'
    }
}
</script>
