import Vue from 'vue';
import VueI18n from 'vue-i18n'

Vue.use(VueI18n)

const i18n = new VueI18n({
    messages: {},
    locale: 'en',
    silentTranslationWarn: true,
})

export default i18n;