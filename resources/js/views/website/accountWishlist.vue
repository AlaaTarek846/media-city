<template>

    <div class="shop-wishlist">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-3 g-4">
            <div class="col" v-for="(product, index) in products" :key="product.id">
                <div class="product-card rounded-3">
                    <div class="d-flex flex-column gap-3">
                        <div class="position-relative">
                            <div class="discount-ribben position-absolute top-0 start-0 m-3"
                                v-if="product.variants[0].discount_percentage">
                                {{ handleNumber(product.variants[0].discount_percentage) }}%</div>
                            <a :href="`/product-detail/${product.id}`">
                                <img :src="product.image" class="product-img img-fluid rounded-3"
                                    :alt="product.translation?.title">
                            </a>
                            <div class="position-absolute top-0 end-0 m-3 product-actions">
                                <div class="d-flex flex-column gap-2">
                                    <a href="javascript:;" class="btn btn-action"
                                        @click="removeFavorite(product?.id, index)"><i class="bi bi-trash"></i></a>
                                </div>
                            </div>
                            <div class="position-absolute bottom-0 start-0 end-0 m-3 product-cart">
                                <a href="javascript:;"
                                    class="btn btn-dark rounded-5 d-flex align-items-center justify-content-center gap-2 py-2"
                                    data-bs-toggle="modal" data-bs-target="#QuickViewModal"
                                    @click="showModel(product)"><i class="bi bi-basket2"></i><span>{{ $t('global.Add to cart')}}</span></a>
                            </div>
                        </div>
                        <div class="">
                            <h3 class="product-name mb-1">{{ product.translation.title }}</h3>
                            <p class="mb-0 product-price d-flex align-items-center gap-2">
                                <span class="prev-price text-decoration-line-through"
                                    v-if="product.variants[0].discount_percentage">{{ handleNumber(product.variants[0].price_before_discount) }}{{
                                    setting?.translation?.title }}</span>
                                {{ handleNumber(product.variants[0].price) }}{{ setting?.translation?.title }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <ShowProduct v-model="modalShow" :productData="productData" :setting="setting" :user="user"
            @created="handleFavorite(productData)" />
    </div>
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
    name: "accountWishlist",
    props: {
        favorites: { default: '' },
        user: { default: '' },
        setting: { default: '' },
    },
    components: {
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
            products.value = props.favorites;
        }

        function handleNumber(approxNumber) {
            return parseFloat(approxNumber).toFixed(2).endsWith(".00")
                ? parseInt(approxNumber)
                : parseFloat(approxNumber).toFixed(2);
        }

        let showModel = (data) => {
            productData.value = data;
            modalShow.value = true;
        }

        let removeFavorite = (id, index) => {
            webApi.post(`/web/add-favorite/${id}`)
                .then((res) => {

                    // Remove the product from the wishlist after successful API response
                    if (products.value[index]) {
                        products.value.splice(index, 1);
                        Swal.fire({
                            icon: 'success',
                            title: res.data.message,
                            showConfirmButton: false,
                            timer: 3000
                        });
                    }
                    updateHeaderFavoriteCount();
                })
                .catch((err) => {
                    console.error(err);
                });
        }

        let handleFavorite = (product) => {
            const index = products.value.findIndex(p => p.id === product.id);
            if (index !== -1) {
                products.value.splice(index, 1);
                updateHeaderFavoriteCount();
            }
        }

        let updateHeaderFavoriteCount = () => {
            const el = document.getElementById('favorite-count');
            if (el) {
                el.textContent = products.value.length;
            }
        }

        return { loading, errors, t, products, productData, modalShow, showModel, handleNumber, removeFavorite, handleFavorite }
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
