<template>
    <!--start cart-->
    <section class="py-5">
      <div class="container px-3">
        <div class="row g-4 g-lg-5">
          <div class="col-12 col-xl-8">
            <div class="cart-list d-flex flex-column gap-4">

                <template v-for="(item, index) in cartItems" :key="index">
                    <div class="cart-list-item d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                        <div class="d-flex align-items-center gap-3">
                        <div class="cart-img">
                            <img :src="item.product_variant?.product?.image" class="rounded-3" width="80" alt="">
                        </div>
                        <div class="cart-product-info">
                            <h5 class="product-name fs-6">{{ item.product_variant?.product?.translation?.title }}</h5>
                            <div class="mt-3 d-flex align-items-center gap-2" v-if="item.product_variant?.attribute_values">
                                <span class="text-muted">{{ $t('global.ProductAttributes') }}:</span>
                                <span>{{ item.product_variant?.attribute_values }}</span>
                            </div>
                            <div class="mt-3 d-flex align-items-center gap-2" v-else>
                                <span class="text-muted">{{ $t('global.There is no customization for this product') }}</span>
                            </div>
                        </div>
                        </div>
                        <div class="cart-product-price">
                        <p>{{$t('global.price')}}</p>
                        <h5 class="mb-0"> {{item.price}} {{setting?.translation?.title}} </h5>
                        </div>
                        <div class="cart-product-qty">
                        <p>{{$t('global.Quantity')}}</p>
                            <input type="number" v-model.trim="cartItems[index].quantity" @change="orderSummary" class="form-control form-control-sm rounded-3 border-2 w-50" min="1" value="1" >
                             <template v-if="errors['products.' + index + '.quantity']">
                                <error-message v-for="(errorMessage, index) in errors['products.' + index + '.quantity']" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>
                        <div class="btn border border-2 cart-product-btn-delete" @click.prevent="deleteData(item.id,index)">
                            <i class="bi bi-x-lg"></i>
                        </div>
                    </div>
                    <div class="my-0 border-1 border-top"></div>
                </template>


            </div>
          </div>

          <div class="col-12 col-xl-4">
              <div class="card border-0 rounded-4 bg-light">
                <div class="card-body">
                  <div class="checkout-card p-2">
                     <h4 class="mb-0">{{$t('global.Order Summary')}}</h4>
                     <div class="my-4 border-1 border-top"></div>
                     <div class="d-flex align-items-center justify-content-between mb-3" v-if="discounts">
                       <p class="mb-0">{{$t('global.productsPrice')}}</p>
                       <p class="mb-0"> {{handleNumber(product_price)}} {{ setting?.translation?.title }} </p>
                     </div>
                     <div class="d-flex align-items-center justify-content-between mb-3" v-if="discounts">
                      <p class="mb-0 text-success">{{$t('global.Discounts')}} </p>
                      <p class="mb-0 text-success">-{{handleNumber(discounts)}} {{ setting?.translation?.title }}</p>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-3">
                       <p class="mb-0">{{$t('label.subTotal')}}</p>
                       <p class="mb-0"> {{handleNumber(subTotal)}} {{ setting?.translation?.title }} </p>
                     </div>
                    <div class="d-flex align-items-center justify-content-between mb-3" v-if="parseInt(setting.shipping_price) > 0">
                      <p class="mb-0 text-danger">{{$t('global.Shipping')}}</p>
                      <p class="mb-0 text-danger">+{{handleNumber(setting.shipping_price)}} {{ setting?.translation?.title }}</p>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-3" v-if="parseInt(setting.tax_percentage) > 0">
                      <p class="mb-0 text-danger">{{$t('global.tax')}} <span>({{ handleNumber(setting.tax_percentage) + '%' }})</span></p>
                      <p class="mb-0 text-danger">+{{handleNumber(tax)}} {{ setting?.translation?.title }}</p>
                    </div>
                    <div class="my-3 border-1 border-top"></div>
                    <div class="d-flex align-items-center justify-content-between mb-3">
                      <p class="mb-0 fs-5 fw-semibold">{{$t('global.total')}}</p>
                      <p class="mb-0 fs-5 fw-semibold">{{handleNumber(total)}} {{ setting?.translation?.title }}</p>
                    </div>
                    <div class="form-check my-3">
                      <input class="form-check-input" v-model="v$.status.$model" @change="changeStatus" type="checkbox" value="1" id="flexCheckDefault"
                      :class="{'is-invalid': v$.status.$error ||errors[`status`],
                                'is-valid':!v$.status.$invalid && !errors[`status`]}">
                      <label class="form-check-label" for="flexCheckDefault">
                        {{ $t('global.I agree with the terms and conditions') }}
                      </label>
                      <div class="invalid-feedback">
                        <span v-if="v$.status.required.$invalid">{{ $t('validation.fieldRequired') }}<br /> </span>
                    </div>
                    <template v-if="errors['status']">
                        <error-message v-for="(errorMessage, index) in errors['status']" :key="index">
                            {{ errorMessage }}
                        </error-message>
                    </template>
                    </div>
                    <div class="d-grid">
                      <button type="submit" class="btn btn-dark py-2 rounded-3" @click.prevent="AddSubmit" v-if="!loading" >{{$t('global.Proceed to checkout')}}</button>
                       <button class="btn btn-dark py-2 rounded-3 btn-loader" style="cursor: not-allowed" disabled v-else>
                            <span class="me-2">{{ $t('auth.Loading') }}</span>
                            <span class="loading"><i class="ri-loader-2-fill fs-16"></i></span>
                        </button>
                    </div>
                  </div>
                </div>
              </div>
          </div>
        </div><!--end row-->
      </div>
    </section>
    <!--end cart-->
