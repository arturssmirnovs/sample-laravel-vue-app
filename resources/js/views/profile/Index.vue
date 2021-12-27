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
                                <h4 class="card-header-title">{{ $t("Basic info") }}</h4>
                            </div>
                            <div class="alert alert-soft-danger text-center card-alert" role="alert" v-if="!user.email_verified_at && !resent">
                                {{ $t("Please verify your email to access all system features.") }} <a class="alert-link" @click="resend">{{ $t("Resend verification email") }}</a>
                            </div>
                            <form @submit.prevent="save" @keydown="form.onKeydown($event)">
                                <div class="card-body">
                                    <div class="row mb-4">
                                        <label class="col-sm-3 col-form-label form-label">{{ $t("Profile photo") }}</label>
                                        <div class="col-sm-9">
                                            <div class="d-flex align-items-center">
                                                <label class="avatar avatar-xl avatar-circle" for="avatarUploader">
                                                    <img id="avatarImg" class="avatar-img" :src="image" alt="Image Description">
                                                </label>
                                                <div class="d-grid d-sm-flex gap-2 ms-4">
                                                    <div class="form-attachment-btn btn btn-primary btn-sm">{{ $t("Upload photo") }}
                                                        <input type="file" class="js-file-attach form-attachment-btn-label" id="avatarUploader" @change="handleFile">
                                                    </div>
                                                    <button type="button" class="js-file-attach-reset-img btn btn-white btn-sm" @click="removePicture()">{{ $t("Delete") }}</button>
                                                </div>
                                            </div>
                                            <HasError :form="form" field="file" class="mt-3" />
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label class="col-sm-3 col-form-label form-label">Full name <i class="bi-question-circle text-body ms-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Displayed on public forums, such as Front."></i></label>
                                        <div class="col-sm-9">
                                            <div class="input-group">
                                                <input v-model="form.name" type="text" class="form-control" :placeholder="$t('Enter your name')">
                                                <HasError :form="form" field="name" />
                                                <input v-model="form.surname" type="text" class="form-control" :placeholder="$t('Enter your surname')">
                                                <HasError :form="form" field="surname" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label class="col-sm-3 col-form-label form-label">{{ $t("Email") }}</label>

                                        <div class="col-sm-9">
                                            <input v-model="form.email" type="email" class="form-control" :placeholder="$t('Enter your email')">
                                            <HasError :form="form" field="email" />
                                        </div>
                                    </div>
                                    <div class="js-add-field row mb-4">
                                        <label class="col-sm-3 col-form-label form-label">{{ $t("Phone") }} <span class="form-label-secondary">(Optional)</span></label>
                                        <div class="col-sm-9">
                                            <div class="input-group">
                                                <input v-model="form.phone" type="text" class="form-control" :placeholder="$t('Enter your phone number')">
                                                <HasError :form="form" field="phone" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label class="col-sm-3 col-form-label form-label">{{ $t("Gender") }}</label>
                                        <div class="col-sm-9">
                                            <div class="input-group input-group-md-down-break">
                                                <label class="form-control" :for="gender.name" v-for="gender in genders">
                                                  <span class="form-check">
                                                    <input type="radio" class="form-check-input" :id="gender.name" :value="gender.id" v-model="form.gender_id">
                                                    <span class="form-check-label">{{ gender.name }}</span>
                                                  </span>
                                                </label>
                                                <HasError :form="form" field="gender_id" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label class="col-sm-3 col-form-label form-label">{{ $t("About me") }}</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" v-model="form.bio" :placeholder="$t('Enter information about your self.')"></textarea>
                                            <HasError :form="form" field="bio" />
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer pt-0">
                                    <div class="d-flex justify-content-end gap-3">
                                        <button type="submit" class="btn btn-primary" href="javascript:;">{{ $t("Save changes") }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card">
                            <div class="card-header border-bottom">
                                <h4 class="card-header-title">Delete your account</h4>
                            </div>
                            <div class="card-body">
                                <p class="card-text">When you delete your account, you lose access to Front account services, and we permanently delete your personal data. You can cancel the deletion for 14 days.</p>
                                <div class="mb-4">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="deleteAccountCheckbox">
                                        <label class="form-check-label" for="deleteAccountCheckbox">Confirm that I want to delete my account.</label>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-danger" @click="removeProfile">Delete</button>
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
import AuthService from '@/js/services/authService';
import {mapGetters} from "vuex";
import Form from '@/js/form';
import Header from "../../components/profile/Header";

export default {
    components: {Header, Sidebar},
    computed: {
        ...mapGetters(['isAuthenticated', 'user', 'genders']),
        image: function () {
            if (this.user.picture) {
                return "/storage/picture/"+this.user.picture;
            }
            return "/assets/img/no-image.png";
        }
    },
    data: () => ({
        form: new Form({
            'name': '',
            'surname': '',
            'email': '',
            'phone': '',
            'gender_id': '',
            'bio': '',
            'file': '',
            'delete_file': '',
        }),
        resent: false,
    }),
    mounted() {
        this.getUserData();

        this.form.fill(this.user);
        this.form.file = null;
    },
    methods: {
        removeProfile() {
            this.form.delete('/profile').then(res => {

            }).catch(() => {

            })
        },
        handleFile (event) {
            this.form.file = event.target.files[0];
        },
        save() {
            this.form.post('/profile').then(res => {
                this.form.delete_file = null;
                this.getUserData();
            }).catch(() => {

            })
        },
        removePicture() {
            this.form.file = null;
            this.form.delete_file = 1;
            this.save();
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
        resend() {
            this.send()
                .then((success) => {
                    if (success) {
                        this.resent = true;
                        this.$store.dispatch('setAlert', {success: true, message: this.$t('Please check your email for verification details.')});
                    } else {
                        this.$store.dispatch('setAlert', {success: true, message: this.$t('Something went wrong, please try again later.')});
                    }
                })
                .catch((e) => {

                })
        },
        send() {
            return new Promise((resolve, reject) => {
                this.form.post('/resend').then(res => {
                    const { data } = res.data;
                    resolve(data.success);
                }).catch(() => {
                    reject();
                })
            })
        }
    },
    metaInfo: {
        title: 'Edit profile',
    }
}
</script>
