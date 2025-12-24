<template>
 <section class="tabular-product py-5">
      <div class="container px-3">
        <div class="table-responsive">
          <ul class="nav nav-pills mx-auto mb-4 p-2 rounded-5 border shadow-sm overflow-x-auto">
            <li class="nav-item">
              <button class="nav-link active rounded-5 px-5" data-bs-toggle="pill" data-bs-target="#new-arrivals"
                type="button">{{$t('global.New Arrivals')}}</button>
            </li>
            <li class="nav-item">
              <button class="nav-link rounded-5 px-5" data-bs-toggle="pill" data-bs-target="#best-seller"
                type="button">{{$t('global.Best Sellers')}}</button>
            </li>
            <li class="nav-item">
              <button class="nav-link rounded-5 px-5" data-bs-toggle="pill" data-bs-target="#trending"
                type="button">{{$t('global.Trending')}}</button>
            </li>
            <li class="nav-item">
              <button class="nav-link rounded-5 px-5" data-bs-toggle="pill" data-bs-target="#Offers"
                type="button">{{$t('global.Offers')}}</button>
            </li>
          </ul>
        </div>
        <div class="tab-content">
          <div class="tab-pane fade show active" id="new-arrivals">
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">

              <div class="col" v-for="(product, index) in arrivals_data" :key="product.id">
                <div class="product-card border rounded-3 p-3">
                  <div class="d-flex flex-column gap-3">
                    <div class="position-relative">
                      <div class="discount-ribben position-absolute top-0 start-0 m-3" v-if="product.variants[0].discount_percentage">{{handleNumber(product.variants[0].discount_percentage)}}%</div>
                      <a :href="`/product-detail/${product.id}`">
                        <img :src="product.image" class="product-img img-fluid rounded-3"
                          alt="">
                      </a>
                      <div class="position-absolute top-0 end-0 m-3 product-actions">
                        <div class="d-flex flex-column gap-2">
                          <a href="javascript:;" v-if="user" class="btn btn-action" @click="addFavoriteProduct(product?.id,index,'arrivals_data')"><i :class="['bi', parseInt(product?.is_favorite) ? 'bi-heart-fill text-danger' : 'bi-heart']"></i></a>
                           <a href="/login" v-else class="btn btn-action"><i class="bi bi-heart"></i></a>
                          <a  href="javascript:;" class="btn btn-action" data-bs-toggle="modal" data-bs-target="#QuickViewModal" @click="showModel(product)"><i class="bi bi-eye"></i></a>

                        </div>
                      </div>
                      <div class="position-absolute bottom-0 start-0 end-0 m-3 product-cart">
                        <a href="javascript:;" class="btn btn-dark rounded-5 w-100" data-bs-toggle="modal" data-bs-target="#QuickViewModal" @click="showModel(product)">{{$t('global.Add to cart')}}</a>
                      </div>
                    </div>
                    <div class="">
                      <h3 class="product-name mb-1">{{product.translation.title}}</h3>
                      <p class="mb-0 product-price d-flex align-items-center gap-2">
                            <span class="prev-price text-decoration-line-through" v-if="product.variants[0].discount_percentage">{{handleNumber(product.variants[0].price_before_discount)}}{{ setting?.translation?.title }}</span>
                            {{handleNumber(product.variants[0].price)}}{{ setting?.translation?.title }}
                        </p>
                    </div>
                  </div>
                </div>
              </div>

            </div><!--end row-->
          </div>
          <div class="tab-pane fade" id="best-seller">
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">

              <div class="col" v-for="(product, index) in bestSeller_data" :key="product.id">
                <div class="product-card border rounded-3 p-3">
                  <div class="d-flex flex-column gap-3">
                    <div class="position-relative">
                      <div class="discount-ribben position-absolute top-0 start-0 m-3" v-if="product.variants[0].discount_percentage">{{handleNumber(product.variants[0].discount_percentage)}}%</div>
                      <a :href="`/product-detail/${product.id}`">
                        <img :src="product.image" class="product-img img-fluid rounded-3"
                          alt="">
                      </a>
                      <div class="position-absolute top-0 end-0 m-3 product-actions">
                        <div class="d-flex flex-column gap-2">
                          <a href="javascript:;" v-if="user" class="btn btn-action" @click="addFavoriteProduct(product?.id,index,'bestSeller_data')"><i :class="['bi', parseInt(product?.is_favorite) ? 'bi-heart-fill text-danger' : 'bi-heart']"></i></a>
                           <a href="/login" v-else class="btn btn-action"><i class="bi bi-heart"></i></a>
                          <a href="javascript:;" class="btn btn-action" data-bs-toggle="modal" data-bs-target="#QuickViewModal" @click="showModel(product)"><i class="bi bi-eye"></i></a>
                        </div>
                      </div>
                      <div class="position-absolute bottom-0 start-0 end-0 m-3 product-cart">
                        <a href="javascript:;" class="btn btn-dark rounded-5 w-100" data-bs-toggle="modal" data-bs-target="#QuickViewModal" @click="showModel(product)">{{$t('global.Add to cart')}}</a>
                      </div>
                    </div>
                    <div class="">
                      <h3 class="product-name mb-1">{{product.translation.title}}</h3>
                      <p class="mb-0 product-price d-flex align-items-center gap-2">
                            <span class="prev-price text-decoration-line-through" v-if="product.variants[0].discount_percentage">{{handleNumber(product.variants[0].price_before_discount)}}{{ setting?.translation?.title }}</span>
                            {{handleNumber(product.variants[0].price)}}{{ setting?.translation?.title }}
                        </p>
                    </div>
                  </div>
                </div>
              </div>

            </div><!--end row-->
          </div>
          <div class="tab-pane fade" id="trending">
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">

              <div class="col" v-for="(product, index) in trending_data" :key="product.id">
                <div class="product-card border rounded-3 p-3">
                  <div class="d-flex flex-column gap-3">
                    <div class="position-relative">
                      <div class="discount-ribben position-absolute top-0 start-0 m-3" v-if="product.variants[0].discount_percentage">{{handleNumber(product.variants[0].discount_percentage)}}%</div>
                      <a :href="`/product-detail/${product.id}`">
                        <img :src="product.image" class="product-img img-fluid rounded-3"
                          alt="">
                      </a>
                      <div class="position-absolute top-0 end-0 m-3 product-actions">
                        <div class="d-flex flex-column gap-2">
                           <a href="javascript:;" v-if="user" class="btn btn-action" @click="addFavoriteProduct(product?.id,index,'trending_data')"><i :class="['bi', parseInt(product?.is_favorite) ? 'bi-heart-fill text-danger' : 'bi-heart']"></i></a>
                           <a href="/login" v-else class="btn btn-action"><i class="bi bi-heart"></i></a>
                          <a href="javascript:;" class="btn btn-action" data-bs-toggle="modal" data-bs-target="#QuickViewModal" @click="showModel(product)"><i class="bi bi-eye"></i></a>
                        </div>
                      </div>
                      <div class="position-absolute bottom-0 start-0 end-0 m-3 product-cart">
                        <a href="javascript:;" class="btn btn-dark rounded-5 w-100" data-bs-toggle="modal" data-bs-target="#QuickViewModal" @click="showModel(product)">{{$t('global.Add to cart')}}</a>
                      </div>
                    </div>
                    <div class="">
                      <h3 class="product-name mb-1">{{product.translation.title}}</h3>
                      <p class="mb-0 product-price d-flex align-items-center gap-2">
                            <span class="prev-price text-decoration-line-through" v-if="product.variants[0].discount_percentage">{{handleNumber(product.variants[0].price_before_discount)}}{{ setting?.translation?.title }}</span>
                            {{handleNumber(product.variants[0].price)}}{{ setting?.translation?.title }}
                        </p>
                    </div>
                  </div>
                </div>
              </div>

            </div><!--end row-->
          </div>
          <div class="tab-pane fade" id="Offers">
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">

              <div class="col" v-for="(product, index) in offers_data" :key="product.id">
                <div class="product-card border rounded-3 p-3">
                  <div class="d-flex flex-column gap-3">
                    <div class="position-relative">
                      <div class="discount-ribben position-absolute top-0 start-0 m-3" v-if="product.variants[0].discount_percentage">{{handleNumber(product.variants[0].discount_percentage)}}%</div>
                      <a :href="`/product-detail/${product.id}`">
                        <img :src="product.image" class="product-img img-fluid rounded-3" alt="">
                      </a>
                      <div class="position-absolute top-0 end-0 m-3 product-actions">
                        <div class="d-flex flex-column gap-2">
                          <a href="javascript:;" v-if="user" class="btn btn-action" @click="addFavoriteProduct(product?.id,index,'offers_data')"><i :class="['bi', parseInt(product?.is_favorite) ? 'bi-heart-fill text-danger' : 'bi-heart']"></i></a>
                           <a href="/login" v-else class="btn btn-action"><i class="bi bi-heart"></i></a>
                          <a href="javascript:;" class="btn btn-action" data-bs-toggle="modal" data-bs-target="#QuickViewModal" @click="showModel(product)"><i class="bi bi-eye"></i></a>
                        </div>
                      </div>
                      <div class="position-absolute bottom-0 start-0 end-0 m-3 product-cart">
                        <a href="javascript:;" class="btn btn-dark rounded-5 w-100" data-bs-toggle="modal" data-bs-target="#QuickViewModal" @click="showModel(product)">{{$t('global.Add to cart')}}</a>
                      </div>
                    </div>
                    <div class="">
                      <h3 class="product-name mb-1">{{product.translation.title}}</h3>
                      <p class="mb-0 product-price d-flex align-items-center gap-2">
                            <span class="prev-price text-decoration-line-through" v-if="product.variants[0].discount_percentage">{{handleNumber(product.variants[0].price_before_discount)}}{{ setting?.translation?.title }}</span>
                            {{handleNumber(product.variants[0].price)}}{{ setting?.translation?.title }}
                        </p>
                    </div>
                  </div>
                </div>
              </div>

            </div><!--end row-->
          </div>
        </div>
      </div>
      <ShowProduct v-model="modalShow" :productData="productData" :user="user" :setting="setting" @created="handelFavorite(productData)"/>
    </section>
