<template>
    <div>
        <div class="modal fade show" id="loginModal" tabindex="-1" role="dialog" aria-hidden="true" style="display: block">
            <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-close">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="$emit('closeModal')"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <ul class="nav nav-segment nav-pills mb-7" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="nav-one-eg1-tab" href="#nav-one-eg1" data-bs-toggle="pill" data-bs-target="#nav-one-eg1" role="tab" aria-controls="nav-one-eg1" aria-selected="true">
                                        {{ $t("Information") }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="nav-three-eg2-tab" href="#nav-three-eg2" data-bs-toggle="pill" data-bs-target="#nav-three-eg2" role="tab" aria-controls="nav-three-eg2" aria-selected="false">
                                        {{ $t("Notes") }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="nav-three-eg1-tab" href="#nav-three-eg1" data-bs-toggle="pill" data-bs-target="#nav-three-eg1" role="tab" aria-controls="nav-three-eg1" aria-selected="false">
                                        {{ $t("Tools") }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <select id="status" v-model="targetForm.status" class="form-control" @change="saveTarget">
                                        <option value="active">{{ $t("Active") }}</option>
                                        <option value="pending">{{ $t("Pending") }}</option>
                                        <option value="archived">{{ $t("Archived") }}</option>
                                    </select>
                                </li>
                            </ul>
                        </div>

                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="nav-one-eg1" role="tabpanel" aria-labelledby="nav-one-eg1-tab">
                                <div v-if="item">
                                    <div class="text-center mb-5">
                                        <h3 class="modal-title">{{ item.domain }}</h3>
                                        <p>{{ item.status }}</p>
                                    </div>
                                    <p style="white-space: pre-wrap;">{{ item.information }}</p>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-three-eg2" role="tabpanel" aria-labelledby="nav-three-eg2-tab">

                                <div class="table-responsive">
                                    <table class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                                        <thead class="thead-light">
                                        <tr>
                                            <th>{{ $t("Note") }}</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody v-if="item">
                                        <tr v-for="target in item.notes">
                                            <td>
                                                <p style="white-space: pre-wrap;">{{ target.description }}</p>
                                            </td>
                                            <td class="text-right">
                                                {{ target.created_at }}
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <hr />

                                <div>
                                    <div class="text-center mt-5 mb-5">
                                        <h3 class="modal-title">{{ $t("Notes") }}</h3>
                                        <p>{{ $t("Notes about the target") }}</p>
                                    </div>
                                    <form @submit.prevent="save" @keydown="form.onKeydown($event)">
                                        <div class="mb-3">
                                            <label for="description" class="form-label">{{ $t("Description") }}</label>
                                            <textarea id="description" v-model="form.description" type="text" name="description" class="form-control"></textarea>
                                            <HasError :form="form" field="description" />
                                        </div>
                                        <div class="d-grid mb-3">
                                            <Button :form="form" class="btn btn-primary btn-lg">
                                                {{ $t("Save information") }}
                                            </Button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-three-eg1" role="tabpanel" aria-labelledby="nav-three-eg1-tab">
                                <div>
                                    <div class="text-center mb-5">
                                        <h3 class="modal-title">{{ $t("Tools") }}</h3>
                                        <p>{{ $t("Run custom tools on target") }}</p>
                                    </div>
                                    <form @submit.prevent="save" @keydown="form.onKeydown($event)">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">{{ $t("Email") }}</label>
                                            <input id="email" v-model="form.email" type="email" name="email" class="form-control" :placeholder="$t('Enter email')">
                                            <HasError :form="form" field="email" />
                                        </div>
                                        <div class="d-grid mb-3">
                                            <Button :form="form" class="btn btn-primary btn-lg">
                                                {{ $t("Invite") }}
                                            </Button>
                                        </div>
                                    </form>
                                </div>
                            </div>
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
import targetService from "../../services/targetService";

export default {
    props: ['editable'],
    data: () => ({
        form: new Form({
            description: '',
            target_id: null
        }),
        targetForm: new Form({
            status: null,
            name: null
        }),
        item: null,
        notes: []
    }),
    mounted() {
        this.form.target_id = this.editable.id;
        this.targetForm.name = this.editable.domain;
        this.targetForm.status = this.editable.status;

        this.load();
    },
    methods: {
        load() {
            targetService.show(this.editable.id).then((res) => {
                this.item = res.data.data;
            }).catch(() => {

            })
        },
        save() {
            this.send()
                .then((data) => {
                    this.load();
                })
                .catch(() => {

                })
        },
        send() {
            var form = this.form.post('/notes');

            return new Promise((resolve, reject) => {
                form.then(res => {
                    const { data } = res.data;
                    resolve(data);
                }).catch(() => {
                    reject();
                })
            })
        },
        saveTarget() {
            this.targetForm.post('/targets/'+this.editable.id+'?_method=PUT').then(res => {
                const { data } = res.data;
                this.load();
            }).catch(() => {

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
