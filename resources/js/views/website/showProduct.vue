<template>
      <!-- start quick view modal -->
    <div class="modal fade" id="QuickViewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content rounded-3">
        <div class="modal-header px-4">
            <h1 class="modal-title fs-5" id="exampleModalLabel">{{$t('global.Product Details')}}</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-4">
            <div class="row g-4">
            <div class="col-12 col-xl-6">
                <div class="product-images-grid">
                <div class="product-zoom-images">
                    <div class="row row-cols-2 g-4">
                    <div class="col" v-for="(image, index) in product?.images?.slice(0, 4)" :key="index">
                        <div>
                            <img :src="image.image" class="img-fluid rounded-3" alt="">
                        </div>
                    </div>

                    </div><!--end row-->
                </div>
            </div>
            </div>
            <div class="col-12 col-xl-6">
                <div class="product-details">
                <p class="mb-1">{{product?.category?.translation?.title}}</p>
                <h2 class="mb-0">{{product?.translation?.title}}</h2>
                <div class="d-flex align-items-center gap-2 my-3">
                     <span class="ratings text-warning" style="direction: ltr !important;">
                        <template v-for="i in 5" :key="i">
                            <i :class="[ 'bi',  product?.rate >= i  ? 'bi-star-fill' : product?.rate >= i - 0.5 ? 'bi-star-half' : 'bi-star' ]"></i>
                        </template>
                    </span>
                  <span class="font-14">({{ product?.review_count }} {{ $t('global.reviews') }})</span>
                </div>
                    <div class="product-price d-flex align-items-center gap-2" v-if="product?.variants?.length > 0">
                        <span class="fs-3 fw-semibold">{{handleNumber(variant.price)}}{{ setting?.translation?.title }}</span>
                        <span class="fs-6 text-decoration-line-through text-body-tertiary text-opacity-50" v-if="variant.discount_percentage">{{handleNumber(variant.price_before_discount)}}{{ setting?.translation?.title }}</span>
                        <span class="badge badge-pill bg-danger rounded-5" v-if="variant.discount_percentage">{{handleNumber(variant.discount_percentage)}}%</span>
                    </div>
                    <p class="product-short-desc mt-3 mb-0">{{product?.translation?.description}}</p>


                    <div class="product-size mt-4" v-if="product?.attributes?.length > 0" v-for="(attribute, attrIndex) in product?.attributes" :key="attrIndex">
                        <p class="mb-2">{{$t('global.Select')}} {{attribute?.attribute?.translation?.title}}</p>
                        <div class="product-size-list d-flex align-items-center gap-3">
                            <div class="product-size-list-item"
                                v-for="(option, optIndex) in attribute.options.split(',').map(opt => opt.trim()).filter(opt => opt)"
                                :key="optIndex"
                            >
                                <input type="radio"
                                    class="btn-check"
                                    :name="`options-size-${attrIndex}`"
                                    :id="`size-option-${attrIndex}-${optIndex}`"
                                    :value="option"
                                    v-model="data.attr_select[attrIndex]"
                                    @change="selectVariant(attrIndex, option)"
                                >
                                <label
                                    class="btn btn-outline-dark btn-product-size"
                                    :for="`size-option-${attrIndex}-${optIndex}`"
                                >{{option}}</label>
                            </div>
                        </div>
                    </div>

                    <div class="product-quantity mt-4">
                    <p class="mb-2">{{$t('global.Quantity')}}</p>
                    <div class="input-group">
                        <button class="btn border border-2 border-end-0" data-decrement type="button" @click="updateQuantity(-1)"><i class="bi bi-dash"></i></button>
                        <input type="number" class="form-control border-2 text-center" min="0" v-model="data.quantity" readonly>
                        <button class="btn border border-2 border-start-0" data-increment type="button" @click="updateQuantity(1)"><i class="bi bi-plus"></i></button>
                    </div>
                    </div>

                    <div class="product-cart-buttons d-grid d-md-flex align-items-center gap-3 mt-4" v-if="user">
                        <button type="button" @click.prevent="AddSubmit" class="btn btn-dark border border-2 rounded-5 border-dark py-2 px-5 d-flex align-items-center justify-content-center gap-2 w-100"><i class="bi bi-cart-plus"></i>{{$t('global.Add to cart')}}</button>
                        <button type="button" @click="addFavorite(product?.id)" class="btn border border-2 py-2 px-5 rounded-5 d-flex align-items-center justify-content-center gap-2">
                            <i :class="['bi', parseInt(product?.is_favorite) ? 'bi-heart-fill text-danger' : 'bi-heart']"></i>
                            {{$t('global.wishlist')}}
                        </button>
                    </div>

                    <div class="product-cart-buttons d-grid d-md-flex align-items-center gap-3 mt-4" v-else>
                        <a href="/login" class="btn btn-dark border border-2 rounded-5 border-dark py-2 px-5 d-flex align-items-center justify-content-center gap-2 w-100"><i class="bi bi-cart-plus"></i>{{$t('global.Add to cart')}}</a>
                        <a href="/login" class="btn border border-2 py-2 px-5 rounded-5 d-flex align-items-center justify-content-center gap-2">
                            <i class="bi bi-heart"></i>
                            {{$t('global.wishlist')}}
                        </a>
                    </div>
                </div>
            </div>
        </div><!--end row-->
        </div>
        </div>
    </div>
    </div>
    <!-- end quick view modal -->
