<template>
    <main id="content" role="main" class="bg-light">

        <Header/>

        <div class="container content-space-1 content-space-t-lg-0 content-space-b-lg-2 mt-lg-n10">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-header-title">{{ $t("Target") }}</h4>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                                <thead class="thead-light">
                                <tr>
                                    <th>{{ $t("Name") }}</th>
                                    <th style="width: 5%;"></th>
                                </tr>
                                </thead>
                                <tbody v-if="projects && projects.data">
                                    <tr v-for="target in projects.data.targets">
                                        <td @click="view(target)">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <img class="avatar avatar-sm avatar-circle" :src="target.logo ? '/storage/logo/'+target.logo : '/assets/img/no-image.png'" alt="Image Description">
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <a class="d-inline-block link-dark" href="#">
                                                        <h6 class="text-hover-primary mb-0">{{ target.domain }}</h6>
                                                    </a>
                                                    <small class="d-block">{{ target.status ? target.status : "-" }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a class="text-body me-2" href="javascript:;" @click="view(target)" data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                                <i class="bi-eye"></i>
                                            </a>
                                            <a class="text-body me-2" href="javascript:;" @click="editTeam(target)" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                <i class="bi-pencil"></i>
                                            </a>
                                            <a class="text-body" href="javascript:;" @click="deleteTeam(target)" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                                                <i class="bi-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer border-top">
                            <div class="d-flex justify-content-end gap-3">
                                <a class="btn btn-primary" href="javascript:;" @click="showModal=true;">{{ $t("Create target") }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <Modal v-if="showModal" v-on:closeModal="hideModal" :editable="editable" :id="$route.params.id" />
        <ViewModal v-if="showViewModal" v-on:closeModal="hideViewModal" :editable="viewable" />
    </main>
</template>

<script>
import Sidebar from "../../components/profile/Sidebar";
import {mapGetters} from "vuex";
import Header from "../../components/profile/Header";
import Modal from "../../components/targets/Modal";
import ViewModal from "../../components/targets/View";
import projectsService from "../../services/projectsService";

export default {
    components: {Modal, Header, Sidebar, ViewModal},
    computed: {
        ...mapGetters(['isAuthenticated', 'user', 'providers', 'projects'])
    },
    data: () => ({
        showViewModal: false,
        showModal: false,
        editable: null,
        viewable: null
    }),
    mounted() {
        this.getData();
    },
    methods: {
        view(project) {
            this.showViewModal = true;
            this.viewable = project;
        },
        editTeam(project) {
            this.editable = project;
            this.showModal = true;
        },
        deleteTeam(project) {
            projectsService.destroy(project.id).then((res) => {
                this.getData();
            }).catch(() => {

            })
        },
        getData() {
            projectsService.show(this.$route.params.id).then((res) => {
                this.$store.dispatch('addProjects', res.data);
            }).catch(() => {

            })
        },
        hideModal() {
            this.showModal = false;
            this.getData();
        },
        hideViewModal() {
            this.showViewModal = false;
            this.getData();
        }
    },
    metaInfo: {
        title: 'Teams',
    }
}
</script>
