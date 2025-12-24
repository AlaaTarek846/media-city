<template>
    <section class="py-5 product-details">
      <div class="container px-3">
        <div class="row g-4 g-lg-5">
           <div class="col-12 col-lg-6">
              <div class="product-images">
                <div class="swiper product-images-swiper">
                  <div class="swiper-wrapper">
                    <div class="swiper-slide" v-for="(image, index) in product?.images" :key="index">
                      <img :src="image.image" class="rounded-3" alt="">
                    </div>

                  </div>
                </div>
                <div class="swiper product-images-swiper-thumbnail mt-3">
                  <div class="swiper-wrapper">
                    <div class="swiper-slide" v-for="(image, index) in product?.images" :key="index">
                      <img :src="image.image" class="rounded-3" alt="">
                    </div>
                  </div>
                </div>
              </div>
           </div>
           <div class="col-12 col-lg-6">
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
                 <div class="product-price d-flex align-items-center gap-2"  v-if="product?.variants?.length > 0">
                    <span class="fs-3 fw-semibold">{{handleNumber(variant.price)}}{{ setting?.translation?.title }}</span>
                    <span class="fs-6 text-decoration-line-through text-body-tertiary text-opacity-50" v-if="variant.discount_percentage">{{handleNumber(variant.price_before_discount)}}{{ setting?.translation?.title }}</span>
                    <span class="badge badge-pill bg-danger rounded-5" v-if="variant.discount_percentage">{{handleNumber(variant.discount_percentage)}}%</span>
                 </div>
                 <p class="product-short-desc mt-3 mb-0">{{product?.translation?.description}}</p>

                  <div class="product-size mt-4" v-if="product?.attributes?.length > 0" v-for="(attribute, attrIndex) in product?.attributes" :key="attrIndex">
                    <!-- <p class="mb-2 d-flex align-items-center justify-content-between">Select Size <a href="javascript:;" class="btn btn-sm text-decoration-underline" data-bs-toggle="modal" data-bs-target="#sizeGuidehModal">Size Guide</a></p> -->
                    <p class="mb-2">{{attribute.attribute.translation.title}}</p>
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
                    <div class="input-group input-group-lg">
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

                  <div class="mt-4">
                    <p class="mb-0 mt-3 d-flex align-items-center gap-2 font-14"><i class="bi bi-share"></i><span>{{$t('global.Share this product')}}</span></p>
                    <div class="mt-2 d-flex align-items-center gap-2 product-share-link">
                       <a href="javascript:;" class="btn btn-sm btn-outline-dark border"><i class="bi bi-facebook"></i></a>
                       <a href="javascript:;" class="btn btn-sm btn-outline-dark border"><i class="bi bi-twitter-x"></i></a>
                       <a href="javascript:;" class="btn btn-sm btn-outline-dark border"><i class="bi bi-linkedin"></i></a>
                       <a href="javascript:;" class="btn btn-sm btn-outline-dark border"><i class="bi bi-instagram"></i></a>
                       <a href="javascript:;" class="btn btn-sm btn-outline-dark border"><i class="bi bi-snapchat"></i></a>
                    </div>
                  </div>
                  <hr class="my-4 border-dark border-opacity-50">
                  <div class="">
                    <p class="mb-2 font-14"><span class="fw-semibold">{{ $t('global.sku') }}:</span> {{variant.sku}}</p>
                    <p class="mb-2 font-14"><span class="fw-semibold">{{ $t('global.brand') }}:</span> {{product?.brand?.translation?.title}}</p>
                    <p class="mb-2 font-14"><span class="fw-semibold">{{ $t('global.available') }}:</span> {{variant.quantity}}</p>
                    <p class="mb-2 font-14"><span class="fw-semibold">{{ $t('global.category') }}:</span>
                       <a href="javascript:;" class="link-secondary">{{product?.category?.translation?.title}}</a>
                      </p>
                  </div>
              </div>
           </div>
        </div><!--end row-->

        <div class="tabular-product-details mt-5">
          <div class="table-responsive">
            <ul class="nav nav-pills mb-4 overflow-x-auto justify-content-center gap-3">
              <li class="nav-item">
                <button class="nav-link rounded-5 px-5 fw-semibold" data-bs-toggle="pill" data-bs-target="#description"
                  type="button">{{$t('global.description')}}</button>
              </li>
              <li class="nav-item">
                <button class="nav-link active rounded-5 px-5 fw-semibold" data-bs-toggle="pill" data-bs-target="#customer-reviews"
                  type="button">{{$t('global.customer_reviews')}}</button>
              </li>
              <li class="nav-item">
                <button class="nav-link rounded-5 px-5 fw-semibold" data-bs-toggle="pill" data-bs-target="#shipping-returns"
                  type="button">{{$t('global.Shipping Returns')}}</button>
              </li>
              <li class="nav-item">
                <button class="nav-link rounded-5 px-5 fw-semibold" data-bs-toggle="pill" data-bs-target="#return-policy"
                  type="button">{{$t('global.return_policy')}}</button>
              </li>
            </ul>
          </div>
          <div class="tab-content border p-4 rounded-3">
            <div class="tab-pane fade show" id="description">
                 {{ product?.features?.translation?.description }}
               </div>
               <div class="tab-pane fade show active" id="customer-reviews">
                <div>
                  <h5 class="mb-4">{{$t('global.Customer Reviews')}}</h5>
                  <div class="hstack gap-md-5 gap-4 flex-column flex-lg-row">
                    <div class="text-center flex-shrink-0">
                      <div id="rating-number">
                          <h2 class="mb-2">{{ handleNumber( product?.rate ) }}</h2>
                          <div class="rating-star" style="direction: ltr !important;">
                            <template v-for="i in 5" :key="i">
                                <i :class="[ 'bi text-warning',  product?.rate >= i  ? 'bi-star-fill' : product?.rate >= i - 0.5 ? 'bi-star-half' : 'bi-star' ]"></i>
                            </template>
                          </div>
                          <p class="mb-0">({{ product?.review_count }} {{ $t('global.reviews') }})</p>
                      </div>
                    </div>
                    <div class="vr d-none d-lg-flex"></div>
                    <div class="w-100">
                        <div class="d-flex align-items-center gap-2" v-for="(item, index) in rate" :key="index">
                          <i class="bi bi-star-fill text-warning"></i>
                          <span>{{  item.rate }}</span>
                          <div class="progress w-100" role="progressbar" :aria-valuenow="item.percentage" aria-valuemin="0" aria-valuemax="100" style="height: 7px;">
                            <div class="progress-bar bg-dark" :style="{ width: item.percentage + '%' }"></div>
                          </div>
                        </div>

                    </div>
                    <div class="vr d-none d-lg-flex"></div>
                    <div class="leave-a-rating flex-shrink-0">
                      <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#reviewModal" class="btn btn-outline-dark px-4 py-2" v-if="user">{{ $t('global.Write a Review') }}</a>
                      <a href="/login" class="btn btn-outline-dark px-4 py-2" v-else>{{ $t('global.Write a Review') }}</a>
                    </div>
                  </div>

                  <div class="customer-reviews-list mt-5">

                    <div class="customer-reviews-list-item border-top py-4" v-for="(review, index) in product?.reviews" :key="index">
                       <div class="d-flex align-items-start gap-3">
                        <div class="customer-pic">
                        <span>{{ review?.user?.name ? review.user.name.charAt(0).toUpperCase() : '' }}</span>
                        </div>
                        <div class="flex-grow-1">
                          <div class="rating-star font-14 mb-1 text-warning">
                            <i class="bi bi-star-fill text-warning" v-for="i in 5" :key="i" :class="[ review?.rating >= i  ? 'bi-star-fill' : review?.rating >= i - 0.5 ? 'bi-star-half' : 'bi-star' ]"></i>
                          </div>
                          <h6 class="mb-0 customer-name">{{ review?.user?.name }}</h6>
                        </div>
                        <div class="review-date">
                        <span>{{ new Date(review?.created_at).toLocaleDateString('en-US', { day: 'numeric', month: 'long', year: 'numeric' }) }}</span>
                        </div>
                      </div>
                      <div class="review-description mt-2">
                         <p class="mb-0">{{ review?.review }}</p>
                           <div class="d-flex align-items-center justify-content-end gap-3">
                             <span>{{$t('global.Helpful?')}}</span>
                             <button type="button" class="btn btn-sm btn-light rounded-3 border d-flex align-items-center gap-1" @click.prevent="toggleReviewLike(review)">
                                <i :class="['bi', review?.is_liked_by_user ? 'bi-hand-thumbs-up-fill text-primary' : 'bi-hand-thumbs-up']"></i><span>{{review?.likes_count}}</span></button>
                           </div>
                      </div>
                    </div>

                  </div>
                </div>
            </div>
            <div class="tab-pane fade show" id="shipping-returns">
                <div v-html="shipping?.translation?.description"></div>
            </div>
            <div class="tab-pane fade show" id="return-policy">
            <div v-html="policy?.translation?.description"></div>
            </div>
          </div>
        </div>
      </div>
       <!-- start reviw modal -->
        <div class="modal" id="reviewModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content p-lg-2 p-0">
                <div class="modal-body p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <h1 class="modal-title fs-5 mb-0">{{ $t('global.Write a Review') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="write-review mt-4">
                    <div class="row g-4">

                        <div class="col-12">
                        <label for="chooserating" class="form-label">{{ $t('global.Choose Rating') }}</label>
                        <select class="form-select py-2 border-2" v-model="review.rating" id="chooserating">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                        </select>
                        </div>
                        <div class="col-12">
                        <label for="Review" class="form-label">{{ $t('global.Review') }}</label>
                        <textarea class="form-control py-2 border-2" v-model="review.comment" rows="4" cols="5" id="Review" :placeholder="$t('global.Write your comment')"></textarea>
                        </div>
                        <div class="col-12">
                        <div class="d-grid">
                            <button type="button" class="btn btn-dark py-2 border-2" @click.prevent="SubmitReview">{{ $t('global.Submit Review') }}</button>
                        </div>
                        </div>

                    </div><!--end row-->
                </form>
                </div>
            </div>
            </div>
        </div>
        <!-- end review modal -->
    </section>
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
    name: "productDetail",
    props: {
        detail: {default: ''},
        user: {default: ''},
        setting: {default: ''},
        policy: {default: ''},
        shipping: {default: ''},
        rate: {default: ''},
    },

    setup(props, { emit }) {

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
            review:{
                rating: 5,
                comment: ''
            }
        });

        const rules = computed(() => {
            return {
                data: {
                    quantity: { required },

                },
                review: {
                    rating: { required },
                    comment: {  }
                }
            }
        });

        const v$ = useVuelidate(rules, submitdata);

         onMounted(() => {
            resetModal();
        });

        function defaultData() {
            submitdata.data = {
                attr_select: [],
                quantity: 1,
            };
            submitdata.review = {
                rating: 5,
                comment: ''
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
                showProduct();
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

        let showProduct = () => {
            product.value = props.detail;
            submitdata.data.attr_select = [];
            if (product.value.attributes.length > 0) {
                product.value.attributes.forEach((attribute, index) => {
                    submitdata.data.attr_select[index] = attribute.options.split(',')[0].trim();
                });
                variants.value = props.detail.variants;
                variant.value = props.detail.variants[0];
            } else {
                submitdata.data.attr_select = [];
                variants.value = props.detail.variants;
                variant.value = props.detail.variants[0];
            }
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
                updateHeaderFavoriteCount(product.value.is_favorite ? 1 : -1);

            })
            .catch((err) => {
                console.error(err);
            });
        }

         let updateHeaderFavoriteCount = (num) => {
            const el = document.getElementById('favorite-count');
            if (el) {
                el.textContent = parseInt(el.textContent) + num;
            }
        }

        let updateQuantity = (change) => {
            submitdata.data.quantity += change;
            if (submitdata.data.quantity < 1) {
                submitdata.data.quantity = 1;
            }
        }

        let toggleReviewLike = (review) => {
            webApi.post(`/web/toggle-review-like/${review.id}`)
                .then((res) => {
                    review.is_liked_by_user = !review.is_liked_by_user;
                    review.likes_count += review.is_liked_by_user ? 1 : -1;

                    Swal.fire({
                        icon: 'success',
                        title: res.data.message,
                        showConfirmButton: false,
                        timer: 3000
                    });
                })
                .catch((err) => {
                    console.error(err);
                });
        }

        return {
            v$, ...toRefs(submitdata), loading, errors,handleNumber,product,showProduct,addFavorite, variants, variant , t,resetModal,selectVariant,updateQuantity,toggleReviewLike
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
        },
        SubmitReview() {
            this.v$.$validate();
            this.errors = {};

            if (!this.v$.$error) {

                let formData = new FormData();
                formData.append('product_id', this.product.id);
                formData.append('rating', this.review.rating);
                formData.append('review', this.review.comment);

                this.loading = true;
                webApi.post(`/web/add-review`, formData)
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
