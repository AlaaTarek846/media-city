<template>
   <section class="py-5">
        <div class="container px-3">
        <div class="d-flex align-items-center justify-content-between mb-5">
            <h2 class="section-title">{{$t('global.You may also like')}}</h2>
            <div class="recommended-products-swiper-nav d-flex align-items-center gap-3">
            <div class="slide-icon recommended-products-slider-icon-left"><i class="bi bi-arrow-left"></i></div>
            <div class="slide-icon recommended-products-slider-icon-right"><i class="bi bi-arrow-right"></i></div>
            </div>
        </div>
        <div class="recommended-products">
            <div class="swiper recommended-products-slider">
            <div class="swiper-wrapper">
                <div class="swiper-slide" v-for="(product, index) in products" :key="product.id">
                    <div class="product-card border rounded-3 p-3">
                        <div class="d-flex flex-column gap-3">
                        <div class="position-relative">
                            <div class="discount-ribben position-absolute top-0 start-0 m-3" v-if="product.variants[0].discount_percentage">{{handleNumber(product.variants[0].discount_percentage)}}%</div>
                            <a :href="`/product-detail/${product.id}`">
                                <img :src="product.image" class="product-img img-fluid rounded-3" :alt="product.translation?.title">
                            </a>
                            <div class="position-absolute top-0 end-0 m-3 product-actions">
                            <div class="d-flex flex-column gap-2">
                                <a href="javascript:;" v-if="user" class="btn btn-action" @click="addFavoriteProduct(product?.id,index)"><i :class="['bi', parseInt(product?.is_favorite) ? 'bi-heart-fill text-danger' : 'bi-heart']"></i></a>
                                <a href="/login" v-else class="btn btn-action"><i class="bi bi-heart"></i></a>
                                <a href="javascript:;" class="btn btn-action" data-bs-toggle="modal" data-bs-target="#QuickViewModal" @click="showModel(product)"><i class="bi bi-eye"></i></a>
                            </div>
                            </div>
                            <div class="position-absolute bottom-0 start-0 end-0 m-3 product-cart">
                                <a href="javascript:;" class="btn btn-dark rounded-5 w-100" data-bs-toggle="modal" data-bs-target="#QuickViewModal" @click="showModel(product)">{{$t('global.Add to cart')}}</a>
                            </div>
                        </div>
                        <div class="">
                            <h3 class="product-name mb-1" data-bs-toggle="tooltip" data-bs-placement="left"
                            data-bs-title="Wishlist">{{product.translation.title}}</h3>
                            <p class="mb-0 product-price">
                                <span class="prev-price text-decoration-line-through" v-if="product.variants[0].discount_percentage">{{handleNumber(product.variants[0].price_before_discount)}}{{ setting?.translation?.title }}</span>
                            {{handleNumber(product.variants[0].price)}}{{ setting?.translation?.title }}
                            </p>
                        </div>
                        </div>
                    </div>
                </div>
             
            </div>
            </div>
        </div>
        </div>
        <ShowProduct v-model="modalShow" :productData="productData" :setting="setting" :user="user" @created="handleFavorite(productData)"/>
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
    name: "checkoutProducts",
    props: {
        recommended: {default: ''},
        user: {default: ''},
        setting: {default: ''},
    },
    components:{
        ShowProduct
    },
    setup(props, { emit }) {

        const errors = ref([]);
        let loading = ref(false);
        const { t } = useI18n({});
        let products = ref([]);
        let productData = ref('');
        let modalShow = ref(false);

         onMounted(() => {
            handelData();
        });

        let handelData = () => {
            products.value = props.recommended;
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

         let addFavoriteProduct = (id,index) => {
            webApi.post(`/web/add-favorite/${id}`)
            .then((res) => {
                products.value[index].is_favorite = products.value[index].is_favorite == 1 ? 0 : 1;
                Swal.fire({
                    icon: products.value[index].is_favorite ? 'success' : 'error',
                    title: res.data.message,
                    showConfirmButton: false,
                    timer: 3000
                });
                updateHeaderFavoriteCount(products.value[index].is_favorite == 1 ? 1 : -1);
            })
            .catch((err) => {
                console.error(err);
            });
        }

        let  handleFavorite = (product) => {
            products.value.find(p => p.id === product.id) ? products.value.find(p => p.id === product.id).is_favorite = product.is_favorite == 1 ? 0 : 1 : '';
           updateHeaderFavoriteCount(product.is_favorite == 1 ? 1 : -1);
        }

        let updateHeaderFavoriteCount = (delta) => {
            const el = document.getElementById('favorite-count');
            if (el) {
                el.textContent = parseInt(el.textContent) + delta;
            }
        }

        return {  loading, errors, t, products , productData, modalShow ,showModel,handleNumber,addFavoriteProduct,handleFavorite}
    },
    methods: {
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
