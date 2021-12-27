import Vue from 'vue';
import App from './App.vue';
import router from './router';
import store from './store';
import i18n from './i18n';
import { Button, HasError } from 'vform/src/components/bootstrap5'
import ClickOutside from 'vue-click-outside'
import VueMeta from "vue-meta";

Vue.use(VueMeta, {
    refreshOnceOnNavigation: true
})

Vue.component('Button', Button);
Vue.component('HasError', HasError);

Vue.directive('click-outside', ClickOutside)

const app = new Vue({
    router,
    store,
    i18n,
    components: { App },
    template: '<App/>'
}).$mount("#app");
