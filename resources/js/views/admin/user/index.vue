<template>
    <div>
            <!-- Page Header -->
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0">{{ $t('global.users') }}</h1>
        <div class="ms-md-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><router-link
                            :to="{ name: 'dashboard' }">{{ $t('global.home') }}</router-link></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $t('global.users') }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header Close -->
    <!-- Start:: data table -->
    <div class="row">
        <div class="col-xl-12">
            <loader v-if="loading" />
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <search-and-filters @search="(val) => search.searchKey = val" />

                    <div class="prism-toggle">

                        <button @click="selectedUser = 'all'" data-bs-toggle="modal"
                                v-if="permission.includes('user send notification')"
                                data-bs-target="#send-notification" :title="$t('global.send_notification')"
                                class="btn btn-sm btn-warning-light ms-3"><i class="bx bx-bell header-link-icon"></i>
                                {{ $t('global.send_notification_to_all') }} </button>

                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive mb-2">
                        <table class="table text-nowrap table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">{{ $t('global.name') }}</th>
                                    <th scope="col">{{ $t('global.phone') }}</th>
                                    <th scope="col">{{ $t('global.email') }}</th>
                                    <th scope="col">{{ $t('label.status') }}</th>
                                    <th scope="col">{{ $t('global.created_at') }}</th>

                                    <th scope="col">{{ $t('global.action') }}</th>
                                </tr>
                            </thead>
                            <tbody v-if="data && data.length">
                                <tr v-for="(item, index) in data" :key="item.id">
                                    <td scope="row">{{ index + 1 }}</td>
                                    <td>{{ item.name }}</td>
                                    <td><span dir="ltr">{{ item.phone }}</span> </td>
                                    <td>{{ item.email }}</td>
                                    <td>
                                        <span class="badge rounded-pill bg-success-transparent"
                                            v-if="item.status">{{ $t('global.activated') }}</span>
                                        <span class="badge rounded-pill bg-danger-transparent"
                                            v-else>{{ $t('global.Inactive') }}</span>
                                    </td>
                                    <td>{{ item.created_at }}</td>
                                    <td>
                                        <div class="hstack gap-2 fs-15">

                                            <button @click.prevent="showDataModel(item)" data-bs-toggle="modal"
                                                data-bs-target="#show"
                                                class="btn btn-icon btn-sm btn-success-transparent rounded-pill"
                                                :title="$t('global.show')">
                                                <i class="ri-eye-line"></i>
                                            </button>
                                            <a href="#" @click.prevent="accept(item.id, item.name)"
                                                v-if="permission.includes('user edit') && parseInt(item.status) != 1"
                                                class="btn btn-icon btn-sm btn-success-transparent rounded-pill" :title="$t('global.activation')"><i
                                                    class="ri-check-line"></i>
                                                </a>
                                                <a href="#" @click.prevent="reject(item.id, item.name)"
                                                v-if="permission.includes('user edit') && parseInt(item.status)  != 0"
                                                class="btn btn-icon btn-sm btn-danger-transparent rounded-pill" :title="$t('global.deactivate')"><i
                                                    class="ri-close-line"></i>
                                                </a>
                                                <a @click="selectedUser = item" data-bs-toggle="modal"
                                                    v-if="permission.includes('user send notification')"
                                                    data-bs-target="#send-notification"
                                                    :title="$t('global.send_notification')"
                                                    class="btn btn-icon btn-sm btn-warning-transparent rounded-pill"><i
                                                        class="bx bx-bell header-link-icon"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr>
                                    <th class="text-center" colspan="8">{{ $t('global.NoDataFound') }}</th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <Pagination :limit="2" :data="dataPaginate" @pagination-change-page="getData">
                        <template #prev-nav>
                            <span>&lt; {{ $t('global.Previous') }}</span>
                        </template>
                        <template #next-nav>
                            <span>{{ $t('global.Next') }} &gt;</span>
                        </template>
                    </Pagination>
                </div>
            </div>
        </div>
        <Show v-model="showData" :dataRow="dataRow" type="order" />
        <SendNotification :selectedUser="selectedUser" :type="'App\\Models\\User'" />
    </div>
    <!-- End:: data table -->
    </div>
</template>

<script>
import { onBeforeMount, inject, toRefs,ref } from "vue";
import crud from "../../../composable/crud_structure";
import Show from "./Show.vue";
import {useI18n} from "vue-i18n";
import adminApi from "../../../api/adminAxios";
import SendNotification from "../../../components/general/SendNotification.vue"

export default {
    name: "index",
    components: {
        Show,SendNotification
    },
    setup(props) {
        const emitter = inject('emitter');
         const selectedUser = ref({});
        const { getData, loading, data, dataPaginate, permission, uri, showModelCreate, showEditMode, deleteData, search, type, dataRow, modalShow, filter, showData, showDataModel, pagePaginate } = crud();
        const {t} = useI18n({});

        search.value = {
            searchKey: '',
            searchInTranslations: true,
            columns: ['id', 'name','phone', 'email'],
            searchInRelations: [
                // {
                //     relation: 'roles',
                //     columns: ['name'],
                //     searchInRelationTranslations:false
                // }
            ]
        }
        onBeforeMount(() => {
            uri.value = 'user';
            getData();
        });

        function reject(id, name) {
            // Confirm deletion
            Swal.fire({
                title: `${t('reasonTypeTitle.Deactivation')} ${name}?`,
                text: `${t("global.YouWontBeAbleToRevertThis")}`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    adminApi.put(`dashboard/user/${id}`, {status:0})
                        .then((res) => {
                            getData();
                            Swal.fire({
                                icon: 'success',
                                title: `${this.t('global.EditSuccessfully')}`,
                                showConfirmButton: false,
                                timer: 1500
                            });

                        })
                        .catch((err) => {
                            Swal.fire({
                                icon: 'error',
                                title: `${this.t('global.Error')}`,
                                showConfirmButton: false,
                                timer: 1500
                            });
                        });
                }
            });
        }

        function accept(id, name) {
            // Confirm deletion
            Swal.fire({
                title: `${t('reasonTypeTitle.Activation')} ${name}?`,
                text: `${t("global.YouWontBeAbleToRevertThis")}`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Perform deletion
                    adminApi.put(`dashboard/user/${id}`,{status:1})
                        .then((res) => {
                            getData();
                            Swal.fire({
                                icon: 'success',
                                title: `${this.t('global.EditSuccessfully')}`,
                                showConfirmButton: false,
                                timer: 1500
                            });

                        })
                        .catch((err) => {
                            Swal.fire({
                                icon: 'error',
                                title: `${this.t('global.Error')}`,
                                showConfirmButton: false,
                                timer: 1500
                            });
                        });
                }
            });
        }


        return {accept, reject, getData, loading, search, permission, deleteData, showEditMode, showModelCreate, data, dataPaginate, type, showData, showDataModel, dataRow, modalShow, pagePaginate,selectedUser };

    }
}
</script>
