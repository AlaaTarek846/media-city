<template>
    <div class="modal fade" id="show" tabindex="-1" aria-labelledby="adminModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xll modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="adminModalLabel">
                        {{ $t('global.show') }}
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xxl-4 col-xl-12">
                            <div class="card custom-card overflow-hidden border border-primary">
                                <div class="card-body p-0">
                                    <div class="d-sm-flex align-items-top p-4 border-bottom-0 main-profile-cover">
                                        <div>
                                            <img
                                                v-if="user?.avatar"
                                                :src="user.avatar"
                                                class="rounded-circle me-3"
                                                alt="User Avatar"
                                                style="width: 80px; height: 80px; object-fit: cover;"
                                            >
                                            <span
                                                v-else
                                                class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center me-3"
                                                style="width: 80px; height: 80px; font-size: 2rem;"
                                            >
                                                {{ user?.name ? user.name.charAt(0).toUpperCase() : '' }}
                                            </span>
                                        </div>
                                        <div class="flex-fill main-profile-info">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <h6 class="fw-semibold mb-1 text-fixed-white">{{user.name}}</h6>
                                            </div>
                                            <h4 class="fs-12 text-fixed-white mb-4 op-5">

                                                <span class="badge fs-12 rounded-pill bg-success"
                                                      v-if="user.status == 1">{{ $t('global.activated') }}</span>
                                                <span class="badge fs-12 rounded-pill bg-danger" v-else>{{
                                                        $t('global.Inactive') }}</span>
                                            </h4>

                                        </div>
                                    </div>

                                    <div class="p-4 border-bottom border-block-end-dashed">
                                        <p class="fs-15 mb-2 me-4 fw-semibold">{{ $t('global.ContactInformation') }} :</p>
                                        <div class="text-muted">
                                            <p class="mb-0">
                                                <span class="avatar avatar-sm avatar-rounded me-2 bg-light text-muted">
                                                    <i class="bi bi-phone"></i>
                                                </span>
                                                <span dir="ltr">{{user?.phone}}</span>
                                            </p>
                                            <p class="mb-0">
                                                <span class="avatar avatar-sm avatar-rounded me-2 bg-light text-muted">
                                                    <i class="ri-mail-line"></i>
                                                </span>
                                                {{ user?.email }}
                                            </p>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-8 col-xl-12">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="card custom-card">
                                        <div class="card-body p-0">
                                            <div class="p-3 border-bottom border-block-end-dashed d-flex align-items-center justify-content-between">
                                                <div>
                                                    <ul class="nav nav-tabs mb-0 tab-style-6 justify-content-start" id="myTab" role="tablist">
                                                        <li class="nav-item" role="presentation">
                                                            <button class="nav-link active" id="gallery-tab" data-bs-toggle="tab"
                                                                    data-bs-target="#gallery-tab-pane" type="button" role="tab"
                                                                    aria-controls="gallery-tab-pane" aria-selected="false">
                                                                <i class="ri-shopping-bag-3-line me-1 align-middle d-inline-block"></i>
                                                                {{$t('global.orders')}}
                                                            </button>
                                                        </li>
                                                        <li class="nav-item" role="presentation">
                                                            <button class="nav-link" id="gallery-tab-favorites" data-bs-toggle="tab"
                                                                    data-bs-target="#gallery-tab-favorites-pane" type="button" role="tab"
                                                                    aria-controls="gallery-tab-favorites-pane" aria-selected="false">
                                                                <i class="ri-heart-line me-1 align-middle d-inline-block"></i>
                                                                {{$t('global.product_favorites')}}
                                                            </button>
                                                        </li>
                                                        <li class="nav-item" role="presentation">
                                                            <button class="nav-link" id="gallery-tab-reviews" data-bs-toggle="tab"
                                                                    data-bs-target="#gallery-tab-reviews-pane" type="button" role="tab"
                                                                    aria-controls="gallery-tab-reviews-pane" aria-selected="false">
                                                                <i class="ri-star-line me-1 align-middle d-inline-block"></i>
                                                                {{$t('global.reviews')}}
                                                            </button>
                                                        </li>
                                                        <li class="nav-item" role="presentation">
                                                            <button class="nav-link" id="gallery-tab-addresses" data-bs-toggle="tab"
                                                                    data-bs-target="#gallery-tab-addresses-pane" type="button" role="tab"
                                                                    aria-controls="gallery-tab-addresses-pane" aria-selected="false">
                                                                <i class="ri-star-line me-1 align-middle d-inline-block"></i>
                                                                {{$t('global.addresses')}}
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="p-3" style="background-color: #f1f1f1;">
                                                <div class="tab-content" id="myTabContent">
                                                    <div class="tab-pane show active fade p-0 border-0" id="gallery-tab-pane"
                                                         role="tabpanel" aria-labelledby="gallery-tab" tabindex="0">

                                                        <div class="row">
                                                            <div class="col-xl-12">
                                                                <div class="table-responsive">
                                                                    <table class="table nowrap text-nowrap border mt-4">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>{{$t('global.OrderNumber')}}</th>
                                                                                <th>{{$t('global.order_status')}}</th>
                                                                                <th>{{$t('global.applied_coupon')}}</th>
                                                                                <th>{{$t('global.Discounts')}}</th>
                                                                                <th>{{$t('global.sub_total')}}</th>
                                                                                <th>{{$t('global.tax')}}</th>
                                                                                <th>{{$t('global.Shipping')}}</th>
                                                                                <th>{{$t('global.total')}}</th>
                                                                                <th>{{$t('global.created_at')}}</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr v-for="order in user?.orders" :key="order.id">
                                                                                <td>
                                                                                    <span
                                                                                        @click="order.showItems = !order.showItems"
                                                                                        style="cursor: pointer; color: #007bff; text-decoration: underline;"
                                                                                    >
                                                                                        {{ order.order_number }}
                                                                                    </span>
                                                                                    <div v-if="order.items && order.items.length && order.showItems" class="mt-2">
                                                                                        <strong>Items:</strong>
                                                                                        <ul class="mb-0 ps-3">
                                                                                            <li v-for="item in order.items" :key="item.id">
                                                                                                {{ item.product }} <span> {{ item.quantity }} </span>
                                                                                                <span v-if="item.price">x {{ item.price }} </span>
                                                                                            </li>
                                                                                        </ul>
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    {{ order.order_status }}
                                                                                </td>
                                                                                <td>
                                                                                    {{ order.applied_coupon  ? order.applied_coupon + ' ( ' + order.coupon_discount + ' )' : '---' }}
                                                                                </td>
                                                                                <td>
                                                                                    {{ order.discount ? order.discount : '---' }}
                                                                                </td>
                                                                                <td>
                                                                                    {{ order.sub_total ? order.sub_total : '---' }}
                                                                                </td>
                                                                                <td>
                                                                                    {{ order.tax ? order.tax + ' ( ' + order.tax_percentage +'%'+ ' )' : '---' }}
                                                                                </td>
                                                                                <td>
                                                                                    {{ order.shipping_price ? order.shipping_price : '---' }}
                                                                                </td>
                                                                                <td>
                                                                                    {{ order.total ? order.total : '---' }}
                                                                                </td>
                                                                                <td>
                                                                                    {{ order.created_at }}

                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade p-0 border-0" id="gallery-tab-favorites-pane"
                                                         role="tabpanel" aria-labelledby="gallery-tab-favorites" tabindex="0">

                                                        <div class="row">
                                                            <div class="col-xl-12">
                                                                <div class="table-responsive">
                                                                    <table class="table nowrap text-nowrap border mt-4">
                                                                        <thead>
                                                                            <tr>
                                                                                <th scope="col">{{ $t('label.image') }}</th>
                                                                                <th scope="col">{{ $t('label.title') }}</th>
                                                                                <th scope="col">{{ $t('global.brand') }}</th>
                                                                                <th scope="col">{{ $t('global.category') }}</th>
                                                                                <th scope="col">{{ $t('global.type') }}</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr v-for="item in user?.favorites" :key="item.id">
                                                                                <td>
                                                                                    <div class="d-flex align-items-center">
                                                                                        <div class="me-3">
                                                                                            <span class="avatar avatar-lg bg-light">
                                                                                                <img :src="item.image" alt="" style="width: 100%; height: 100%">
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                                <td>{{item.title}}</td>
                                                                                <td>{{item.brand}}</td>
                                                                                <td>{{item.category}}</td>
                                                                                <td>{{ $t('global.' + item.type) }}</td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade p-0 border-0" id="gallery-tab-reviews-pane"
                                                         role="tabpanel" aria-labelledby="gallery-tab-reviews" tabindex="0">

                                                        <div class="row">
                                                            <div class="col-xl-12">
                                                                <div class="table-responsive">
                                                                    <table class="table nowrap text-nowrap border mt-4">
                                                                        <thead>
                                                                            <tr>
                                                                                <th scope="col">{{ $t('global.product') }}</th>
                                                                                <th scope="col">{{ $t('global.rating') }}</th>
                                                                                <th scope="col">{{ $t('global.comment') }}</th>
                                                                                <th scope="col">{{ $t('global.likes_count') }}</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr v-for="item in user?.reviews" :key="item.id">
                                                                            
                                                                                <td>{{item.product}}</td>
                                                                                <td>{{item.rating}}</td>
                                                                                <td>
                                                                                    <span style="white-space: pre-line; word-break: break-word;">
                                                                                        {{ item.review }}
                                                                                    </span>
                                                                                </td>
                                                                                <td>{{item.likes_count}}</td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade p-0 border-0" id="gallery-tab-addresses-pane"
                                                         role="tabpanel" aria-labelledby="gallery-tab-addresses" tabindex="0">

                                                        <div class="row">
                                                            <div class="col-xl-12">
                                                                <div class="table-responsive">
                                                                    <table class="table nowrap text-nowrap border mt-4">
                                                                        <thead>
                                                                            <tr>
                                                                                <th scope="col">{{ $t('global.nameAddress') }}</th>
                                                                                <th scope="col">{{ $t('global.address') }}</th>
                                                                                <th scope="col">{{ $t('global.building_number') }}</th>
                                                                                <th scope="col">{{ $t('global.floor_number') }}</th>
                                                                                <th scope="col">{{ $t('global.apartment_number') }}</th>
                                                                                <th scope="col">{{ $t('global.distinctive_mark') }}</th>
                                                                                <th scope="col">{{ $t('global.country') }}</th>
                                                                                <th scope="col">{{ $t('global.area') }}</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr v-for="item in user?.addresses" :key="item.id">
                                                                            
                                                                                <td>
                                                                                    {{ item.title }}
                                                                                    <span v-if="parseInt(item.is_primary)" class="badge bg-primary ms-2">
                                                                                        {{$t('global.is_primary')}}
                                                                                    </span>
                                                                                </td>
                                                                                <td>
                                                                                    <span style="white-space: pre-line; word-break: break-word;">
                                                                                        {{ item.address }}
                                                                                    </span>
                                                                                </td>
                                                                                <td>{{item.building_number}}</td>
                                                                                <td>{{item.floor_number}}</td>
                                                                                <td>{{item.apartment_number}}</td>
                                                                                <td>{{item.distinctive_mark}}</td>
                                                                                <td>{{item.country}}</td>
                                                                                <td>{{item.area}}</td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { $t } from "@primevue/themes";
