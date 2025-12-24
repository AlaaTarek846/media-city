import './bootstrap';
import { createApp } from 'vue';
import i18n from './lang/web.js';
import jq from "jquery"
window.$ = window.jQuery = jq;

window.axios.defaults.headers.common['lang'] = 'XMLHttpRequest';

const app = createApp({});

import register from './views/website/register.vue';
import wishlist from './views/website/wishlist.vue';
import login from './views/website/Login.vue';
import tabularProduct from './views/website/tabularProduct.vue';
import PrimeVue from 'primevue/config';
import Aura from '@primevue/themes/aura';

import Select from 'primevue/select';
import ErrorMessage from "./components/ErrorMessage.vue";
import VueTelInput from 'vue-tel-input';
import 'vue-tel-input/vue-tel-input.css';
import ContactForm from './views/website/contactForm.vue';
import showProduct from './views/website/showProduct.vue';
import ShoppingCart from './views/website/shoppingCart.vue';
import checkout from './views/website/checkout.vue';
import CheckoutProducts from './views/website/checkoutProducts.vue';
import ProductDetail from './views/website/productDetail.vue';
import ShopProduct from './views/website/shopProduct.vue';
import AccountWishlist from './views/website/accountWishlist.vue';
import AccountAddresses from './views/website/accountAddresses.vue';
import Profile from './views/website/profile.vue';

const globalOptions = {
    mode: 'auto',
};

app.component('contact-form', ContactForm);
app.component('register', register);
app.component('wishlist', wishlist);
app.component('login', login);
app.component('tabularProduct', tabularProduct);
app.component('showProduct', showProduct);
app.component('shopping-cart', ShoppingCart);
app.component('checkout', checkout);
app.component('checkout-products', CheckoutProducts);
app.component('product-detail', ProductDetail);
app.component('shop-product', ShopProduct);
app.component('profile', Profile);
app.component('accountWishlist', AccountWishlist);
app.component('accountAddresses', AccountAddresses);

app.use(i18n);
app.component('Select', Select)
app.component("error-message", ErrorMessage);
app.use(VueTelInput, globalOptions);


app.use(PrimeVue, {
    theme: {
        preset: Aura
    },

});
app.mount('#app');