</template>

<script>
import { computed, reactive, ref, toRefs, onMounted, nextTick,inject } from "vue";
import {
    alphaNum,
    email,
    maxLength,
    minLength,
    required,
    sameAs,
} from "@vuelidate/validators";
import useVuelidate from "@vuelidate/core";
import webApi from "../../api/webAxios";
import { useI18n } from "vue-i18n";


export default {
    name: "showProduct",
    props: {
        productData: {default: ''},
        user: {default: ''},
        setting: {default: ''},
    },

    setup(props, { emit }) {

        setTimeout(async () => {
            let myModalEl = document.getElementById('QuickViewModal')
            myModalEl.addEventListener('show.bs.modal', function (event) {
                resetModal();
            })
            myModalEl.addEventListener('hidden.bs.modal', function (event) {
                resetModalHidden();
            })
        }, 150);

        const errors = ref([]);
        let loading = ref(false);
        const { t } = useI18n({});
        let product = ref('');
        let variants = ref([]);
        let variant = ref('');

        let submitdata = reactive({
            data: {
                attr_select: [],
                quantity: 1,

            },
        });


        const rules = computed(() => {
            return {
                data: {
                    quantity: { required },

                },
            }
        });

        const v$ = useVuelidate(rules, submitdata);

        function defaultData() {
            submitdata.data = {
                attr_select: [],
                quantity: 1,
            };
            errors.value = [];
            product.value = '';
            variants.value = [];
            variant.value = '';
        }

        function resetModal()
        {
            defaultData();
            setTimeout(async () => {
                showProduct(props.productData.id);
            }, 100);

        }
         function resetModalHidden()
        {
            defaultData();
            nextTick(() => { v$.value.$reset() });
        }
        function handleNumber(approxNumber) {
            return parseFloat(approxNumber).toFixed(2).endsWith(".00")
                ? parseInt(approxNumber)
                : parseFloat(approxNumber).toFixed(2);
        }

        let showProduct = (id) => {
            webApi.get(`/web/show-product/${id}`)
                .then((res) => {
                    product.value = res.data.data;
                    submitdata.data.attr_select = [];
                    if (product.value.attributes.length > 0) {
                        product.value.attributes.forEach((attribute, index) => {
                            submitdata.data.attr_select[index] = attribute.options.split(',')[0].trim();
                        });
                        variants.value = res.data.data.variants;
                        variant.value = res.data.data.variants[0];
                    } else {
                        submitdata.data.attr_select = [];
                        variants.value = res.data.data.variants;
                        variant.value = res.data.data.variants[0];
                    }

                })
                .catch((err) => {
                })
        }

        let selectVariant = (attrIndex, option) => {
            submitdata.data.attr_select[attrIndex] = option;
            let selectedAttributes = submitdata.data.attr_select.map(opt => opt.trim());

            // Find a variant whose attribute_values match all selected attributes (order-insensitive)
            let selectedVariant = variants.value.find(variant => {
                if (!variant.attribute_values) return false;
                let variantAttrs = variant.attribute_values
                    .split(',')
                    .map(opt => opt.trim().split('|'))
                    .flat()
                    .map(val => val.trim());

                // Check if every selected attribute is present in variantAttrs and lengths match
                return (
                    variantAttrs.length === selectedAttributes.length &&
                    selectedAttributes.every(val => variantAttrs.includes(val))
                );
            });

            if (selectedVariant) {
                variant.value = selectedVariant;
            } else {
                variant.value = '';
            }
        }


        let addFavorite = (id) => {
            webApi.post(`/web/add-favorite/${id}`)
            .then((res) => {
                product.value.is_favorite = product.value.is_favorite == 1 ? 0 : 1;
                Swal.fire({
                    icon: product.value.is_favorite ? 'success' : 'error',
                    title: res.data.message,
                    showConfirmButton: false,
                    timer: 3000
                });
                // Emit "created" event
                emit("created");
            })
            .catch((err) => {
                console.error(err);
            });
        }

        let updateQuantity = (change) => {
            submitdata.data.quantity += change;
            if (submitdata.data.quantity < 1) {
                submitdata.data.quantity = 1;
            }
        }

        return {
            v$, ...toRefs(submitdata), loading, errors,handleNumber,product,showProduct,addFavorite, variants, variant , t,resetModal,selectVariant,updateQuantity
        }
    },
    methods: {
        AddSubmit() {
            this.v$.$validate();
            this.errors = {};

            if (!this.v$.$error) {

                let formData = new FormData();
                formData.append('variant_id', this.variant.id);
                formData.append('product_id', this.product.id);
                formData.append('price', this.variant.price);
                formData.append('quantity', this.data.quantity);

                this.loading = true;
                webApi.post(`/web/add-cart`, formData)
                    .then((res) => {
                        Swal.fire({
                            icon: 'success',
                            title: res.data.message,
                            showConfirmButton: false,
                            timer: 3000
                        });

                        this.errors =  [];
                        this.resetModal();
                        window.location.reload();

                    })
                    .catch((err) => {
                        this.loading = false;
                        if (err) {
                            if (err.response) {
                                if (err.response.data) {
                                    this.errors = err.response.data.errors;

                                    Swal.fire({
                                        icon: 'error',
                                        title: err.response.data.message,
                                        showConfirmButton: false,
                                        timer: 3000
                                    });
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

</style>
script
