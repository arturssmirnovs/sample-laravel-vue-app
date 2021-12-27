<template>
    <main id="content" role="main" class="bg-light">

        <Header/>

        <div class="container content-space-1 content-space-t-lg-0 content-space-b-lg-2 mt-lg-n10">
            <div class="row">
                <div class="col-lg-3">
                    <div class="navbar-expand-lg navbar-light">
                        <div id="sidebarNav" class="collapse navbar-collapse navbar-vertical">
                            <Sidebar></Sidebar>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-header border-bottom">
                            <h5 class="card-title">{{ $t("Preferences") }}</h5>
                        </div>
                        <div class="card-body">
                            <form @submit.prevent="save" @keydown="form.onKeydown($event)">

                                <div class="row mb-4">
                                    <label class="col-sm-3 col-form-label form-label">{{ $t("Timezone") }}</label>
                                    <div class="col-sm-9">
                                        <div class="tom-select-custom">
                                            <select class="js-select form-select" v-model="form.timezone_id">
                                                <option :value="undefined">-</option>
                                                <option :value="timezone.id" v-for="timezone in timezones">{{ timezone.gtm }}</option>
                                            </select>
                                        </div>
                                        <HasError :form="form" field="timezone_id" />
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <label class="col-sm-3 col-form-label form-label">{{ $t("Language") }}</label>
                                    <div class="col-sm-9">
                                        <div class="tom-select-custom">
                                            <select class="js-select form-select" v-model="form.language_id">
                                                <option :value="undefined">-</option>
                                                <option :value="language.id" v-for="language in languages">{{ language.name }}</option>
                                            </select>
                                        </div>
                                        <HasError :form="form" field="language_id" />
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <label class="col-sm-3 col-form-label form-label">{{ $t("Country") }}</label>
                                    <div class="col-sm-9">
                                        <div class="tom-select-custom">
                                            <select class="js-select form-select" v-model="form.country_id">
                                                <option :value="undefined">-</option>
                                                <option :value="country.id" v-for="country in countries">{{ country.name }}</option>
                                            </select>
                                        </div>
                                        <HasError :form="form" field="language_id" />
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end gap-3 mt-3">
                                    <button type="submit" class="btn btn-primary" href="javascript:;">{{ $t("Save changes") }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
import Sidebar from "../../components/profile/Sidebar";
import {mapGetters} from "vuex";
import Header from "../../components/profile/Header";
import Form from '@/js/form';
import AuthService from '@/js/services/authService';

export default {
    components: {Header, Sidebar},
    computed: {
        ...mapGetters(['isAuthenticated', 'user', 'languages', 'timezones', 'countries']),
    },
    data: () => ({
        form: new Form({
            'country_id': '',
            'language_id': '',
            'timezone_id': '',
        }),
    }),
    mounted() {
        this.getUserData();

        this.form.fill(this.user);
    },
    methods: {
        save() {
            this.form.post('/preferences').then(res => {
                this.getUserData();
            }).catch(() => {

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
    },
    metaInfo: {
        title: 'Preferences',
    }
}
</script>