import { ref } from "vue";
import { useI18n } from "vue-i18n";
import adminApi from "../../../api/adminAxios";

export default {
    name: "Show",
    props: {
        dataRow: { default: '' },
        type: { default: 'order' },
    },
    data() {
        return {
            errors: {}
        }
    },
    setup(props) {
        setTimeout(async () => {
            let myModalEl = document.getElementById('show')
            myModalEl.addEventListener('show.bs.modal', function (event) {
                resetModal();
            })
            myModalEl.addEventListener('hidden.bs.modal', function (event) {

            })
        }, 150);
        let loading = ref(false);
        const { t } = useI18n({});
        const id = ref(null);
        const user = ref('');

        function defaultData() {
            user.value = '';
            id.value = null;
        }

        function resetModal() {
            defaultData();
            setTimeout(async () => {
                id.value = props.dataRow.id;
                adminApi.get(`dashboard/user/${props.dataRow.id}`)
                .then((res) => {
                    user.value = res.data.data;
                })
                .catch((err) => {
                    console.log(err);
                })
            }, 50);
        }

        const days = ref(['Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday']);

        return {t, id,days, loading,user};
    }
}
</script>

<style scoped>
.work {
    padding: 10px 10px;
    background: #d5d5d5;
    border-radius: 13px;
    margin: 0 1px;
}
</style>
