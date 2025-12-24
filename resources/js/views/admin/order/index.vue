<template>
    <div>
            <!-- Page Header -->
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0">{{ $t('global.orders') }}</h1>
        <div class="ms-md-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><router-link :to="{ name: 'dashboard' }">{{ $t('global.home') }}</router-link></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $t('global.orders') }}</li>
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

                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive mb-2">
                        <table class="table text-nowrap table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">{{ $t('global.OrderNumber') }}</th>
                                    <th scope="col">{{ $t('global.client') }}</th>
                                    <th scope="col">{{ $t('global.applied_coupon') }}</th>
                                    <th scope="col">{{ $t('global.Discounts') }}</th>
                                    <th scope="col">{{ $t('label.subTotal') }}</th>
                                    <th scope="col">{{ $t('global.tax') }}</th>
                                    <th scope="col">{{ $t('global.Shipping') }}</th>
                                    <th scope="col">{{ $t('global.total') }}</th>
                                    <th scope="col">{{ $t('global.order_status') }}</th>
                                    <th scope="col">{{ $t('global.created_at') }}</th>

                                    <th scope="col">{{ $t('global.action') }}</th>
                                </tr>
                            </thead>
                            <tbody v-if="data && data.length">
                                <tr v-for="(item, index) in data" :key="item.id">
                                    <td scope="row">{{ index + 1 }}</td>
                                    <td>{{ item.order_number }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <span :class="['avatar avatar-xl me-3 avatar-rounded bg-success', parseInt(item.user_status) === 1 ? 'online' : 'offline']">
                                                    {{ item.user_name ? item.user_name.charAt(0) : '' }}
                                                </span>
                                            </div>
                                            <div>
                                                <div class="mb-2 fs-14 fw-semibold">
                                                    <a href="javascript:void(0);">{{item.user_name}}</a>
                                                </div>
                                                <div class="mb-1">
                                                    <span class="text-muted d-block"  dir="ltr">{{item.user_phone}}</span>
                                                    <span class="text-muted d-block"  dir="ltr">{{item.user_email}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    
                                     <td>
                                        {{ item.applied_coupon  ? item.applied_coupon + ' ( ' + item.coupon_discount + ' )' : '---' }}
                                    </td>
                                    <td>
                                        {{ item.discount ? item.discount : '---' }}
                                    </td>
                                    <td>
                                        {{ item.sub_total ? item.sub_total : '---' }}
                                    </td>
                                    <td>
                                        {{ item.tax ? item.tax + ' ( ' + item.tax_percentage +'%'+ ' )' : '---' }}
                                    </td>
                                    <td>
                                        {{ item.shipping_price ? item.shipping_price : '---' }}
                                    </td>
                                    <td>
                                        {{ item.total ? item.total : '---' }}
                                    </td>
                                    <td>
                                        {{ item.order_status }}
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
                                            <button v-if="permission.includes('order edit')"
                                                @click.prevent="showOrderMode(item)"
                                                data-bs-toggle="modal" data-bs-target="#add-admin-modal"
                                                    class="btn btn-icon btn-sm btn-secondary-transparent rounded-pill"
                                                    :title="$t('global.order edit')">
                                                <i class="ri-edit-box-line"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr>
                                    <th class="text-center" colspan="12">{{ $t('global.NoDataFound') }}</th>
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
        <orderStatus v-model="showOrderStatus" :dataRow="dataRow" @created="getData(pagePaginate)" />
    </div>
    <!-- End:: data table -->
    </div>
</template>

<script>
import { onBeforeMount, inject, toRefs,ref } from "vue";
import crud from "../../../composable/crud_structure";
import Show from "./Show.vue";
import orderStatus from "./orderStatus.vue";
import {useI18n} from "vue-i18n";
import adminApi from "../../../api/adminAxios";

export default {
    name: "index",
    components: {
        Show,orderStatus
    },
    setup(props) {
        const emitter = inject('emitter');
         const selectedUser = ref({});
        const { getData, loading, data, dataPaginate, permission, uri, showModelCreate, showEditMode, deleteData, search, type, dataRow, modalShow, filter, showData, showDataModel, pagePaginate } = crud();
        const {t} = useI18n({});
        let showOrderStatus = ref(false);

        search.value = {
            searchKey: '',
            searchInTranslations: true,
            columns: ['id','order_number'],
            searchInRelations: [
                {
                    relation: 'user',
                    columns: ['name','phone','email'],
                    searchInRelationTranslations:false
                },
                {
                    relation: 'orderStatus',
                    columns: ['id'],
                    searchInRelationTranslations:true
                },
                {
                    relation: 'discountCoupon',
                    columns: ['id'],
                    searchInRelationTranslations:true
                }
            ]
        }
        onBeforeMount(() => {
            uri.value = 'order';
            getData();
        });

        let showOrderMode = (row) => {
            dataRow.value=row;
            type.value='edit';
            showOrderStatus.value=true;
        }


        return { getData, loading, search, permission, deleteData, showEditMode, showModelCreate, data, dataPaginate, type, showData, showDataModel, dataRow, modalShow, pagePaginate,selectedUser,showOrderStatus,showOrderMode };

    }
}
</script>
