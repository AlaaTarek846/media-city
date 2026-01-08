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
                                            <!-- Print Header (Hidden on screen, visible on print) -->
                                            <div class="print-only-header text-center mb-4" style="display: none;">
                                                <img src="/website/images/logo.png" alt="Logo" style="max-height: 80px;">
                                                <h3 class="mt-2">{{ setting?.translation?.title || 'Media City' }}</h3>
                                                <div class="d-flex justify-content-between mt-4 border-bottom pb-2">
                                                     <div><strong>{{$t('global.OrderNumber')}}:</strong> #{{order?.order_number}}</div>
                                                     <div><strong>{{$t('global.OrderDate')}}:</strong> {{ order?.created_at }}</div>
                                                </div>
                                            </div>

                                            <div class="row g-0 print-grid">
                                                <div class="col-xl-3 border-end border-inline-end-dashed d-flex justify-content-center align-items-center print-col">
                                                    <div class="d-flex flex-wrap align-items-center justify-content-center">
                                                        <!-- Client Image Removed as requested -->
                                                        <!-- <div class="me-3 lh-1" style="flex-shrink: 0;">
                                                            <span class="avatar avatar-xxl avatar-rounded bg-primary shadow-sm" style="width: 100px; height: 100px;">
                                                                <span class="avatar-initials fs-1 fw-bold text-white" style="border-radius: 50%; background: #007bff; width: 100px; height: 100px; display: flex; align-items: center; justify-content: center;">
                                                                    {{ order?.user_name ? order?.user_name.charAt(0).toUpperCase() : '' }}
                                                                </span>
                                                            </span>
                                                        </div> -->
                                                        <div class="flex-fill text-center" style="max-width: calc(100% );">
                                                            <h4 class="user-name fs-16">{{ order?.user_name }}</h4>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-5 border-end border-inline-end-dashed print-col">
                                                    <!-- ... (User Contact Info) ... -->
                                                    <div class="d-flex flex-wrap align-items-top px-2" >
                                                        <div class="flex-fill row gutters col-md-12 align-item-center mt-4">
                                                            <div class="col-md-6 mb-6 border-end border-inline-end">
                                                                <div class="col-md-12 mb-4 ">
                                                                    <label class="form-label fs-13 text-info"><i class="bx bx-phone"></i> &nbsp;{{ $t("label.phone") }}</label>
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
                                                                    <label class="form-label fs-13 text-info"><i class="bx bx-id-card"></i> &nbsp;{{ $t("global.governorate") }}</label>
                                                                    <div class="fs-15 form-label"> {{order?.address?.area}}</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-4 border-end border-inline-end-dashed print-col" v-if="order">
                                                     <!-- ... (Recipient Info) ... -->
                                                    <div class="d-flex flex-wrap align-items-top px-2 pt-2">
                                                        <div class="prism-toggle w-100">
                                                            <div class="row">
                                                                <div class="col-md-3 mb-4">
                                                                    <label class="form-label fs-13 text-info">
                                                                        <i class="bx bx-user"></i> &nbsp;{{ $t("global.recipient_name") }}
                                                                    </label>
                                                                    <div class="fs-15 form-label">{{ order?.address?.name || '---' }}</div>
                                                                </div>
                                                                <div class="col-md-3 mb-4">
                                                                    <label class="form-label fs-13 text-info">
                                                                        <i class="bx bx-label"></i> &nbsp;{{ $t("global.address_type") }}
                                                                    </label>
                                                                    <div class="fs-15 form-label">{{ order?.address?.title || '---' }}</div>
                                                                </div>
                                                                <!-- Map Removed as requested -->
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
                                        <table class="table text-nowrap table-bordered-print">
                                            <thead>
                                            <tr>
                                                <th scope="col">{{$t('global.product')}}</th>
                                                <!-- SKU Column Removed as it's now in Product details -->
                                                <!-- <th scope="col">{{$t('global.sku')}}</th> -->
                                                <th scope="col">{{$t('global.department')}}</th>
                                                <th scope="col">{{$t('global.condition')}}</th>
                                                <th scope="col">{{$t('global.count_day')}}</th>
                                                <th scope="col">{{$t('global.rental_start_date')}}</th>
                                                <!-- Note Column Removed as requested -->
                                                <!-- <th scope="col">{{$t('global.note')}}</th> -->
                                                <th scope="col">{{$t('global.Unit Price')}}</th>
                                                <th scope="col">{{$t('global.quantity')}}</th>
                                                <th scope="col">{{$t('global.TotalPrice')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="(item,index) in order.items" :key="item.id">
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <!-- Product Image Removed as requested -->
                                                        <!-- <div class="me-3">
                                                            <span class="avatar avatar-xxl bg-light">
                                                                <img :src="item.product_image" alt="" style="width: 100%; height: 100%">
                                                            </span>
                                                        </div> -->
                                                        <div>
                                                            <div class="mb-1 fs-14 fw-semibold">
                                                                <a href="javascript:void(0);">{{item.product}}</a>
                                                            </div>
                                                            <div class="mb-1" v-if="item.variant && item.variant !== '---'">
                                                                <span class="me-1">{{$t('global.ProductAttributes')}} : </span>
                                                                <span class="text-muted">{{item.variant}}
                                                                    <span v-if="handleNumber(item.discount)" class="badge bg-info ms-3">{{handleNumber(item.discount)}} Off
                                                                    </span>
                                                                </span>
                                                            </div>
                                                            <!-- Brand & Category Removed, replaced with SKU -->
                                                            <div class="mb-1">
                                                                <span class="me-1">{{$t('global.sku')}} : </span><span class="text-muted text-secondary">{{item.sku}}</span>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </td>
                                                <!-- SKU Column Data Removed -->
                                                <!-- <td><a href="javascript:void(0);" class="text-secondary">{{item.sku}}</a></td> -->
                                                <td>{{item.department || '---'}}</td>
                                                <td>{{getConditionLabel(item.condition)}}</td>
                                                <td>{{item.count_day || '---'}}</td>
                                                <td>{{item.start_date || '---'}}</td>
                                                <!-- Note Data Removed -->
                                                <!-- <td>{{item.note || '---'}}</td> -->
                                                <td>
                                                    <span class="fs-15 fw-semibold">{{handleNumber(item.price)}}</span>
                                                </td>
                                                <td>{{item.quantity}}</td>
                                                <td>{{handleNumber(item.total)}}</td>
                                            </tr>


                                            <tr v-if="order.coupon_discount">
                                                <td colspan="5"></td>
                                                <td colspan="2">
                                                    <div class="fw-semibold">{{$t('global.coupon_discount')}} :</div>
                                                </td>
                                                <td>
                                                    <span class="badge bg-success-transparent">{{order?.coupon_discount}}</span>
                                                </td>
                                            </tr>
                                            <!-- <tr v-if="order.discount">
                                                <td colspan="5"></td>
                                                <td colspan="2">
                                                    <div class="fw-semibold">{{$t('global.Discounts')}} :</div>
                                                </td>
                                                <td>
                                                    {{order.discount}}
                                                </td>
                                            </tr> -->
                                            <tr>
                                                <td colspan="5"></td>
                                                <td colspan="2">
                                                    <div class="fw-semibold">{{$t('label.subTotal')}} :</div>
                                                </td>
                                                <td>
                                                    {{order.sub_total}}
                                                </td>
                                            </tr>
                                            <tr v-if="order.tax">
                                                <td colspan="5"></td>
                                                <td colspan="2">
                                                    <div class="fw-semibold">{{$t('global.tax')}} {{ ' ( ' + order?.tax_percentage +'%'+ ' )' }} :</div>
                                                </td>
                                                <td>
                                                    <span class="text-danger">+{{order?.tax}}</span>
                                                </td>
                                            </tr>
                                            <tr v-if="order.shipping_price">
                                                <td colspan="5"></td>
                                                <td colspan="2">
                                                    <div class="fw-semibold">{{$t('global.Shipping')}} :</div>
                                                </td>
                                                <td>
                                                    <span class="text-danger">+{{order?.shipping_price}}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="5"></td>
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

        function getConditionLabel(condition) {
            if (!condition) return '---';
            const conditionMap = {
                'new': t('global.new'),
                'used': t('global.used'),
                'rent': t('global.rent')
            };
            return conditionMap[condition.toLowerCase()] || condition;
        }

        let printData = () => {
            // Remove the manual display manipulation here, rely on CSS @media print
            var printContents = document.getElementById('printData').innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            location.reload(); // Still needed to restore Vue event listeners/state effectively
        };


        return {t, id, loading,order,handleNumber,setting,product_price,printData,getConditionLabel};
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
        padding: 5mm;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
        font-family: Arial, sans-serif;
        font-size: 12px;
    }

    .container-fluid {
        width: 100%;
        margin: 0;
        padding: 0;
    }

    .card {
        border: none !important;
        box-shadow: none !important;
        background: transparent !important;
    }

    /* Header Visibility */
    .card-header,
    .data-print-headen {
        display: none !important;
    }

    .print-only-header {
        display: block !important;
        margin-bottom: 10px;
        text-align: center;
        border-bottom: 2px solid #000;
        padding-bottom: 10px;
    }

    .print-only {
        display: inline-block !important;
    }

    /* Grid Layout for Print */
    .print-grid {
        display: flex !important;
        flex-direction: row !important;
        width: 100%;
        border: 1px solid #000;
        margin-bottom: 15px;
        background: #fff;
    }

    .print-col {
        padding: 8px;
        border-right: 1px solid #000;
        box-sizing: border-box; /* Critical for widths */
    }

    .print-col:last-child {
        border-right: none;
    }

    /* Explicit Widths for 3-Column Layout */
    .print-col:nth-child(1) { width: 20%; } /* User Image/Name */
    .print-col:nth-child(2) { width: 45%; } /* Contact Info */
    .print-col:nth-child(3) { width: 35%; } /* Recipient/Map */


    /* Compact User Info */
    .avatar-xxl {
        width: 60px !important;
        height: 60px !important;
    }
    .avatar-xxl .avatar-initials {
        width: 60px !important;
        height: 60px !important;
        font-size: 24px !important;
    }
    h4.user-name {
        font-size: 14px !important;
        margin: 5px 0 0 0;
    }
    .form-label {
        font-size: 11px !important;
        margin-bottom: 2px !important;
        font-weight: normal;
        color: #333 !important;
    }
    .fs-15 { font-size: 12px !important; font-weight: bold; }
    .fs-13 { font-size: 10px !important; text-transform: uppercase; color: #666; }

    .mb-4 { margin-bottom: 8px !important; }
    .mb-2 { margin-bottom: 4px !important; }

    /* Table Styling */
    .table-responsive {
        overflow: visible !important;
    }

    .table-bordered-print {
        width: 100%;
        border-collapse: collapse;
        font-size: 10px; /* Smaller font for table to fit */
    }

    .table-bordered-print th,
    .table-bordered-print td {
        border: 1px solid #000 !important;
        padding: 4px 6px; /* Reduced padding */
        vertical-align: middle;
    }

    .table-bordered-print th {
        background-color: #eee !important;
        font-weight: bold;
        text-transform: uppercase;
        font-size: 11px;
    }
    
    /* Make image column smaller */
    .table-bordered-print td:first-child {
        width: 50px;
    }
    .table-bordered-print .avatar img {
        width: 30px !important;
        height: 30px !important;
    }
    .table-bordered-print .avatar {
        width: 30px !important;
        height: 30px !important;
    }
    .me-3 { margin-right: 5px !important; }

    /* Hide URLs/Links style */
    a { text-decoration: none; color: #000; }
    
    /* Page Breaks */
    tr { page-break-inside: avoid; }
    .card-footer { display: none; }
}

</style>
