<template>
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <h1 class="page-title fw-semibold fs-18 mb-0">{{ $t('global.theSettings') }}</h1>
            <div class="ms-md-1 ms-0">
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><router-link :to="{name: 'dashboard'}">{{$t('global.home')}}</router-link></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $t('global.theSettings') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- Page Header Close -->
        <div class="card custom-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6" v-if="data.ar" v-for="lang in languages">
                        <label class="form-label">{{ $t('global.CurrencyAbbreviation') }} ({{lang.title}})</label>
                        <input type="text" class="form-control"  v-model="v$[lang.code].title.$model"
                                :placeholder="$t('global.CurrencyAbbreviation')+' '+lang.title"
                                :class="{'is-invalid': v$[lang.code].title.$error || errors[`translations.${lang.code}.title`],
                                'is-valid': !v$[lang.code].title.$invalid && !errors[`translations.${lang.code}.title`]}">

                        <div class="invalid-feedback">
                            <span v-if="v$[lang.code].title.required.$invalid">{{ $t('validation.fieldRequired') }}<br /> </span>
                            <span v-if="v$[lang.code].title.minLength.$invalid">{{ $t('validation.TitleIsMustHaveAtLeast') }} {{
                                    v$[lang.code].title.minLength.$params.min
                                }} {{ $t('validation.Letters') }} <br />
                            </span>
                        </div>
                        <template v-if="errors[`translations.${lang.code}.title`]">
                            <error-message v-for="(errorMessage, index) in errors[`translations.${lang.code}.title`]" :key="index">
                                {{ errorMessage }}
                            </error-message>
                        </template>
                    </div>
                    <div class="col-md-12 mt-3">
                        <label for="shipping_price" class="form-label">{{$t('global.shipping_price')}}</label>
                        <input type="number" step="any" class="form-control" id="shipping_price" :placeholder="$t('global.shipping_price')"
                            v-model.trim="v$.shipping_price.$model"
                            :class="{'is-invalid': v$.shipping_price.$error ||errors[`shipping_price`],
                            'is-valid':!v$.shipping_price.$invalid && !errors[`shipping_price`]}">
                        <div class="invalid-feedback">
                             <span v-if="v$.shipping_price.required.$invalid">{{ $t('validation.fieldRequired') }}<br /> </span>
                             <span v-if="v$.shipping_price.numeric.$invalid">{{$t('validation.ThisFieldIsNumeric')}} <br /></span>
                        </div>
                        <template v-if="errors['shipping_price']">
                            <error-message v-for="(errorMessage, index) in errors['shipping_price']" :key="index">
                                {{ errorMessage }}
                            </error-message>
                        </template>
                    </div>

                    <div class="col-md-12 mt-3 mb-3 d-flex justify-content-end">
                        <button type="submit" v-if="!loading" @click.prevent="AddSubmit" class="btn btn-primary">{{ $t('global.Submit') }}</button>
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

<script>
import {computed, onMounted, reactive, ref, toRefs, watch,onBeforeMount} from "vue";
import {useI18n} from "vue-i18n";
import { minValue, required,numeric,minLength} from "@vuelidate/validators";
import useVuelidate from "@vuelidate/core";
import adminApi from "../../../api/adminAxios";

export default {
    name: "setting",
    data(){
        return {
            errors:{}
        }
    },
    setup(){
        const errors = ref([]);
        const languages = ref([]);
        const langValidation = ref({});
        let loading = ref(false);
        const {t} = useI18n({});
        const id = ref(1);

        function defaultData(){
            languages.value.forEach((el)=>{
               submitdata.data[el.code]={title:''};
               langValidation.value[el.code] ={
                   title: {minLength: minLength(1),required,}
               }
           });

           submitdata.data.shipping_price = '';
           loading.value = false;
           errors.value = [];
        }
       function resetModal() {
            defaultData();
            setTimeout(async () => {
                adminApi.get(`dashboard/settings/${id.value}`)
                    .then((res) => {
                        loading.value = true;
                        let l = res.data.data;
                        l.translations.forEach((el)=>{
                            submitdata.data[el.locale]={
                                title:el.title,
                            }
                        });
                        submitdata.data.shipping_price = l.shipping_price;

                    })
                    .catch((err) => {
                        console.log(err);
                    })
                    .finally(() => {
                        loading.value = false;
                    })

            }, 50);
        }

       onMounted(()=>{
            resetModal();
        });
        onBeforeMount(() => {
            languages.value=JSON.parse(localStorage.getItem('languages'));

        });

         //start design
         let submitdata =  reactive({
            data:{
                shipping_price: '',
            }
        });

        const rules = computed(() => {
            return {
                ...langValidation.value,
                shipping_price: {
                    required,
                    numeric,
                    min: minValue(0)
                },

            }
        });

        const v$ = useVuelidate(rules,submitdata.data);

        return {t,id,loading,resetModal,...toRefs(submitdata),v$,errors,languages};

    },
    methods: {
        AddSubmit() {

        this.v$.$validate();
        this.errors = {};

        let formData = new FormData();
            formData.append('shipping_price', this.data.shipping_price);
            formData.append('_method','PUT');
        if(!this.v$.$error) {
            this.loading = true;
            adminApi.post(`dashboard/settings/${this.id}`,formData)
                .then((res) => {
                    Swal.fire({
                        icon: 'success',
                        title: `${this.t('global.EditSuccessfully')}`,
                        showConfirmButton: false,
                        timer: 1500
                    });
                })
                .catch((err) => {
                    this.errors = err.response.data.errors;
                })
                .finally(() => {
                    this.loading = false;
                });
        }

        }
    }
}
</script>

