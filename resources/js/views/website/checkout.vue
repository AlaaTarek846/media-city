<template>
     <section class="checkout-section py-5">
        <div class="container px-3">
          <div class="row g-4 g-lg-5">
             <div class="col-12 col-lg-6">
                <div class="checkout-card">
                    <template v-if="addresses.length == 0">
                        <AddAddressForm :user="user" :setting="setting" @created="getAddresses()" />
                    </template>
                    <div class="mt-4 checkout-form p-4 border rounded-3" v-else>
                        <h5 class="mb-4">{{ t('global.Choose Address') }}</h5>
                        <div class="row g-4">
                            <template v-for="(address, idx) in addresses" :key="address.id">
                                <div class="col-12 col-lg-12">
                                    <div class="form-check">
                                        <input
                                            class="form-check-input"
                                            type="radio"
                                            :id="'address-' + address.id"
                                            name="address"
                                            :value="address.id"
                                            v-model="data.address_id"
                                        >
                                        <label class="form-check-label" :for="'address-' + address.id">
                                            ({{ address.title }}) - {{ address.address }}
                                        </label>
                                    </div>
                                </div>
                            </template>


                            <div class="d-grid">
                                <button type="submit" @click="showModel()" class="btn btn-dark py-2 rounded-3" data-bs-toggle="modal" data-bs-target="#AddNewAddressModal">{{ t('global.Add new Address') }}</button>
                            </div>
                        </div><!--end row-->
                    </div>
                    <div class="mt-4 card-payment-method rounded-3 px-4 py-3 border">
                      <div class="">
                        <div class="form-check" >
                          <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" checked>
                          <label class="form-check-label" for="flexRadioDefault1">
                            {{ $t('global.Cash on delivery') }}
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="d-grid mt-4">
                      <button type="submit" class="btn btn-dark py-2 rounded-3" @click.prevent="SubmitData" v-if="!loading" >{{ $t('global.Payment') }}</button>
                      <button class="btn btn-dark py-2 rounded-3 btn-loader" style="cursor: not-allowed" disabled v-else>
                            <span class="me-2">{{ $t('auth.Loading') }}</span>
                            <span class="loading"><i class="ri-loader-2-fill fs-16"></i></span>
                        </button>
                    </div>
                </div>
             </div>
             <div class="col-12 col-lg-6">
                <div class="order-summary">
                  <div class="cart-list d-flex flex-column gap-4">
                    <template v-for="(item, index) in cartItems" :key="index">
                        <div class="cart-list-item d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="cart-img">
                            <img :src="item.product_variant?.product?.image" class="rounded-3" width="80" :alt="item.product_variant?.product?.translation?.title">
                            </div>
                            <div class="cart-product-info">
                            <h5 class="product-name fs-6 mb-1">{{ item.product_variant?.product?.translation?.title }}</h5>
                            <p>{{ item.product_variant?.attribute_values }}</p>
                            </div>
                        </div>
                        <div class="cart-product-price">
                            <h6 class="mb-0" style="direction: ltr !important">{{ item.quantity }} X {{item.price}} {{setting?.translation?.title}}</h6>
                        </div>
                        </div>
                        <div class="my-0 border-1 border-top"></div>
                    </template>
                  </div>
                  <div class="card border-0 rounded-4 bg-light mt-4">
                    <div class="card-body">
                      <div class="checkout-promocode p-2">
                         <p class="mb-2 fw-semibold">% {{$t('global.Apply promo code')}}</p>
                         <div class="d-flex align-items-center gap-2">
                          <input type="text" class="form-control border-2" v-model="data.code" :placeholder="$t('global.Enter promo code')" aria-label="Recipient's username" aria-describedby="button-addon2" :class="{
                                    'is-invalid': errors[`code`],
                                    'is-valid': !errors[`code`]
                                }">
                          <button class="btn btn-dark px-3" type="button" @click.prevent="checkCoupon">{{ $t('global.Apply') }}</button>

                        <template v-if="errors[`code`]">
                            <error-message v-for="(errorMessage, index) in errors[`code`]" :key="index">
                                {{ errorMessage }}
                            </error-message>
                        </template>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="card border-0 rounded-4 bg-light mt-4">
                    <div class="card-body">
                      <div class="checkout-card p-2">
                         <h4 class="mb-0">{{$t('global.Order Summary')}}</h4>
                         <div class="my-4 border-1 border-top"></div>
                         <div class="d-flex align-items-center justify-content-between mb-3" v-if="discounts || discount_amount">
                           <p class="mb-0">{{$t('global.productsPrice')}}</p>
                           <p class="mb-0">{{handleNumber(product_price)}} {{ setting?.translation?.title }}</p>
                         </div>
                         <div class="d-flex align-items-center justify-content-between mb-3" v-if="discounts || discount_amount">
                          <p class="mb-0 text-success">{{$t('global.Discounts')}}</p>
                          <p class="mb-0 text-success">- {{ handleNumber(discounts) }} {{ setting?.translation?.title }}</p>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-3" v-if="discount_amount">
                          <p class="mb-0 text-success">{{$t('global.Coupon Discount')}} <span>({{ discount_data?.type == 'fixed' ? discount_data?.value+ ' ' +setting?.translation?.title : discount_data?.value + '%' }})</span></p>
                          <p class="mb-0 text-success">- {{ handleNumber(discount_amount) }} {{ setting?.translation?.title }}</p>
                        </div>
                         <div class="d-flex align-items-center justify-content-between mb-3">
                          <p class="mb-0">{{$t('label.subTotal')}}</p>
                          <p class="mb-0"> {{handleNumber(subTotal)}} {{ setting?.translation?.title }} </p>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-3" v-if="parseInt(setting.shipping_price) > 0">
                          <p class="mb-0 text-danger">{{$t('global.Shipping')}}</p>
                          <p class="mb-0 text-danger">+{{ handleNumber(setting.shipping_price) }} {{ setting?.translation?.title }}</p>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-3" v-if="parseInt(setting.tax_percentage) > 0">
                            <p class="mb-0 text-danger">{{$t('global.tax')}} <span>({{ handleNumber(setting.tax_percentage) + '%' }})</span></p>
                            <p class="mb-0 text-danger">+{{handleNumber(tax)}} {{ setting?.translation?.title }}</p>
                        </div>
                         
                        <div class="my-3 border-1 border-top"></div>
                        <div class="d-flex align-items-center justify-content-between mb-3">
                          <p class="mb-0 fs-5 fw-semibold">{{$t('global.total')}}</p>
                          <p class="mb-0 fs-5 fw-semibold">{{ handleNumber(total) }} {{ setting?.translation?.title }}</p>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
             </div>
          </div><!--end row-->
        </div>
        <ModelCreateAndUpdateAddress v-model="modalShow" :type="type" :dataRow="dataRow" @created="getAddresses()" />
     </section>
