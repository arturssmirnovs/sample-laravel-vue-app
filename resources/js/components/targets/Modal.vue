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
                                <h3 class="modal-title">{{ $t("Create target") }}</h3>
                                <p>{{ $t("Create your target") }}</p>
                            </div>
                            <div class="text-center mb-5" v-else>
                                <h3 class="modal-title">{{ $t("Edit target") }}</h3>
                                <p>{{ $t("Manage your target") }}</p>
                            </div>

                            <form @submit.prevent="save" @keydown="form.onKeydown($event)">
                                <div class="mb-3">
                                    <label for="name" class="form-label">{{ $t("Name") }}</label>
                                    <textarea id="name" v-model="form.name" class="form-control"></textarea>
                                    <HasError :form="form" field="name" />
                                </div>
                                <div class="mb-3">
                                    <label for="status" class="form-label">{{ $t("Status") }}</label>
                                    <select id="status" v-model="form.status" class="form-control">
                                        <option value="active">{{ $t("Active") }}</option>
                                        <option value="pending">{{ $t("Pending") }}</option>
                                        <option value="archived">{{ $t("Archived") }}</option>
                                    </select>
                                    <HasError :form="form" field="status" />
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
    props: ['editable', 'id'],
    data: () => ({
        form: new Form({
            name: '',
            status: null,
            project_id: '',
        })
    }),
    mounted() {
        this.form.project_id = this.$props.id;
        if (this.editable) {
            this.form.fill(this.editable);
            this.form.name = this.editable.domain;
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
                var form = this.form.post('/targets/'+this.editable.id+'?_method=PUT');
            } else {
                var form = this.form.post('/targets');
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
