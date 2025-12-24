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
                                    <th scope="col">{{ $t('global.created_at') }}</th>
                                </tr>
                                </thead>
                                <tbody v-if="data && data.length">
                                <tr v-for="(item,index) in data" :key="item.id">
                                    <td scope="row">{{index + 1}}</td>
                                    <td>{{item.name}}</td>
                                    <td>{{item.phone}}</td>
                                    <td>{{item.email}}</td>
                                    <td>{{item.subject}}</td>
                                    <td>{{item.message}}</td>
                                    <td>{{item.created_at}}</td>
                                </tr>
                                </tbody>
                                <tbody v-else>
                                    <tr>
                                        <th class="text-center" colspan="7">{{ $t('global.NoDataFound') }}</th>
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
import {onBeforeMount,inject,toRefs} from "vue";
import crud from "../../../composable/crud_structure";

export default {
    name: "index",
    setup(props){
        const emitter = inject('emitter');
        const {getData,loading,data,dataPaginate,permission,uri,showModelCreate,showEditMode,deleteData,search,type,dataRow,modalShow,filter,pagePaginate} = crud();

        search.value = {
            searchKey : '',
            searchInTranslations: true,
            columns: ['id','name','phone','email','subject','message'],
            searchInRelations: [
                // {
                //     relation: 'roles',
                //     columns: ['name'],
                //     searchInRelationTranslations:false
                // }
            ]
        }
        onBeforeMount(() => {
            uri.value = 'contact-message';
            getData();
        });


        return {getData,loading,search,permission,deleteData,showEditMode,showModelCreate,data,dataPaginate,type,dataRow,modalShow,pagePaginate};

    }
}
</script>