</template>

<script>
import { computed, reactive, ref, toRefs, onBeforeMount, nextTick } from "vue";
import { alphaNum,  email,  maxLength, minLength, required, numeric} from "@vuelidate/validators";
import useVuelidate from "@vuelidate/core";
import webApi from "../../api/webAxios";
import { useI18n } from "vue-i18n";
import AddAddressForm from "./AddAddressForm.vue";
import ModelCreateAndUpdateAddress from "./ModelCreateAndUpdateAddress.vue";


export default {
    name: "checkout",
    props: {
        cart: {default: ''},
        setting: {default: ''},
        user: {default: ''},
    },
    components:{
        AddAddressForm,
        ModelCreateAndUpdateAddress
    },
    setup(props, { emit }) {

        const errors = ref([]);
        let loading = ref(false);
        const { t } = useI18n({});
        let cartItems = ref([0]);
        let subTotal = ref([0]);
        let discounts = ref([0]);
        let product_price = ref([0]);
        let total = ref([0]);
        let discount_data = ref('');
        let discount_amount = ref(0);
        let tax = ref(0);
        let addresses = ref([]);
        let modalShow = ref(false);
        let type = ref('create');
        let dataRow = ref('');

         onBeforeMount(() => {
            handelData();
            getAddresses();
        });

        let handelData = () => {
            setTimeout(async () => {
                cartItems.value = props.cart;
                orderSummary();

            }, 50);
        }

        let getAddresses = async () => {
            try {
                const response = await webApi.get(`/web/user-addresses`);
                addresses.value = response.data.data;
                if (addresses.value.length > 0) {
                    const primaryAddress = addresses.value.find(addr => parseInt(addr.is_primary) == 1) || addresses.value[0];
                    submitdata.data.address_id = primaryAddress.id; // Set the primary address as default, fallback to first
                }
            } catch (error) {
                console.error("Error fetching addresses:", error);
            }
        };

        let orderSummary  = () => {
            product_price.value = cartItems.value.reduce((acc, item) => acc + (item.product_variant.price_before_discount * item.quantity), 0);
            subTotal.value = cartItems.value.reduce((acc, item) => acc + (item.price * item.quantity), 0);
            discounts.value = product_price.value - subTotal.value; // Example fixed discount
            tax.value = (subTotal.value * props.setting.tax_percentage) / 100;
            total.value = Number(subTotal.value) + Number(props.setting.shipping_price) + Number(tax.value); // Ensure numeric addition

        }

        let submitdata = reactive({
            data: {
                code: '',
                address_id: '',
            },
        });

        const rules = computed(() => {
            return {
                data: {
                    code: {
                    },
                    address_id: {
                        required
                    }
                }
            }
        });

        const v$ = useVuelidate(rules, submitdata);

        function handleNumber(approxNumber) {
            return parseFloat(approxNumber).toFixed(2).endsWith(".00")
                ? parseInt(approxNumber)
                : parseFloat(approxNumber).toFixed(2);
        }

         function deleteData(id,index){
                Swal.fire({
                    title: `${t('global.AreYouSureDelete')}`,
                    text: `${t("global.YouWontBeAbleToRevertThis")}`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: t('global.yes'),
                    cancelButtonText: t('global.no'),
                }).then((result) => {
                    if (result.isConfirmed) {
                        webApi.delete(`/web/remove-item-from-shopping-cart/${id}`)
                            .then((res) => {
                                cartItems.value.splice(index,1);
                                Swal.fire({
                                    icon: 'success',
                                    title: `${t('global.DeletedSuccessfully')}`,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                orderSummary();
                            })
                            .catch((err) => {
                                Swal.fire({
                                    icon: 'error',
                                    title: `${t('global.ThereIsAnErrorInTheSystem')}`,
                                    text: `${t('global.YouCanNotDelete')}`,
                                });
                            });
                    }
                });
            }

            function changeStatus() {
                submitdata.data.status = submitdata.data.status ? '' : 1;
            }

            function checkCoupon() {
                errors.value = {};
                if (!submitdata.data.code) {
                    Swal.fire({
                        icon: 'warning',
                        title: `${t('validation.fieldRequired')}`,
                    });
                    return;
                }

                webApi.post(`/web/check-coupon`, { code: submitdata.data.code })
                    .then((res) => {
                        Swal.fire({
                            icon: 'success',
                            title: res.data.message,
                        });
                        // Update the total price with the discount
                        discount_data.value = res.data.data.coupon;
                        discount_amount.value = res.data.data.discount_amount;
                        total.value = res.data.data.new_total;
                        subTotal.value = subTotal.value - discount_amount.value;
                    })
                    .catch((err) => {
                        Swal.fire({
                            icon: 'error',
                            title: err.response.data.message,
                        });
                        errors.value = err.response.data.errors
                    });
            }
            let showModel = () => {
                modalShow.value=true;
           }

        return { v$, ...toRefs(submitdata),checkCoupon,discount_data, loading, errors, t, cartItems ,handleNumber ,subTotal ,discounts ,total,product_price , orderSummary,deleteData,changeStatus,discount_amount,addresses,getAddresses,modalShow,type,dataRow,showModel,tax}
    },
    methods: {

        SubmitData() {
            this.errors = {};

            let formData = new FormData();
                formData.append(`address_id`, this.data.address_id);
                formData.append(`discount_coupon_id`, this.discount_data.id ? this.discount_data.id : '');
                formData.append(`discount`, this.discounts ? this.discounts : 0);
                formData.append(`coupon_discount`, this.discount_amount ? this.discount_amount : 0);
                formData.append(`tax_percentage`, this.setting.tax_percentage ? this.setting.tax_percentage : 0);
                formData.append(`tax`, this.tax ? this.tax : 0);
                formData.append(`sub_total`, this.subTotal ? this.subTotal : 0);
                formData.append(`shipping_price`, this.setting.shipping_price ? this.setting.shipping_price : 0);
                formData.append(`total`, this.total ? this.total : 0);
                formData.append(`order_status_id`, 1);

                this.loading = true;
                webApi.post(`/web/make-order`, formData)
                    .then((res) => {

                        Swal.fire({
                            icon: 'success',
                            title: res.data.message,
                            showConfirmButton: false,
                            timer: 3000
                        });

                        this.errors =  [];

                        setTimeout(() => window.location='/checkout-thankyou?order_number=' + res.data.data.order_number, 3000);

                    })
                    .catch((err) => {
                        this.loading = false;
                        if (err) {
                            if (err.response) {
                                if (err.response.data) {
                                    this.errors = err.response.data.errors;
                                }
                            }
                        }
                    })
                    .finally(() => {
                        this.loading = false;
                    });
        }
    }
}
</script>

<style scoped>
.register-background {
    background-color: #F9F9F9;
}

.register-border-radius {
    border-radius: 16px;
}

.text-primary {
    color: #fbc02d !important;
}

.btn-primary {
    background-color: #fbc02d !important;
    border-color: #fbc02d !important;
}

.coustom-select {
    height: 100px;
}

.card {
    position: relative;
}

.package-feature ul li:first-child {
    margin-top: 10px;
}

.package-feature ul li::before {
    content: "\f00c";
    font-family: "Font Awesome 5 Free";
    font-weight: 600;
    color: #4B9F18;
    left: 0;
    position: absolute;
    top: 0;
}

.package-feature ul li:last-child {
    margin-bottom: 10px;
}

.ml-3 {
    margin-left: 1.5rem;
}

.waves-effect {
    position: relative;
    overflow: hidden;
    cursor: pointer;
    user-select: none;
    -webkit-tap-highlight-color: transparent;
    width: 200px;
    height: 50px;
    text-align: center;
    line-height: 34px;
    margin: auto;
}

input[type="file"] {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 100%;
    padding: 0;
    margin: 0;
    cursor: pointer;
    filter: alpha(opacity=0);
    opacity: 0;
}

.num-of-files {
    text-align: center;
    margin: 20px 0 30px;
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

.vue-tel-input {
    border-color: #e9edf6;
}

.authentication-cover:before {
    background-color: #fbc02d;
}

.text-primary {
    color: #fbc02d !important;
}

.btn-primary {
    background-color: #fbc02d !important;
    border-color: #fbc02d !important;
}

/*.tab-style-3 .nav-item .nav-link.services:after {*/
/*    content: "3";*/
/*}*/

.nav {
    margin-bottom: 60px;
}

.nav-item {
    padding: 0 30px;
}

.tab-style-3 .nav-item .nav-link {
    font-size: large;
}

.tab-pane {
    padding: .5rem 3.5rem 2rem;
    background: #d3bdbd14;
    border: none;
    border-bottom-width: 1px !important;
    border-bottom-color: #f1f1f1;
    border-bottom-style: solid;
    border-top-width: 1px !important;
    border-top-color: #f1f1f1;
    border-top-style: solid;
    height: 785px;
    max-height: 785px;
    border-radius: unset;
    overflow-y: scroll;
}

.p-select {
    border: 1px solid #e9edf6;
}

.tab-style-3 .nav-item .nav-link.images:after {
    content: "4";
}

.tab-style-3 .nav-item .nav-link.terms:after {
    content: "5";
}

.nav-tabs .nav-link.disabled,
.nav-tabs .nav-link:disabled {
    color: rgb(35, 35, 35);
}

.nav-tabs .nav-link.disabled,
.nav-tabs .nav-link:disabled {
    opacity: 1;
}

.active-data {
    color: #fbc02d !important;
    opacity: 1;
}

.bottom-footer {
    width: 57%;
    position: fixed;
    bottom: 0;
    transform: translate(5%, 0);
    background: #fff;
    z-index: 1200;
}

.waves-effect[data-v-d8970579] {
    background-color: #e9e9e9;
}

@media only screen and (max-width: 1560px) {
    .dd-step {
        margin-top: 3rem;
    }
}
</style>
