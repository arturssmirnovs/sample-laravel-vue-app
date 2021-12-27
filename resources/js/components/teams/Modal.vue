<template>
    <div>
        <div class="modal fade show" id="loginModal" tabindex="-1" role="dialog" aria-hidden="true" style="display: block">
            <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-close">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="$emit('closeModal')"></button>
                    </div>
                    <div class="modal-body">
                        <div id="loginModalFormLogin">
                            <div class="text-center mb-5" v-if="!editable">
                                <h3 class="modal-title">{{ $t("Create team") }}</h3>
                                <p>{{ $t("Create your team") }}</p>
                            </div>
                            <div class="text-center mb-5" v-else>
                                <h3 class="modal-title">{{ $t("Edit team") }}</h3>
                                <p>{{ $t("Manage your team") }}</p>
                            </div>

                            <form @submit.prevent="save" @keydown="form.onKeydown($event)">
                                <div class="mb-3">
                                    <label class="form-label">{{ $t("Profile photo") }}</label>
                                    <div class="d-flex align-items-center">
                                        <label class="avatar avatar-xl avatar-circle" for="avatarUploader">
                                            <img id="avatarImg" class="avatar-img" :src="image" alt="Image Description">
                                        </label>
                                        <div class="d-grid d-sm-flex gap-2 ms-4">
                                            <div class="form-attachment-btn btn btn-primary btn-sm">{{ $t("Upload photo") }}
                                                <input type="file" class="js-file-attach form-attachment-btn-label" id="avatarUploader" @change="handleFile">
                                            </div>
                                            <button type="button" v-if="form.file || editable && editable.logo" class="js-file-attach-reset-img btn btn-white btn-sm" @click="removePicture()">{{ $t("Delete") }}</button>
                                        </div>
                                    </div>
                                    <HasError :form="form" field="file" class="mt-3" />
                                </div>
                                <div class="mb-3">
                                    <label for="name" class="form-label">{{ $t("Name") }}</label>
                                    <input id="name" v-model="form.name" type="text" name="name" class="form-control" :placeholder="$t('Enter your team name')">
                                    <HasError :form="form" field="name" />
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">{{ $t("Description") }}</label>
                                    <input id="description" v-model="form.description" type="text" name="description" class="form-control" :placeholder="$t('Enter short description')">
                                    <HasError :form="form" field="description" />
                                </div>
                                <div class="d-grid mb-3">
                                    <Button :form="form" class="btn btn-primary btn-lg">
                                        {{ editable ? $t("Edit") : $t("Create") }}
                                    </Button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    </div>
</template>

<script>
import Form from '@/js/form';

export default {
    props: ['editable'],
    data: () => ({
        form: new Form({
            name: '',
            description: '',
            file: '',
        })
    }),
    mounted() {
        if (this.editable) {
            this.form.fill(this.editable);
        }
    },
    methods: {
        handleFile (event) {
            this.form.file = event.target.files[0];
        },
        removePicture() {
            this.form.file = null;
            this.form.delete_file = 1;
        },
        save() {
            this.send()
                .then((data) => {
                    this.$emit('closeModal');
                })
                .catch(() => {

                })
        },
        send() {
            if (this.editable) {
                var form = this.form.post('/teams/'+this.editable.id+'?_method=PUT');
            } else {
                var form = this.form.post('/teams');
            }

            return new Promise((resolve, reject) => {
                form.then(res => {
                    const { data } = res.data;
                    resolve(data);
                }).catch(() => {
                    reject();
                })
            })
        }
    },
    created() {
        document.querySelector('body').classList.add('modal-open');
        document.querySelector('body').style.overflow = 'hidden';
    },
    destroyed() {
        document.querySelector('body').classList.remove('modal-open');
        document.querySelector('body').style.removeProperty('overflow');
    },
    computed: {
        image: function () {
            if (this.editable && this.editable.logo) {
                return "/storage/logo/"+this.editable.logo;
            }
            return "/assets/img/no-image.png";
        }
    },
}

</script>
