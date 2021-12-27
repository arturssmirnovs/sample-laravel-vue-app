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
                                        {{ $t("Members") }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="nav-two-eg1-tab" href="#nav-two-eg1" data-bs-toggle="pill" data-bs-target="#nav-two-eg1" role="tab" aria-controls="nav-two-eg1" aria-selected="false">
                                        {{ $t("Candidates") }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="nav-three-eg1-tab" href="#nav-three-eg1" data-bs-toggle="pill" data-bs-target="#nav-three-eg1" role="tab" aria-controls="nav-three-eg1" aria-selected="false">
                                        {{ $t("Invitations") }}
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="nav-one-eg1" role="tabpanel" aria-labelledby="nav-one-eg1-tab">
                                <div>
                                    <div class="text-center mb-5">
                                        <h3 class="modal-title">{{ $t("Manage team members") }}</h3>
                                        <p>{{ $t("Manage your team members & candidates") }}</p>
                                    </div>

                                    <table class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                                        <thead class="thead-light">
                                        <tr>
                                            <th>Name</th>
                                            <th>Status</th>
                                            <th>Access</th>
                                            <th style="width: 5%;"></th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <img class="avatar avatar-sm avatar-circle" src="/assets/img/160x160/img8.jpg" alt="Image Description">
                                                    </div>

                                                    <div class="flex-grow-1 ms-3">
                                                        <a class="d-inline-block link-dark" href="#">
                                                            <h6 class="text-hover-primary mb-0">Amanda Harvey <img class="avatar avatar-xss ms-1" src="/assets/svg/illustrations/top-vendor.svg" alt="Image Description" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Verified user" aria-label="Verified user"></h6>
                                                        </a>
                                                        <small class="d-block">amanda@example.com</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <!-- Select -->
                                                <div class="tom-select-custom">
                                                    <select class="js-select form-select form-select-sm tomselected" id="tomselect-1" tabindex="-1" hidden="hidden"><option value="memberStatusLabelActive1" data-option-template="<span class=&quot;d-flex align-items-center&quot;><span class=&quot;legend-indicator bg-success me-2&quot;></span> Active</span>" selected="true">Active</option>

                                                        <option value="memberStatusLabelInactive1" data-option-template="<span class=&quot;d-flex align-items-center&quot;><span class=&quot;legend-indicator bg-danger me-2&quot;></span> Inactive</span>">Inactive</option>
                                                    </select><div class="ts-control js-select form-select form-select-sm single plugin-change_listener plugin-hs_smart_position plugin-dropdown_input" tabindex="0"><div class="items ts-input full has-items"><span class="d-flex align-items-center item" data-value="memberStatusLabelActive1"><span class="legend-indicator bg-success me-2"></span> Active</span></div><div class="tom-select-custom"><div class="ts-dropdown single js-select form-select form-select-sm plugin-change_listener plugin-hs_smart_position plugin-dropdown_input" style="display: none;"><div class="dropdown-input-wrap"></div><div role="listbox" id="tomselect-1-ts-dropdown" tabindex="-1" class="ts-dropdown-content"></div></div></div></div>
                                                </div>
                                                <!-- End Select -->
                                            </td>
                                            <td>
                                                <!-- Select -->
                                                <div class="tom-select-custom">
                                                    <select class="js-select form-select form-select-sm tomselected" id="tomselect-2" tabindex="-1" hidden="hidden"><option value="memberStatusLabelAdmin1" selected="true">Admin</option>

                                                        <option value="memberStatusLabelCanEdit1">Can edit</option>
                                                        <option value="memberStatusLabelCanView1">Can view</option>
                                                    </select><div class="ts-control js-select form-select form-select-sm single plugin-change_listener plugin-hs_smart_position plugin-dropdown_input" tabindex="0"><div class="items ts-input full has-items"><div data-value="memberStatusLabelAdmin1" class="item">Admin</div></div><div class="tom-select-custom"><div class="ts-dropdown single js-select form-select form-select-sm plugin-change_listener plugin-hs_smart_position plugin-dropdown_input" style="display: none;"><div class="dropdown-input-wrap"></div><div role="listbox" id="tomselect-2-ts-dropdown" tabindex="-1" class="ts-dropdown-content"></div></div></div></div>
                                                </div>
                                                <!-- End Select -->
                                            </td>
                                            <td>
                                                <a class="text-body" href="javascript:;" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Locked">
                                                    <i class="bi-lock-fill"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-two-eg1" role="tabpanel" aria-labelledby="nav-two-eg1-tab">
                                <div>
                                    <div class="text-center mb-5">
                                        <h3 class="modal-title">{{ $t("Manage team members") }}</h3>
                                        <p>{{ $t("Manage your team members & candidates") }}</p>
                                    </div>

                                    <table class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                                        <thead class="thead-light">
                                        <tr>
                                            <th>Name</th>
                                            <th>Status</th>
                                            <th>Access</th>
                                            <th style="width: 5%;"></th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <img class="avatar avatar-sm avatar-circle" src="/assets/img/160x160/img8.jpg" alt="Image Description">
                                                    </div>

                                                    <div class="flex-grow-1 ms-3">
                                                        <a class="d-inline-block link-dark" href="#">
                                                            <h6 class="text-hover-primary mb-0">Amanda Harvey <img class="avatar avatar-xss ms-1" src="/assets/svg/illustrations/top-vendor.svg" alt="Image Description" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Verified user" aria-label="Verified user"></h6>
                                                        </a>
                                                        <small class="d-block">amanda@example.com</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <!-- Select -->
                                                <div class="tom-select-custom">
                                                    <select class="js-select form-select form-select-sm tomselected" id="tomselect-1" tabindex="-1" hidden="hidden"><option value="memberStatusLabelActive1" data-option-template="<span class=&quot;d-flex align-items-center&quot;><span class=&quot;legend-indicator bg-success me-2&quot;></span> Active</span>" selected="true">Active</option>

                                                        <option value="memberStatusLabelInactive1" data-option-template="<span class=&quot;d-flex align-items-center&quot;><span class=&quot;legend-indicator bg-danger me-2&quot;></span> Inactive</span>">Inactive</option>
                                                    </select><div class="ts-control js-select form-select form-select-sm single plugin-change_listener plugin-hs_smart_position plugin-dropdown_input" tabindex="0"><div class="items ts-input full has-items"><span class="d-flex align-items-center item" data-value="memberStatusLabelActive1"><span class="legend-indicator bg-success me-2"></span> Active</span></div><div class="tom-select-custom"><div class="ts-dropdown single js-select form-select form-select-sm plugin-change_listener plugin-hs_smart_position plugin-dropdown_input" style="display: none;"><div class="dropdown-input-wrap"></div><div role="listbox" id="tomselect-1-ts-dropdown" tabindex="-1" class="ts-dropdown-content"></div></div></div></div>
                                                </div>
                                                <!-- End Select -->
                                            </td>
                                            <td>
                                                <!-- Select -->
                                                <div class="tom-select-custom">
                                                    <select class="js-select form-select form-select-sm tomselected" id="tomselect-2" tabindex="-1" hidden="hidden"><option value="memberStatusLabelAdmin1" selected="true">Admin</option>

                                                        <option value="memberStatusLabelCanEdit1">Can edit</option>
                                                        <option value="memberStatusLabelCanView1">Can view</option>
                                                    </select><div class="ts-control js-select form-select form-select-sm single plugin-change_listener plugin-hs_smart_position plugin-dropdown_input" tabindex="0"><div class="items ts-input full has-items"><div data-value="memberStatusLabelAdmin1" class="item">Admin</div></div><div class="tom-select-custom"><div class="ts-dropdown single js-select form-select form-select-sm plugin-change_listener plugin-hs_smart_position plugin-dropdown_input" style="display: none;"><div class="dropdown-input-wrap"></div><div role="listbox" id="tomselect-2-ts-dropdown" tabindex="-1" class="ts-dropdown-content"></div></div></div></div>
                                                </div>
                                                <!-- End Select -->
                                            </td>
                                            <td>
                                                <a class="text-body" href="javascript:;" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Locked">
                                                    <i class="bi-lock-fill"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-three-eg1" role="tabpanel" aria-labelledby="nav-three-eg1-tab">
                                <div>
                                    <div class="text-center mb-5">
                                        <h3 class="modal-title">{{ $t("Invite team members") }}</h3>
                                        <p>{{ $t("Invite new team members & start collaborating together") }}</p>
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

export default {
    props: ['editable'],
    data: () => ({
        form: new Form({
            email: '',
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
