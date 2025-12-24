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
                        <div class="col-xl-12">
                            <div class="card custom-card" id="printData">
                                <div class="card-header d-flex justify-content-between">
                                    <div class="card-title">
                                        {{$t('global.OrderNumber')}} - <span class="text-primary">#{{order?.order_number}}</span>
                                    </div>
                                    <div>
                                        <span class="badge bg-primary-transparent">
                                            {{$t('global.OrderDate')}} : {{ order?.created_at }}
                                        </span>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12  border-bottom border-light">
                                    <div class="card custom-card">
                                        <div class="card-body p-0">
                                            <div class="row g-0">
                                                <div class="col-xl-3 border-end border-inline-end-dashed d-flex justify-content-center align-items-center">
                                                    <div class="d-flex flex-wrap align-items-center justify-content-center">
                                                        <div class="me-3 lh-1" style="flex-shrink: 0;">
                                                            <span class="avatar avatar-xxl avatar-rounded bg-primary shadow-sm" style="width: 100px; height: 100px;">
                                                                <span class="avatar-initials fs-1 fw-bold text-white" style="border-radius: 50%; background: #007bff; width: 100px; height: 100px; display: flex; align-items: center; justify-content: center;">
                                                                    {{ order?.user_name ? order?.user_name.charAt(0).toUpperCase() : '' }}
                                                                </span>
                                                            </span>
                                                        </div>
                                                        <div class="flex-fill text-center" style="max-width: calc(100% );">
                                                            <h4 class="user-name fs-16">{{ order?.user_name }}</h4>
                                                            <!-- <h6 class="user-email">
                                                                <span class="fs-14 form-label text-info">{{ $t("label.phone") }}:</span> {{ order?.user_phone }}
                                                            </h6>
                                                            <h6 class="user-email">
                                                                <span class="fs-14 form-label text-info">{{ $t("label.email") }}:</span> {{ order?.user_email }}
                                                            </h6> -->
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-5 border-end border-inline-end-dashed">
                                                    <div class="d-flex flex-wrap align-items-top px-2" >
                                                        <div class="flex-fill row gutters col-md-12 align-item-center mt-4">
                                                            <div class="col-md-6 mb-6 border-end border-inline-end">
                                                                <div class="col-md-12 mb-4 ">
                                                                    <label class="form-label fs-13 text-info"><i class="bx bx-phone"></i> &nbsp;{{ $t("label.phone") }}</label>
                                                                    <span dir="ltr"></span>
                                                                    <div class="fs-15 form-label text-start"  dir="ltr">{{ order?.user_phone }}</div>
                                                                </div>
                                                                <div class="col-md-14 mb-4">
                                                                    <label class="form-label fs-13 text-info"><i class="bx bx-envelope"></i> &nbsp;{{ $t("label.email") }}</label>
                                                                    <div class="fs-15 form-label">{{ order?.user_email }}</div>
                                                                </div>

                                                            </div>
                                                            <div class="col-md-6 mb-2 ">
                                                                <div class="col-md-12 mb-4">
                                                                    <label class="form-label fs-13 text-info">
                                                                        <i class="bx bx-map"></i> &nbsp;{{ $t("global.address") }}
                                                                    </label>
                                                                    <div class="fs-15 form-label">{{ order?.address?.address }}</div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <label class="form-label fs-13 text-info"><i class="bx bx-id-card"></i> &nbsp;{{ $t("global.country&area") }}</label>
                                                                    <div class="fs-15 form-label">{{ order?.address?.country }} / {{order?.address?.area}}</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-4 border-end border-inline-end-dashed" v-if="order">
                                                    <div class="d-flex flex-wrap align-items-top px-2 pt-2">
                                                        <div class="prism-toggle w-100">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <label class="form-label fs-13 text-info">
                                                                        <i class="bx bx-map-pin"></i> &nbsp;{{ $t("global.distinctive_mark") }}
                                                                    </label>
                                                                    <div class="fs-15 form-label">{{ order?.address?.distinctive_mark }}</div>
                                                                </div>
                                                                <div class="col-md-4 border-end border-inline-end text-center">
                                                                    <label class="form-label fs-13 text-info">
                                                                        <i class='bx bx-buildings side-menu__icon text-info'></i>{{ $t('global.building_number') }}
                                                                    </label>
                                                                    <div class="role-description fs-14 form-label">{{order?.address?.building_number }}</div>
                                                                </div>
                                                                <div class="col-md-4 border-end border-inline-end text-center">
                                                                    <label class="form-label fs-13 text-info">
                                                                        <i class="bx bx-building-house text-info"></i> {{ $t('global.floor_number') }}
                                                                    </label>
                                                                    <div class="role-description fs-14 form-label">{{order?.address?.floor_number}}</div>
                                                                </div>
                                                                <div class="col-md-4 text-center">
                                                                    <label class="form-label fs-13 text-info">
                                                                        <i class="bx bx-home-alt side-menu__icon text-info"></i> {{ $t('global.apartment_number') }}
                                                                    </label>
                                                                    <div class="role-description fs-14 form-label">{{order?.address?.apartment_number}}</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                            </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table text-nowrap">
                                            <thead>
                                            <tr>
                                                <th scope="col">{{$t('global.product')}}</th>
                                                <th scope="col">{{$t('global.sku')}}</th>
                                                <th scope="col">{{$t('global.Unit Price')}}</th>
                                                <th scope="col">{{$t('global.quantity')}}</th>
                                                <th scope="col">{{$t('global.TotalPrice')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="(item,index) in order.items" :key="item.id">
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="me-3">
                                                            <span class="avatar avatar-xxl bg-light">
                                                                <img :src="item.product_image" alt="" style="width: 100%; height: 100%">
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <div class="mb-1 fs-14 fw-semibold">
                                                                <a href="javascript:void(0);">{{item.product}}</a>
                                                            </div>
                                                            <div class="mb-1">
                                                                <span class="me-1">{{$t('global.ProductAttributes')}} : </span>
                                                                <span class="text-muted">{{item.variant ? item.variant : '---'}}
                                                                    <span v-if="handleNumber(item.discount)" class="badge bg-info ms-3">{{handleNumber(item.discount)}} {{ setting?.translation?.title }} Off
                                                                    </span>
                                                                </span>
                                                            </div>
                                                            <div class="mb-1">
                                                                <span class="me-1">{{$t('global.category')}} : </span><span class="text-muted">{{item.category}}</span>
                                                            </div>
                                                            <div class="mb-1">
                                                                <span class="me-1">{{$t('global.brand')}} : </span><span class="text-muted">{{item.brand}}</span>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><a href="javascript:void(0);" class="text-secondary">{{item.sku}}</a></td>
                                                <td>
                                                    <span class="fs-15 fw-semibold">{{handleNumber(item.price)}} {{ setting?.translation?.title }}</span>
                                                </td>
                                                <td>{{item.quantity}}</td>
                                                <td>{{handleNumber(item.total)}} {{ setting?.translation?.title }}</td>
                                            </tr>
                                            
                                            
                                            <tr v-if="order.coupon_discount">
                                                <td colspan="2"></td>
                                                <td colspan="2">
                                                    <div class="fw-semibold">{{$t('global.coupon_discount')}} :</div>
                                                </td>
                                                <td>
                                                    <span class="badge bg-success-transparent">{{order?.coupon_discount}} {{ setting?.translation?.title }}</span>
                                                </td>
                                            </tr>
                                            <!-- <tr v-if="order.discount">
                                                <td colspan="2"></td>
                                                <td colspan="2">
                                                    <div class="fw-semibold">{{$t('global.Discounts')}} :</div>
                                                </td>
                                                <td>
                                                    {{order.discount}} {{ setting?.translation?.title }}
                                                </td>
                                            </tr> -->
                                            <tr>
                                                <td colspan="2"></td>
                                                <td colspan="2">
                                                    <div class="fw-semibold">{{$t('label.subTotal')}} :</div>
                                                </td>
                                                <td>
                                                    {{order.sub_total}} {{ setting?.translation?.title }}
                                                </td>
                                            </tr>
                                            <tr v-if="order.tax">
                                                <td colspan="2"></td>
                                                <td colspan="2">
                                                    <div class="fw-semibold">{{$t('global.tax')}} {{ ' ( ' + order?.tax_percentage +'%'+ ' )' }} :</div>
                                                </td>
                                                <td>
                                                    <span class="text-danger">+{{order?.tax}} {{ setting?.translation?.title }}</span>
                                                </td>
                                            </tr>
                                            <tr v-if="order.shipping_price">
                                                <td colspan="2"></td>
                                                <td colspan="2">
                                                    <div class="fw-semibold">{{$t('global.Shipping')}} :</div>
                                                </td>
                                                <td>
                                                    <span class="text-danger">+{{order?.shipping_price}} {{ setting?.translation?.title }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"></td>
                                                <td colspan="2">
                                                    <div class="fw-semibold">{{$t('global.total')}} :</div>
                                                </td>
                                                <td>
                                                    <span class="fs-16 fw-semibold">{{order.total}} {{ setting?.translation?.title }}</span>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="card-footer border-top-0 data-print-headen">
                                    <div class="btn-list float-end">
                                        <button class="btn btn-success btn-wave btn-sm" @click="printData">
                                            <i class="ri-printer-line me-1 align-middle d-inline-block"></i>
                                            {{ $t('global.print') }}
                                        </button>
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
        const order = ref('');
        const setting = ref('');
        let product_price = ref(0);

        function defaultData() {
            order.value = '';
            id.value = null;
        }

        function resetModal() {
            defaultData();
            setTimeout(async () => {
                id.value = props.dataRow.id;
                adminApi.get(`dashboard/order/${props.dataRow.id}`)
                .then((res) => {
                    order.value = res.data.data.order;
                    setting.value = res.data.data.setting;
                    product_price.value = res.data.data.order.items.reduce((acc, item) => acc + (item.total), 0);
                })
                .catch((err) => {
                    console.log(err);
                })
            }, 50);
        }

         function handleNumber(approxNumber) {
            return parseFloat(approxNumber).toFixed(2).endsWith(".00")
                ? parseInt(approxNumber)
                : parseFloat(approxNumber).toFixed(2);
        }

        let printData = () => {
            const appBanners = document.querySelectorAll('.data-print-headen');
            appBanners.forEach((el) => {
                el.style.display = 'none';
            });
            var printContents = document.getElementById('printData').innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            location.reload();
        };


        return {t, id, loading,order,handleNumber,setting,product_price,printData};
    }
}
</script>

<style scoped>
textarea.form-control{
    height: auto !important;
}
.card {
    border: none;
}
.p-3 {
    padding: 1rem!important;
}


.container-images {
    width: 90%;
    position: relative;
    margin: auto;
    display: flex;
    justify-content: space-evenly;
    gap: 20px;
    flex-wrap: wrap;
    padding: 10px;
    border-radius: 20px;
    background-color: #f7f7f7;
}

img{
    height: 200px;
    width: 200px;
}

.calendar {
    margin-top: 50px;
    position: relative;
}

.calendar .shodow{
    position: absolute;
    top: 100px;
    left: 0;
    right: 34px;
    bottom: 30px;
    z-index: 100;
}

.modal-dialog {
    z-index: 100;
}

.custom-modal .shodow{
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #0000004a;
}

.fc-title:hover {
    cursor: pointer;
}

.cal-icon:after {
    display: none;
}

.toggle-switch-input:checked:disabled + .toggle-switch-label {
    background-color: #fcb00c;
}

.event-pointer{
    pointer-events: none;
}
@media print {
    body {
        margin: 0;
        padding: 0;
        -webkit-print-color-adjust: exact;
        color-adjust: exact;
    }

    .container-fluid {
        width: 100%;
        margin: 0;
        padding: 0;
    }

    .card {
        border: 1px solid #ddd;
        box-shadow: none;
    }

    .table-responsive {
        overflow: visible !important;
    }

    .btn-list,
    .data-print-headen,
    .print-button,
    .back-button {
        display: none !important; /* Hide buttons during print */
    }

    img {
        max-width: 100%;
        height: auto;
    }


    .border-end
   {
        border-right: none !important; /* Hide the right border during print */
    }

    .border-inline-end-dashed {
        border-right: 1px dashed #ddd !important;
    }

    .card-header,
    .card-footer {
        page-break-inside: avoid;
    }

    .card-title {
        font-size: 18px;
        font-weight: bold;
    }

    .form-label {
        font-size: 14px;
    }

    .card-body {
        padding: 10px;
    }

    .d-flex {
        display: flex;
    }

    .justify-content-between {
        justify-content: space-between;
    }

    .justify-content-center {
        justify-content: center;
    }

    .align-items-center {
        align-items: center;
    }

    .text-center {
        text-align: center;
    }


    /* Flexbox layout for print */
    .row.g-0 {
        display: flex;
        justify-content: space-between;
        align-items: stretch; /* Ensures all items stretch to the same height */
    }

    .col-xl-3 {
        flex: 2;
        text-align: right;
    }

    .col-xl-5 {
        flex: 2;
        padding-left: 5px; /* Adjust padding as needed */
        padding-right: 5px; /* Adjust padding as needed */
    }

    .col-xl-4 {
        flex: 4; /* Increase the flex value to make this section wider */
        padding-left: 5px;
        padding-right: 5px;
        text-align: right;
    }

    .col-xl-4 .flex-wrap.align-items-top.px-2 {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .col-md-12.mb-2.d-flex.justify-content-center {
        flex: 1;
        text-align: center;
    }

    .col-md-4 {
        flex: 1;
        text-align: center;
    }

    /* Ensure that the whole page is printed */
    @page {
        margin: 0;
        size: A4; /* Adjust for standard paper size */
    }
}

</style>
