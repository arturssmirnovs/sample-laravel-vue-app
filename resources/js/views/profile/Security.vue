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
                        <div class="card">
                            <div class="card-header border-bottom">
                                <div class="d-flex align-items-center">
                                    <h5 class="card-header-title">{{ $t("Two-step verification") }}</h5>
                                    <span class="badge bg-soft-danger text-danger ms-2" v-if="!user.enabled_2fa">{{ $t("Disabled") }}</span>
                                    <span class="badge bg-soft-success text-success ms-2" v-if="user.enabled_2fa">{{ $t("Enabled") }}</span>
                                </div>
                            </div>
                            <div class="card-body">
                                <p class="card-text">{{ $t("Start by entering your password so that we know it's you. Then we'll walk you through two more simple steps.") }}</p>
                                <form @submit.prevent="set2fa">
                                    <div class="row mb-4">
                                        <label for="password" class="col-sm-3 col-form-label form-label">{{ $t("Account password") }}</label>
                                        <div class="col-sm-9">
                                            <input type="password" class="form-control" name="currentPassword" id="password" v-model="codeForm.password" placeholder="Enter current password" aria-label="Enter current password">
                                            <HasError :form="codeForm" field="password" />
                                        </div>
                                    </div>
                                    <div class="row mb-4" v-if="!codeForm.errors.get('password') && codeForm.password && submitted">
                                        <label for="phone" class="col-sm-3 col-form-label form-label">{{ $t("Phone number") }}</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="phone" id="phone" v-model="codeForm.phone" placeholder="Enter current password" aria-label="Enter your phone number">
                                            <HasError :form="codeForm" field="phone" />
                                        </div>
                                    </div>
                                    <div class="row mb-4" v-if="!codeForm.errors.get('password') && codeForm.password && !codeForm.errors.get('phone') && codeForm.phone && submitted">
                                        <label for="code" class="col-sm-3 col-form-label form-label">{{ $t("Code") }}</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="code" id="code" v-model="codeForm.code" placeholder="Enter current password" aria-label="Enter code received by SMS">
                                            <HasError :form="codeForm" field="code" />
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-danger me-3" @click="remove2fa" v-if="user.enabled_2fa">{{ $t("Remove") }}</button>
                                        <button type="submit" class="btn btn-primary">{{ $t("Set up") }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header border-bottom">
                                <h5 class="card-header-title">{{ $t("Password") }}</h5>
                            </div>
                            <div class="card-body">
                                <form @submit.prevent="change" @keydown="form.onKeydown($event)">
                                    <div class="row mb-4">
                                        <label for="currentPasswordLabel" class="col-sm-3 col-form-label form-label">{{ $t("Current password") }}</label>
                                        <div class="col-sm-9">
                                            <input id="currentPasswordLabel" v-model="form.password" type="password" name="password" class="form-control" :placeholder="$t('Enter your current password')">
                                            <HasError :form="form" field="password" />
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="newPassword" class="col-sm-3 col-form-label form-label">{{ $t("New password") }}</label>
                                        <div class="col-sm-9">
                                            <input type="password" class="form-control" name="newPassword" v-model="form.password_new" id="newPassword" placeholder="Enter new password" aria-label="Enter new password">
                                            <HasError :form="form" field="password_new" />
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="confirmNewPasswordLabel" class="col-sm-3 col-form-label form-label">{{ $t("Confirm new password") }}</label>
                                        <div class="col-sm-9">
                                            <div class="mb-3">
                                                <input type="password" class="form-control" name="confirmNewPassword" v-model="form.password_new_confirmation" id="confirmNewPasswordLabel" placeholder="Confirm your new password" aria-label="Confirm your new password">
                                                <HasError :form="form" field="password_new_confirmation" />
                                            </div>
                                            <h5>{{ $t("Password requirements:") }}</h5>
                                            <p class="card-text small">{{ $t("Ensure that these requirements are met:") }}</p>
                                            <ul class="small">
                                                <li>{{ $t("Minimum 8 characters long - the more, the better") }}</li>
                                                <li>{{ $t("At least one lowercase character") }}</li>
                                                <li>{{ $t("At least one uppercase character") }}</li>
                                                <li>{{ $t("At least one number, symbol, or whitespace character") }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end gap-3">
                                        <Button :form="form" class="btn btn-primary">
                                            {{ $t("Update password") }}
                                        </Button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header border-bottom">
                                <h5 class="card-header-title">{{ $t("Social accounts") }}</h5>
                            </div>
                            <div class="card-body">
                                <form>
                                    <div class="list-group list-group-flush list-group-no-gutters">
                                        <div class="list-group-item" v-for="item in socialProviders">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0">
                                                    <i :class="['list-group-icon', 'bi-'+item.name]"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="row align-items-center">
                                                        <div class="col-sm mb-1 mb-sm-0">
                                                            <h6 class="mb-1">{{ item.name }}</h6>
                                                            <a class="link-sm" :href="item.link" target="_blank">{{ item.domain }}</a>
                                                        </div>
                                                        <div class="col-sm-auto">
                                                            <a class="btn btn-white btn-xs" href="javascript:;" @click="connectProvider(item.name)" v-if="!item.is_connected">{{ $t("Connect") }}</a>
                                                            <a class="btn btn-white btn-xs" href="javascript:;" @click="removeProvider(item.name)" v-else>{{ $t("Disconnect") }}</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header border-bottom">
                                <h5 class="card-header-title">{{ $t("Device history") }}</h5>
                            </div>
                            <div class="card-body">
                                <form>
                                    <div class="list-group list-group-flush list-group-no-gutters">
                                        <div class="list-group-item" v-for="session in user.sessions">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0">
                                                    <i class="bi-laptop list-group-icon" v-if="session.is_desktop"></i>
                                                    <i class="bi-phone list-group-icon" v-else-if="session.is_phone"></i>
                                                    <i class="bi-unlock list-group-icon" v-else></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="row align-items-center">
                                                        <div class="col-sm mb-1 mb-sm-0">
                                                            <h6 class="mb-1">{{ session.browser }} <span class="badge bg-primary ms-1" v-if="session.active">{{ $t("Current") }}</span></h6>
                                                            <ul class="list-inline list-separator text-body small">
                                                                <li class="list-inline-item"><span class="fw-semi-bold">{{ $t("IP address:") }}</span> {{ session.ip_address }}</li>
                                                                <li class="list-inline-item"><span class="fw-semi-bold">{{ $t("Last active:") }}</span> {{ session.ago }}</li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-sm-auto">
                                                            <a class="btn btn-white btn-xs" href="javascript:;" @click="logout(session.id)">{{ $t("Log out") }}</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
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
        socialProviders: function () {
            let providers = [];
            this.providers.forEach(function(item){
                var isConnected = false;
                let domain = item+".com";
                let link = "https://"+domain;
                this.user.providers.forEach(function(prov){
                    if (prov.provider === item) {
                        isConnected = true;
                    }
                })
                providers.push({
                    name: item,
                    link: link,
                    domain: domain,
                    is_connected: isConnected
                })
            }.bind(this))
            return providers;
        }
    },
    data: () => ({
        form: new Form({
            'password': '',
            'password_new': '',
            'password_new_confirmation': '',
        }),
        codeForm: new Form({
            'password': '',
            'phone': '',
            'code': '',
        }),
        submitted: false,
        resent: false,
    }),
    mounted() {
        this.codeForm.phone = this.user.phone;
    },
    methods: {
        connectProvider(provider) {
            AuthService.socialLogin(provider).then((res) => {
                const { data } = res.data;
                window.location.href = data.url;
            }).catch(() => {

            })
        },
        removeProvider(provider) {
            AuthService.socialLoginRemove(provider).then((res) => {
                this.getUserData();
            }).catch(() => {

            })
        },
        logout(id) {
            AuthService.logoutSession(id).then((res) => {
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
        set2fa() {
            this.submitted = true;
            this.codeForm.post('/2fa').then(res => {
                this.getUserData();
                this.codeForm.reset();
            }).catch(() => {

            })
        },
        remove2fa() {
            AuthService.remove2fa().then((res) => {
                this.getUserData();
            }).catch(() => {

            })
        },
        change() {
            this.changePassword()
                .then((success) => {
                    if (success) {
                        this.$store.dispatch('setAlert', {success: true, message: this.$t('Password changed.')});
                    } else {
                        this.$store.dispatch('setAlert', {success: false, message: this.$t('Something went wrong, please try again.')});
                    }
                })
                .catch(() => {

                })
        },
        changePassword() {
            return new Promise((resolve, reject) => {
                this.form.post('/password').then(res => {
                    const { data } = res.data;
                    resolve(data.success);
                }).catch(() => {
                    reject();
                })
            })
        }
    },
    metaInfo: {
        title: 'Security',
    }
}
</script>
