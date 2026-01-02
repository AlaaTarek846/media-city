<template>
      <div>
          <!-- Page Header -->
          <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <h1 class="page-title fw-semibold fs-18 mb-0">{{ $t('global.contactMessage') }}</h1>
            <div class="ms-md-1 ms-0">
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><router-link :to="{name: 'dashboard'}">{{$t('global.home')}}</router-link></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $t('global.contactMessage') }}</li>
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
                        <!-- Tabs for filtering -->
                        <ul class="nav nav-tabs mb-3" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button
                                    class="nav-link"
                                    :class="{ active: activeTab === 'all' }"
                                    @click="changeTab('all')"
                                    type="button"
                                >
                                    {{ $t("notification.all_messages") }}
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
                                    <th scope="col">{{ $t('global.name') }}</th>
                                    <th scope="col">{{ $t('label.phone') }}</th>
                                    <th scope="col">{{ $t('label.email') }}</th>
                                    <th scope="col">{{ $t('global.subject') }}</th>
                                    <th scope="col">{{ $t('global.message') }}</th>
                                    <th scope="col">{{ $t('label.status') }}</th>
                                    <th scope="col">{{ $t('notification.read_at') }}</th>
                                    <th scope="col">{{ $t('global.created_at') }}</th>
                                    <th scope="col">{{ $t('global.actions') }}</th>
                                </tr>
                                </thead>
                                <tbody v-if="data && data.length">
                                <tr v-for="(item,index) in data" :key="item.id" :class="{ 'table-secondary': item.is_read }">
                                    <td scope="row">{{index + 1}}</td>
                                    <td>{{item.name}}</td>
                                    <td>{{item.phone}}</td>
                                    <td>{{item.email}}</td>
                                    <td>{{item.subject}}</td>
                                    <td>
                                        <div style="max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                            {{item.message}}
                                        </div>
                                    </td>
                                    <td>
                                        <span
                                            class="badge"
                                            :class="item.is_read ? 'bg-success' : 'bg-warning'"
                                        >
                                            {{ item.is_read ? $t("notification.read") : $t("notification.unRead") }}
                                        </span>
                                    </td>
                                    <td>{{ item.read_at || '-' }}</td>
                                    <td>{{item.created_at}}</td>
                                    <td>
                                        <button
                                            v-if="!item.is_read"
                                            class="btn btn-sm btn-primary"
                                            @click="markAsRead(item.id)"
                                        >
                                            {{ $t("notification.mark_as_read") }}
                                        </button>
                                        <span v-else class="text-muted">{{ $t("notification.read") }}</span>
                                    </td>
                                </tr>
                                </tbody>
                                <tbody v-else>
                                    <tr>
                                        <th class="text-center" colspan="10">{{ $t('global.NoDataFound') }}</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <Pagination :limit="2" :data="dataPaginate" @pagination-change-page="getData">
                            <template #prev-nav>
                                <span>&lt; {{$t('global.Previous')}}</span>
                            </template>
                            <template #next-nav>
                                <span>{{$t('global.Next')}} &gt;</span>
                            </template>
                        </Pagination>
                    </div>
                </div>
            </div>
        </div>
        <!-- End:: data table -->
      </div>
</template>

<script>
import {onBeforeMount, inject, toRefs, ref} from "vue";
import crud from "../../../composable/crud_structure";
import adminApi from "../../../api/adminAxios";

export default {
    name: "index",
    setup(props){
        const emitter = inject('emitter');
        const {getData,loading,data,dataPaginate,permission,uri,showModelCreate,showEditMode,deleteData,search,type,dataRow,modalShow,filter,pagePaginate} = crud();
        
        const activeTab = ref('all');
        const unreadCount = ref(0);

        search.value = {
            searchKey : '',
            searchInTranslations: true,
            columns: ['id','name','phone','email','subject','message'],
            searchInRelations: []
        }
        
        // Override getData to include filter
        const originalGetData = getData;
        const getDataWithFilter = (page = 1) => {
            loading.value = true;
            const filterParam = activeTab.value === 'all' ? null : activeTab.value;
            
            adminApi
                .get(`/dashboard/contact-message`, {
                    params: {
                        filter: filterParam,
                        page: page,
                        ...search.value.searchKey ? { search: search.value.searchKey } : {}
                    }
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
                })
                .catch((err) => {
                    console.log(err.response);
                    loading.value = false;
                });
        };
        
        const changeTab = (tab) => {
            activeTab.value = tab;
            getDataWithFilter(1);
        };
        
        const markAsRead = (id) => {
            adminApi
                .post(`/dashboard/contact-message/${id}/read`)
                .then((res) => {
                    const message = data.value.find(m => m.id === id);
                    if (message) {
                        message.is_read = true;
                        message.read_at = res.data.data.read_at;
                    }
                    getUnreadCount();
                    if (activeTab.value === 'unread') {
                        data.value = data.value.filter(m => m.id !== id);
                    }
                })
                .catch((err) => {
                    console.log(err.response);
                });
        };
        
        const getUnreadCount = () => {
            adminApi
                .get(`/dashboard/notifications/unread-count`)
                .then((res) => {
                    if (res.data.data && typeof res.data.data.count === 'number') {
                        unreadCount.value = res.data.data.count;
                    }
                })
                .catch((err) => {
                    console.log(err.response);
                });
        };
        
        onBeforeMount(() => {
            uri.value = 'contact-message';
            getDataWithFilter();
            getUnreadCount();
        });

        return {
            getData: getDataWithFilter,
            loading,
            search,
            permission,
            deleteData,
            showEditMode,
            showModelCreate,
            data,
            dataPaginate,
            type,
            dataRow,
            modalShow,
            pagePaginate,
            activeTab,
            unreadCount,
            changeTab,
            markAsRead,
            getUnreadCount
        };
    }
}
</script>

