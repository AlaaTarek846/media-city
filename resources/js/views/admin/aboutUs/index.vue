<template>
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <h1 class="page-title fw-semibold fs-18 mb-0">{{ $t('global.aboutUs') }}</h1>
            <div class="ms-md-1 ms-0">
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><router-link :to="{name: 'dashboard'}">{{$t('global.home')}}</router-link></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $t('global.aboutUs') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- Page Header Close -->

        <!-- Data Table -->
        <div class="card custom-card">
            <div class="card-body">
                <div class="table-responsive">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex gap-2">
                            <button v-if="permission.includes('about us create')"
                                    @click="showModelCreate"
                                    class="btn btn-primary">
                                <i class="ri-add-line me-1"></i>
                                {{ $t('global.add') }} {{ $t('global.aboutUs') }}
                            </button>
                        </div>
                        <div class="d-flex gap-2 align-items-center">
<!--                            <input type="text"-->
<!--                                   v-model="search.searchKey"-->
<!--                                   @input="getData(1)"-->
<!--                                   class="form-control"-->
<!--                                   :placeholder="$t('global.search')"-->
<!--                                   style="width: 250px;">-->
                        </div>
                    </div>

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ $t('label.image') }}</th>
                                <th>{{ $t('label.title') }}</th>
                                <th>{{ $t('global.action') }}</th>
                            </tr>
                        </thead>
                        <tbody v-if="loading">
                            <tr>
                                <td colspan="6" class="text-center">
                                    <div class="spinner-border" role="status">
                                        <span class="visually-hidden">{{ $t('global.Loading') }}...</span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        <tbody v-else-if="data.length === 0">
                            <tr>
                                <td colspan="6" class="text-center">{{ $t('global.noData') }}</td>
                            </tr>
                        </tbody>
                        <tbody v-else>
                            <tr v-for="(item, index) in data" :key="item.id">
                                <td>{{ (dataPaginate.current_page - 1) * dataPaginate.per_page + index + 1 }}</td>
                                <td>
                                    <img :src="item.image_1"
                                         alt="About Us"
                                         style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;"
                                         v-if="item.image_1">
                                    <span v-else class="text-muted">-</span>
                                </td>
                                <td>{{ item.title || '-' }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button v-if="permission.includes('about us edit')"
                                                @click="showEditMode(item)"
                                                class="btn btn-sm btn-info"
                                                data-bs-toggle="modal" data-bs-target="#aboutUsModal"
                                                :title="$t('global.edit')">
                                            <i class="ri-pencil-line"></i>
                                        </button>

                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <nav v-if="dataPaginate.last_page > 1" aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            <li class="page-item" :class="{ disabled: dataPaginate.current_page === 1 }">
                                <a class="page-link" href="javascript:void(0)" @click="getData(dataPaginate.current_page - 1)">
                                    {{ $t('global.previous') }}
                                </a>
                            </li>
                            <li class="page-item"
                                v-for="page in dataPaginate.last_page"
                                :key="page"
                                :class="{ active: dataPaginate.current_page === page }">
                                <a class="page-link" href="javascript:void(0)" @click="getData(page)">
                                    {{ page }}
                                </a>
                            </li>
                            <li class="page-item" :class="{ disabled: dataPaginate.current_page === dataPaginate.last_page }">
                                <a class="page-link" href="javascript:void(0)" @click="getData(dataPaginate.current_page + 1)">
                                    {{ $t('global.next') }}
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <!-- End:: data table -->

        <!-- Modal for Create/Update -->
        <ModalCreateAndUpdate
            v-model="modalShow"
            :type="type"
            :dataRow="dataRow"
            @created="getData(pagePaginate)"/>
    </div>
</template>

<script>
import { onBeforeMount, inject, ref } from "vue";
import { useI18n } from "vue-i18n";
import crud from "../../../composable/crud_structure";
import ModalCreateAndUpdate from "./ModalCreateAndUpdate.vue";

export default {
    name: "AboutUsIndex",
    components: {
        ModalCreateAndUpdate
    },
    setup() {
        const emitter = inject('emitter');
        const { t } = useI18n({});

        const {
            getData, loading, data, dataPaginate, permission, uri,
            showModelCreate, showEditMode, deleteData, search,
            type, dataRow, modalShow, pagePaginate
        } = crud();

        search.value = {
            searchKey: '',
            searchInTranslations: true,
            columns: ['id'],
            searchInRelations: []
        };

        onBeforeMount(() => {
            uri.value = 'about-us';
            getData();
        });

        const showDetails = (item) => {
            // You can implement a details modal here if needed
            Swal.fire({
                title: item.title || t('global.aboutUs'),
                html: `
                    <div class="text-start">
                        <p><strong>${t('label.description')}:</strong></p>
                        <div>${item.description || '-'}</div>
                    </div>
                `,
                confirmButtonText: t('global.close')
            });
        };

        return {
            getData, loading, search, permission, deleteData,
            showEditMode, showModelCreate, data, dataPaginate,
            type, dataRow, modalShow, pagePaginate, showDetails
        };
    }
}
</script>

<style scoped>
.table th {
    background-color: #f8f9fa;
    font-weight: 600;
}
</style>