</template>

<script>
import { computed, reactive, ref, toRefs, onMounted, nextTick } from "vue";
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
import ShowProduct from "./showProduct.vue";


export default {
    name: "tabularProduct",
    props: {
        arrivals: {default: ''},
        bestSeller: {default: ''},
        trending: {default: ''},
        offers: {default: ''},
        user: {default: ''},
        setting: {default: ''},
    },
    components:{
        ShowProduct
    },

    setup(props) {

        const errors = ref([]);
        let loading = ref(false);
        const { t } = useI18n({});
        let is_valid = ref(true);
        let arrivals_data = ref([]);
        let bestSeller_data = ref([]);
        let trending_data = ref([]);
        let offers_data = ref([]);
        let productData = ref('');
        let modalShow = ref(false);

        onMounted(() => {
            handelData();
        });

        let handelData = () => {
            arrivals_data.value = props.arrivals;
            bestSeller_data.value = props.bestSeller;
            trending_data.value = props.trending;
            offers_data.value = props.offers;

        }

        let submitdata = reactive({
            data: {

            },
        });


        const rules = computed(() => {
            return {
                data: {

                },
            }
        });

        const v$ = useVuelidate(rules, submitdata);


        setTimeout(() => {
            is_valid.value = true;
        }, 200);


        function resetModal()
        {
            nextTick(() => { v$.value.$reset() });
        }

        let  handelFavorite = (product) => {
            arrivals_data.value.find(p => p.id === product.id) ? arrivals_data.value.find(p => p.id === product.id).is_favorite = product.is_favorite == 1 ? 0 : 1 : '';
            bestSeller_data.value.find(p => p.id === product.id) ? bestSeller_data.value.find(p => p.id === product.id).is_favorite = product.is_favorite == 1 ? 0 : 1 : '';
            trending_data.value.find(p => p.id === product.id) ? trending_data.value.find(p => p.id === product.id).is_favorite = product.is_favorite == 1 ? 0 : 1 : '';
            offers_data.value.find(p => p.id === product.id) ? offers_data.value.find(p => p.id === product.id).is_favorite = product.is_favorite == 1 ? 0 : 1 : '';
            updateHeaderFavoriteCount(product.is_favorite == 1 ? 1 : -1);

        }


        let addFavoriteProduct = (id, index, arrayName) => {
            webApi.post(`/web/add-favorite/${id}`)
            .then((res) => {
                // Access the correct reactive array by name
                let arr = null;
                if (arrayName === 'arrivals_data') arr = arrivals_data;
                else if (arrayName === 'bestSeller_data') arr = bestSeller_data;
                else if (arrayName === 'trending_data') arr = trending_data;
                else if (arrayName === 'offers_data') arr = offers_data;

                if (arr && arr.value[index]) {
                    // Toggle favorite status
                    arr.value[index].is_favorite = arr.value[index].is_favorite == 1 ? 0 : 1;
                    updateHeaderFavoriteCount(arr.value[index].is_favorite == 1 ? 1 : -1);
                    let id = arr.value[index].id;
                    // Sync favorite status across all arrays
                    [arrivals_data, bestSeller_data, trending_data, offers_data].forEach(list => {
                        let prod = list.value.find(p => p.id === id);
                        if (prod) prod.is_favorite = arr.value[index].is_favorite;
                    });

                    Swal.fire({
                        icon: arr.value[index].is_favorite ? 'success' : 'error',
                        title: res.data.message,
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
            })
            .catch((err) => {
                console.error(err);
            });
        }

         function handleNumber(approxNumber) {
            return parseFloat(approxNumber).toFixed(2).endsWith(".00")
                ? parseInt(approxNumber)
                : parseFloat(approxNumber).toFixed(2);
        }

        let showModel = (data) => {
               productData.value=data;
               modalShow.value=true;
           }

        let updateHeaderFavoriteCount = (num) => {
            const el = document.getElementById('favorite-count');
            if (el) {
                el.textContent = parseInt(el.textContent) + num;
            }
        }

        return {
            v$, ...toRefs(submitdata), loading, errors, is_valid, t,resetModal,addFavoriteProduct, arrivals_data, bestSeller_data, trending_data, offers_data,modalShow,showModel, productData, handleNumber,handelFavorite
        }
    },
    methods: {
        AddSubmit() {

            this.v$.$validate();
            this.errors = {};

            if (!this.v$.$error && this.is_valid) {

                let formData = new FormData();
                formData.append('name', this.data.name);
                formData.append('subject', this.data.subject);
                formData.append('message', this.data.message);
                formData.append('email', this.data.email);
                formData.append('phone', `+${this.data.code_country}`+this.data.phone);

                this.loading = true;
                webApi.post(`/web/contact-us`, formData)
                    .then((res) => {
                        Swal.fire({
                            icon: 'success',
                            // title: `${this.t('global.TheDataHasBeenSentSuccessfullyAndYouWillBeRespondedToByCustomerServiceSoon')}`,
                            title: res.data.message,
                            showConfirmButton: false,
                            timer: 3000
                        });

                        this.data =  {
                            name: "",
                            subject: "",
                            email: '',
                            message: '',
                            phone: '',
                        };

                        this.errors =  [];
                        this.is_valid =  true;
                        this.resetModal();

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
            } else {
                this.loading = false;
            }
        }
    }
}
</script>

<style scoped>

</style>