</template>

<script>
import { computed, reactive, ref, toRefs, onMounted, nextTick } from "vue";
import { alphaNum,  email,  maxLength, minLength, required, numeric} from "@vuelidate/validators";
import useVuelidate from "@vuelidate/core";
import webApi from "../../api/webAxios";
import { useI18n } from "vue-i18n";


export default {
    name: "shoppingCart",
    props: {
        cart: {default: ''},
        setting: {default: ''},
        user: {default: ''},
    },
    components:{
    },
    setup(props, { emit }) {

        const errors = ref([]);
        let loading = ref(false);
        const { t } = useI18n({});
        let cartItems = ref([0]);
        let subTotal = ref([0]);
        let discounts = ref([0]);
        let product_price = ref([0]);
        let tax = ref([0]);
        let total = ref([0]);

         onMounted(() => {
            handelData();
        });

        let handelData = () => {
            setTimeout(async () => {
                cartItems.value = props.cart;
                orderSummary();

            }, 50);
        }

        let orderSummary  = () => {
            product_price.value = cartItems.value.reduce((acc, item) => acc + (item.product_variant.price_before_discount * item.quantity), 0);
            subTotal.value = cartItems.value.reduce((acc, item) => acc + (item.price * item.quantity), 0);
            discounts.value = product_price.value - subTotal.value; // Example fixed discount
            tax.value = (subTotal.value * props.setting.tax_percentage) / 100;
            total.value = Number(subTotal.value) + Number(props.setting.shipping_price) + Number(tax.value); // Ensure numeric addition

        }

        let submitdata = reactive({
            data: {
                status: '',
            },
        });

        const rules = computed(() => {
            return {
                status: {
                    required
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


        return { v$, ...toRefs(submitdata), loading, errors, t, cartItems ,handleNumber ,subTotal ,discounts ,total,product_price , orderSummary,deleteData,changeStatus,tax}
    },
    methods: {

        AddSubmit() {
            this.v$.$validate();
            this.errors = {};

            if (!this.v$.$error) {

                let formData = new FormData();
                this.cartItems.forEach((item, index) => {
                    formData.append(`cart[${index}][id]`, item.id);
                    formData.append(`cart[${index}][quantity]`, item.quantity);
                });
                formData.append(`status`, this.data.status);

                this.loading = true;
                webApi.post(`/web/proceed-to-checkout`, formData)
                    .then((res) => {

                        Swal.fire({
                            icon: 'success',
                            title: res.data.message,
                            showConfirmButton: false,
                            timer: 3000
                        });

                        this.data =  {
                            status: "",
                        };

                        this.errors =  [];

                        setTimeout(() => window.location='/checkout', 3000);

                    })
                    .catch((err) => {
                        console.log(err);
                        if (err) {
                            if (err.response) {
                                if (err.response.data.data) {
                                    this.errors = err.response.data.data.errors;
                                }else {
                                    this.errors = err.response.data.errors;
                                }
                            }
                        }
                    })
                    .finally(() => {
                        this.loading = false;
                    });
            } else {
                this.loading = false;
            }
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
