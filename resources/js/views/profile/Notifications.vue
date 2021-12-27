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
                    <div class="d-grid gap-3 gap-lg-5">
                        <div class="card card-sm">
                            <div class="card-header d-flex justify-content-between align-items-center border-bottom">
                                <h5 class="card-header-title">My network</h5>
                            </div>

                            <div class="alert alert-soft-danger text-center card-alert" role="alert">
                                We need permission from your browser to show notifications. <a class="alert-link" href="#">Request permission</a>
                            </div>

                            <div class="card-body">
                                <small class="card-subtitle">Send me:</small>
                                <div class="list-group list-group-flush list-group-no-gutters">
                                    <div class="list-group-item">
                                        <label class="form-check form-switch" for="accountNotificationSwitch1">
                                            <input class="form-check-input mt-0" type="checkbox" id="accountNotificationSwitch1" value="APP" @change="save('APP')" :checked="hasChecked('APP')">
                                            <span class="d-block">App notifications</span>
                                            <span class="d-block small text-muted">A weekly email featuring shots from designers you follow</span>
                                        </label>
                                    </div>
                                    <div class="list-group-item">
                                        <label class="form-check form-switch" for="accountNotificationSwitch2">
                                            <input class="form-check-input mt-0" type="checkbox" id="accountNotificationSwitch2" value="NEWS" @change="save('NEWS')" :checked="hasChecked('NEWS')">
                                            <span class="d-block">News letters</span>
                                            <span class="d-block small text-muted">Get important notifications about you or activity you've missed</span>
                                        </label>
                                    </div>
                                    <div class="list-group-item">
                                        <label class="form-check form-switch" for="accountNotificationSwitch3">
                                            <input class="form-check-input mt-0" type="checkbox" id="accountNotificationSwitch3" value="MARKETING" @change="save('MARKETING')" :checked="hasChecked('MARKETING')">
                                            <span class="d-block">Third party marketing letters</span>
                                            <span class="d-block small text-muted">Get an email when a Dribbble Meetup is posted close to my location</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
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
        ...mapGetters(['isAuthenticated', 'user', 'providers']),
    },
    data: () => ({
        form: new Form({
            'notifications': []
        }),
    }),
    mounted() {
        this.getUserData();

        this.form.fill(this.user);
    },
    methods: {
        save(val) {
            if (this.hasChecked(val)) {
                for (var i = this.form.notifications.length; i--;) {
                    if (this.form.notifications[i] === val) {
                        this.form.notifications.splice(i, 1);
                    }
                }
            } else {
                this.form.notifications.push(val);
            }

            this.form.post('/notifications').then(res => {
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
        hasChecked(item) {
            return this.form.notifications.includes(item);
        }
    },
    metaInfo: {
        title: 'Notifications',
    }
}
</script>
