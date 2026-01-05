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
                    <div class="card-title row col-12">
                        <div class="col-md-3">
                            <input class="form-control py-2 me-2" v-model="search.searchKey" @input="getDataWithFilter(1)" :placeholder="$t('global.Search')">
                        </div>
                        <div class="col-md-2">
                            <select class="form-control py-2" v-model="dateFilter" @change="handleDateFilterChange">
                                <option value="today">{{ $t('global.today') }}</option>
                                <option value="yesterday">{{ $t('global.yesterday') }}</option>
                                <option value="all">{{ $t('global.all') }}</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="date" class="form-control py-2" v-model="selectedDate" @change="handleDateSearch" :placeholder="$t('global.select_date')">
                        </div>
                    </div>

                    <div class="prism-toggle">

                    </div>
                </div>
                <div class="card-body">
                    <!-- Tabs for filtering -->
                    <ul class="nav nav-tabs mb-3" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button
                                class="nav-link"
                                :class="{ active: activeTab === 'all' }"
                                @click="changeTab('all')"
                                type="button"
                            >
                                {{ $t("notification.all_orders") }}
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button
                                class="nav-link"
                                :class="{ active: activeTab === 'unread' }"
                                @click="changeTab('unread')"
                                type="button"
                            >
                                {{ $t("notification.unRead") }}
                                <span v-if="unreadCount > 0" class="badge bg-danger ms-1">{{ unreadCount }}</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button
                                class="nav-link"
                                :class="{ active: activeTab === 'read' }"
                                @click="changeTab('read')"
                                type="button"
                            >
                                {{ $t("notification.read") }}
                            </button>
                        </li>
                    </ul>
                    
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
                                    <th scope="col">{{ $t('global.Shipping') }}</th>
                                    <th scope="col">{{ $t('global.total') }}</th>
                                    <th scope="col">{{ $t('label.status') }}</th>
                                    <th scope="col">{{ $t('global.order_status') }}</th>
                                    <th scope="col">{{ $t('notification.read_at') }}</th>
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
                                        {{ item.shipping_price ? item.shipping_price : '---' }}
                                    </td>
                                    <td>
                                        {{ item.total ? item.total : '---' }}
                                    </td>
                                    <td>
                                        <button
                                            v-if="!item.is_read"
                                            class="btn btn-sm btn-primary"
                                            @click="markAsRead(item.id)"
                                        >
                                            {{ $t("notification.mark_as_read") }}
                                        </button>
                                        <span v-else class="badge bg-success">{{ $t("notification.read") }}</span>
                                    </td>
                                    <td>
                                        {{ item.order_status }}
                                    </td>
                                    <td>{{ item.read_at || '-' }}</td>
                                    <td>{{ item.created_at }}</td>
                                    <td>
                                        <div class="hstack gap-2 fs-15">

                                            <button @click.prevent="showDataModel(item); if(!item.is_read) markAsRead(item.id)" data-bs-toggle="modal"
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
                                    <th class="text-center" colspan="13">{{ $t('global.NoDataFound') }}</th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <Pagination :limit="2" :data="dataPaginate" @pagination-change-page="getDataWithFilter">
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
import { onBeforeMount, inject, toRefs, ref, watch, nextTick } from "vue";
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
        const { getData, loading, data, dataPaginate, permission, uri, showModelCreate, showEditMode, deleteData, search, type, dataRow, modalShow, filter, showData, showDataModel, pagePaginate, overrideGetData } = crud();
        const {t} = useI18n({});
        let showOrderStatus = ref(false);
        const dateFilter = ref('today');
        const selectedDate = ref('');
        const skipWatcher = ref(true);
        const activeTab = ref('all');
        const unreadCount = ref(0);

        // Set search configuration
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

        // Override getData to include date filter
        const originalGetData = getData;
        const getDataWithFilter = (page = 1) => {
            loading.value = true;
            
            // Get today's date in YYYY-MM-DD format (local timezone)
            const today = new Date();
            const todayStr = today.getFullYear() + '-' + 
                            String(today.getMonth() + 1).padStart(2, '0') + '-' + 
                            String(today.getDate()).padStart(2, '0');
            
            // Get yesterday's date
            const yesterday = new Date(today);
            yesterday.setDate(yesterday.getDate() - 1);
            const yesterdayStr = yesterday.getFullYear() + '-' + 
                                String(yesterday.getMonth() + 1).padStart(2, '0') + '-' + 
                                String(yesterday.getDate()).padStart(2, '0');

            let dateFilterParam = null;
            if (dateFilter.value === 'today') {
                dateFilterParam = todayStr;
            } else if (dateFilter.value === 'yesterday') {
                dateFilterParam = yesterdayStr;
            }

            const params = {
                page: page
            };

            // Add filter for read status
            if (activeTab.value !== 'all') {
                params.filter = activeTab.value;
            }

            // Add date filter - prioritize specific date search, otherwise use filter
            if (selectedDate.value) {
                params.date_search = selectedDate.value;
            } else if (dateFilterParam) {
                // Apply date filter (today or yesterday)
                params.date_filter = dateFilterParam;
            }
            // If 'all' or no filter, don't add any date filter

            // Add search if exists
            if (search.value.searchKey) {
                params.search = JSON.stringify(search.value);
            }

            adminApi
                .get(`/dashboard/order`, {
                    params: params
                })
                .then((res) => {
                    data.value = res.data.data;
                    dataPaginate.value = {
                        current_page: res.data.pagination.current_page,
                        last_page: res.data.pagination.last_page,
                        per_page: res.data.pagination.per_page,
                        total: res.data.pagination.total,
                    };
                    loading.value = false;
                    // Fetch unread count after loading data
                    fetchUnreadCount();
                })
                .catch((err) => {
                    console.log(err.response);
                    loading.value = false;
                });
        };

        const handleDateFilterChange = () => {
            selectedDate.value = ''; // Clear date search when filter changes
            getDataWithFilter(1);
        };

        const handleDateSearch = () => {
            dateFilter.value = 'all'; // Reset filter to all when searching by date
            getDataWithFilter(1);
        };

        const changeTab = (tab) => {
            activeTab.value = tab;
            getDataWithFilter(1);
        };

        const markAsRead = (id) => {
            adminApi
                .post(`/dashboard/order/${id}/read`)
                .then((res) => {
                    const order = data.value.find(o => o.id === id);
                    if (order) {
                        order.is_read = true;
                        // Update read_at from response
                        if (res.data && res.data.data && res.data.data.read_at) {
                            order.read_at = res.data.data.read_at;
                        }
                        unreadCount.value = Math.max(0, unreadCount.value - 1);
                    }
                    // If we're on unread tab, remove the order from the list
                    if (activeTab.value === 'unread') {
                        data.value = data.value.filter(o => o.id !== id);
                    }
                    // Refresh unread count
                    fetchUnreadCount();
                })
                .catch((err) => {
                    console.log(err.response);
                });
        };

        // Fetch unread count
        const fetchUnreadCount = () => {
            adminApi
                .get(`/dashboard/order/unread-count`)
                .then((res) => {
                    let count = 0;
                    if (res.data) {
                        if (res.data.data && typeof res.data.data.count === 'number') {
                            count = res.data.data.count;
                        } else if (res.data.data && typeof res.data.data === 'number') {
                            count = res.data.data;
                        } else if (typeof res.data.count === 'number') {
                            count = res.data.count;
                        }
                    }
                    unreadCount.value = count;
                })
                .catch((err) => {
                    unreadCount.value = 0;
                });
        };

        onBeforeMount(() => {
            uri.value = 'order';
            // Override getData in crud so watcher uses our custom function
            overrideGetData(getDataWithFilter);
            // Load data immediately with date filter
            getDataWithFilter(1);
            // Fetch unread count
            fetchUnreadCount();
        });

        let showOrderMode = (row) => {
            dataRow.value=row;
            type.value='edit';
            showOrderStatus.value=true;
        }


        return { getData: getDataWithFilter, loading, search, permission, deleteData, showEditMode, showModelCreate, data, dataPaginate, type, showData, showDataModel, dataRow, modalShow, pagePaginate,selectedUser,showOrderStatus,showOrderMode, dateFilter, selectedDate, handleDateFilterChange, handleDateSearch, activeTab, unreadCount, changeTab, markAsRead };

    }
}
</script>
