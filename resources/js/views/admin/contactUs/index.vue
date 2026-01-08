<template>
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <h1 class="page-title fw-semibold fs-18 mb-0">{{ $t('global.contactUs') }}</h1>
            <div class="ms-md-1 ms-0">
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><router-link :to="{name: 'dashboard'}">{{$t('global.home')}}</router-link></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $t('global.contactUs') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- Page Header Close -->
        <div class="card custom-card">
            <div class="card-body">
                <div class="row">

                    <div class="col-md-6 my-2">
                        <label class="form-label">الاميل </label>
                        <input type="text" class="form-control form-control-lg"  v-model="v$.email.$model"
                               :class="{'is-invalid': v$.email.$error || errors[`email`],
                                   'is-valid': !v$.email.$invalid && !errors[`email`]}">

                        <div class="invalid-feedback">
                            <span v-if="v$.email.required.$invalid">{{ $t('validation.fieldRequired') }}<br /> </span>
                            <template v-if="errors[`email`]">
                                <error-message v-for="(errorMessage, index) in errors[`email`]" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>
                    </div>
                    <div class="col-md-6 my-2">
                        <label class="form-label">الموبيل </label>
                        <input type="text" class="form-control form-control-lg"  v-model="v$.mobile.$model"
                               :class="{'is-invalid': v$.mobile.$error || errors[`mobile`],
                                   'is-valid': !v$.mobile.$invalid && !errors[`mobile`]}">

                        <div class="invalid-feedback">
                            <span v-if="v$.mobile.required.$invalid">{{ $t('validation.fieldRequired') }}<br /> </span>
                            <template v-if="errors[`mobile`]">
                                <error-message v-for="(errorMessage, index) in errors[`mobile`]" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>
                    </div>
                    <div class="col-md-6 my-2">
                        <label class="form-label">انستغرام</label>
                        <input type="text" class="form-control form-control-lg"  v-model="v$.instagram.$model"
                               :class="{'is-invalid': v$.instagram.$error || errors[`instagram`],
                                   'is-valid': !v$.instagram.$invalid && !errors[`instagram`]}">

                        <div class="invalid-feedback">
                            <span v-if="v$.instagram.required.$invalid">{{ $t('validation.fieldRequired') }}<br /> </span>
                            <template v-if="errors[`instagram`]">
                                <error-message v-for="(errorMessage, index) in errors[`instagram`]" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>
                    </div>
                    <div class="col-md-6 my-2">
                        <label class="form-label">الفيسبوك</label>
                        <input type="text" class="form-control form-control-lg"  v-model="v$.facebook.$model"
                               :class="{'is-invalid': v$.facebook.$error || errors[`mobile_2`],
                                   'is-valid': !v$.facebook.$invalid && !errors[`facebook`]}">

                        <div class="invalid-feedback">
                            <span v-if="v$.facebook.required.$invalid">{{ $t('validation.fieldRequired') }}<br /> </span>
                            <template v-if="errors[`facebook`]">
                                <error-message v-for="(errorMessage, index) in errors[`facebook`]" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>
                    </div>
                    <div class="col-md-6 my-2">
                        <label class="form-label">لينكد ان</label>
                        <input type="text" class="form-control form-control-lg"  v-model="v$.linkedin.$model"
                               :class="{'is-invalid': v$.linkedin.$error || errors[`linkedin`],
                                   'is-valid': !v$.linkedin.$invalid && !errors[`linkedin`]}">

                        <div class="invalid-feedback">
                            <span v-if="v$.linkedin.required.$invalid">{{ $t('validation.fieldRequired') }}<br /> </span>
                            <template v-if="errors[`linkedin`]">
                                <error-message v-for="(errorMessage, index) in errors[`linkedin`]" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>
                    </div>
                    <div class="col-md-6 my-2">
                        <label class="form-label"> تويرتر</label>
                        <input type="text" class="form-control form-control-lg"  v-model="v$.twitter.$model"
                               :class="{'is-invalid': v$.twitter.$error || errors[`twitter`],
                                   'is-valid': !v$.twitter.$invalid && !errors[`twitter`]}">

                        <div class="invalid-feedback">
                            <span v-if="v$.twitter.required.$invalid">{{ $t('validation.fieldRequired') }}<br /> </span>
                            <template v-if="errors[`twitter`]">
                                <error-message v-for="(errorMessage, index) in errors[`twitter`]" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>
                    </div>
                    <div class="col-md-6 my-2">
                        <label class="form-label">العنوان عربي</label>
                        <input type="text" class="form-control form-control-lg"  v-model="v$.address_ar.$model"
                               :class="{'is-invalid': v$.address_ar.$error || errors[`address_ar`],
                                   'is-valid': !v$.address_ar.$invalid && !errors[`address_ar`]}">

                        <div class="invalid-feedback">
                            <span v-if="v$.address_ar.required.$invalid">{{ $t('validation.fieldRequired') }}<br /> </span>
                            <template v-if="errors[`address_ar`]">
                                <error-message v-for="(errorMessage, index) in errors[`address_ar`]" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>
                    </div>
                    <div class="col-md-6 my-2">
                        <label class="form-label">العنوان الانجليزي</label>
                        <input type="text" class="form-control form-control-lg"  v-model="v$.address_en.$model"
                               :class="{'is-invalid': v$.address_en.$error || errors[`address_en`],
                                   'is-valid': !v$.address_en.$invalid && !errors[`address_en`]}">

                        <div class="invalid-feedback">
                            <span v-if="v$.address_en.required.$invalid">{{ $t('validation.fieldRequired') }}<br /> </span>
                            <template v-if="errors[`address_ar`]">
                                <error-message v-for="(errorMessage, index) in errors[`address_en`]" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>
                    </div>
                    <div class="col-md-12 my-2">
                        <label class="form-label"> الخريطة</label>
                        <input type="text" class="form-control form-control-lg"  v-model="v$.map.$model"
                               :class="{'is-invalid': v$.map.$error || errors[`map`],
                                   'is-valid': !v$.map.$invalid && !errors[`map`]}">

                        <div class="invalid-feedback">
                            <span v-if="v$.map.required.$invalid">{{ $t('validation.fieldRequired') }}<br /> </span>
                        </div>
                        <template v-if="errors[`map`]">
                            <error-message v-for="(errorMessage, index) in errors[`map`]" :key="index">
                                {{ errorMessage }}
                            </error-message>
                        </template>
                    </div>
                    <div class="col-md-6 mt-3" v-if="submitData.data.ar" v-for="lang in languages">
                        <label class="form-label">{{ $t('label.description') }} ({{ lang == 'ar' ? 'عربي' : 'English' }})</label>
                        <textarea
                            class="form-control summernote"
                            rows="4"
                            v-model.trim="v$[`address_${lang}`].$model"
                            :class="{'is-invalid': v$[`address_${lang}`].$error ||errors[`address_${lang}`],
                                    'is-valid':!v$[`address_${lang}`].$invalid && !errors[`address_${lang}`]}">
                            </textarea>
                        <template v-if="errors[`address_${lang}`]">
                            <error-message v-for="(errorMessage, index) in errors[`address_${lang}`]" :key="index">
                                {{ errorMessage }}
                            </error-message>
                        </template>
                    </div>

                    <div class="col-md-12 mt-3 mb-3 d-flex justify-content-end">
                        <button type="submit" v-if="!loading || permission.includes('contact us edit')" @click.prevent="AddSubmit" class="btn btn-primary">{{ $t('global.Submit') }}</button>
                        <button class="btn btn-primary btn-loader" v-else>
                            <span class="me-2">{{$t('global.Loading')}}</span>
                            <span class="loading"><i class="ri-loader-2-fill fs-16"></i></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {computed, onMounted, reactive, ref, toRefs, watch,onBeforeMount} from "vue";
import {useI18n} from "vue-i18n";
import {maxLength, minLength, required,numeric} from "@vuelidate/validators";
import useVuelidate from "@vuelidate/core";
import adminApi from "../../../api/adminAxios";
import {useStore} from "vuex";

const errors = ref([]);
const areas = ref([]);
const languages = ref([]);
const cities = ref([]);
const langValidation = ref({});
let loading = ref(false);
let is_disabled = ref(false);
const { t } = useI18n({});
const store = useStore();
// Ensure permission is always an array to avoid runtime errors when used in template
const permission = computed(() => store.getters['authAdmin/permission'] ?? []);
const id = ref(null);
const imageUpload = ref('');

onMounted(()=>{
    languages.value=JSON.parse(localStorage.getItem('languages'));
    resetModal();
});

function defaultData(){
    is_disabled.value = false;
    loading.value = false;
    errors.value = [];
}
function resetModal() {
    defaultData();
    setTimeout(async () => {
        adminApi.get(`dashboard/contact-us/1`)
            .then((res) => {
                loading.value = true;
                let l = res.data.data;
                submitData.data.email = l.email;
                submitData.data.mobile = l.mobile;
                submitData.data.twitter = l.twitter;
                submitData.data.instagram = l.instagram;
                submitData.data.facebook = l.facebook;
                submitData.data.linkedin = l.linkedin;
                submitData.data.map = `${l.map}`;
                submitData.data.address_ar = l.address_ar;
                submitData.data.address_en = l.address_en;
            })
            .catch((err) => {
                console.log(err);
            })
            .finally(() => {
                loading.value = false;
            })

    }, 50);
}
function resetModalHidden() {
    defaultData();
    nextTick(() => { v$.value.$reset() });
}
//start design
const submitData =  reactive({
    data:{
        email: '',
        mobile: '',
        twitter: '',
        instagram: '',
        facebook: '',
        linkedin: '',
        map: '',
    }
});

const rules = computed(() => {
    return {
        email: { required },
        mobile: { required },
        address_en: { required },
        address_ar: { required },
        twitter: { required },
        instagram: { required },
        facebook: { required },
        linkedin: { required },
        map: { required },
    }
});

const v$ = useVuelidate(rules,submitData.data);

const AddSubmit = () =>  {

    v$.value.$validate();
    errors.value = {};

    let formData = new FormData();
    formData.append(`address_ar`, submitData.data.address_ar);
    formData.append(`address_en`, submitData.data.address_en);
    formData.append(`email`, submitData.data.email);
    formData.append(`mobile`, submitData.data.mobile);
    formData.append(`map`, submitData.data.map);
    formData.append(`facebook`, submitData.data.facebook);
    formData.append(`twitter`, submitData.data.twitter);
    formData.append(`instagram`, submitData.data.instagram);
    formData.append(`linkedin`, submitData.data.linkedin);
    if(!v$.value.$error) {
        is_disabled.value = false;
        loading.value = true;
        formData.append('_method','PUT');
        adminApi.post(`dashboard/contact-us/1`,formData)
            .then((res) => {
                Swal.fire({
                    icon: 'success',
                    title: `${t('global.EditSuccessfully')}`,
                    showConfirmButton: false,
                    timer: 1500
                });
            })
            .catch((err) => {
                errors.value = err.response?.data?.errors;
            })
            .finally(() => {
                loading.value = false;
            });
    }

}

</script>

