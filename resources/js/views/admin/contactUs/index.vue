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
                    <div class="col-md-6" v-if="data.ar" v-for="lang in languages">
                        <label class="form-label">{{ $t('label.title') }} ({{lang.title}})</label>
                        <input type="text" class="form-control"  v-model="v$[lang.code].title.$model"
                               :placeholder="$t('label.title')+' '+lang.title"
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

                     <div class="col-md-6 mt-3" v-if="data.ar" v-for="lang in languages">
                        <label class="form-label">{{ $t('global.Open Time') }} ({{lang.title}})</label>
                        <textarea
                            class="form-control summernote"
                            rows="6"
                            v-model.trim="v$[lang.code].description.$model"
                            :class="{'is-invalid': v$[lang.code].description.$error ||errors[`translations.${lang.code}.description`],
                            'is-valid':!v$[lang.code].description.$invalid && !errors[`translations.${lang.code}.description`]}">
                        </textarea>
                        <div class="invalid-feedback">
                            <span v-if="v$[lang.code].description.required.$invalid">{{ $t('validation.fieldRequired') }}<br /> </span>
                        </div>
                        <template v-if="errors[`translations.${lang.code}.description`]">
                            <error-message v-for="(errorMessage, index) in errors[`translations.${lang.code}.description`]" :key="index">
                                {{ errorMessage }}
                            </error-message>
                        </template>
                    </div>


                    <div class="col-md-12 mt-3">
                        <label for="location" class="form-label">{{$t('global.location')}}</label>
                        <input type="text" class="form-control" id="location" :placeholder="$t('global.location')"
                            v-model.trim="v$.location.$model"
                            :class="{'is-invalid': v$.location.$error ||errors[`location`],
                            'is-valid':!v$.location.$invalid && !errors[`location`]}">
                        <div class="invalid-feedback">
                            <span v-if="v$.location.required.$invalid">{{ $t('validation.fieldRequired') }}<br /> </span>
                        </div>
                        <template v-if="errors['location']">
                            <error-message v-for="(errorMessage, index) in errors['location']" :key="index">
                                {{ errorMessage }}
                            </error-message>
                        </template>
                    </div>

                    <div class="col-md-6 mt-3">
                        <label for="phone" class="form-label">{{$t('global.phone')}}</label>
                        <input type="text" class="form-control" id="phone" :placeholder="$t('global.phone')"
                            v-model.trim="v$.phone.$model"
                            :class="{'is-invalid': v$.phone.$error ||errors[`phone`],
                            'is-valid':!v$.phone.$invalid && !errors[`phone`]}">
                        <div class="invalid-feedback">
                            <span v-if="v$.phone.required.$invalid">{{ $t('validation.fieldRequired') }}<br /> </span>
                        </div>
                        <template v-if="errors['phone']">
                            <error-message v-for="(errorMessage, index) in errors['phone']" :key="index">
                                {{ errorMessage }}
                            </error-message>
                        </template>
                    </div>

                    <div class="col-md-6 mt-3">
                        <label for="email" class="form-label">{{$t('global.email')}}</label>
                        <input type="text" class="form-control" id="email" :placeholder="$t('global.email')"
                            v-model.trim="v$.email.$model"
                            :class="{'is-invalid': v$.email.$error ||errors[`email`],
                            'is-valid':!v$.email.$invalid && !errors[`email`]}">
                        <div class="invalid-feedback">
                            <span v-if="v$.email.required.$invalid">{{ $t('validation.fieldRequired') }}<br /> </span>
                        </div>
                        <template v-if="errors['email']">
                            <error-message v-for="(errorMessage, index) in errors['email']" :key="index">
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
import {maxLength, minLength, required,numeric} from "@vuelidate/validators";
import useVuelidate from "@vuelidate/core";
import adminApi from "../../../api/adminAxios";

export default {
    name: "contactUs",
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

        onMounted(()=>{
            languages.value=JSON.parse(localStorage.getItem('languages'));
            resetModal();
        });

        function defaultData(){

            languages.value.forEach((el)=>{
               submitdata.data[el.code]={title:'', description:''};
               langValidation.value[el.code] ={
                   title: {minLength: minLength(1),required,},
                   description: {required,}
               }
           });

           submitdata.data.location = '';
           submitdata.data.phone = '';
           submitdata.data.email = '';

           loading.value = false;
           errors.value = [];
        }
       function resetModal() {
            defaultData();
            setTimeout(async () => {
                adminApi.get(`dashboard/contact-us/${id.value}`)
                    .then((res) => {
                        loading.value = true;
                        let l = res.data.data;

                        l.translations.forEach((el)=>{
                            submitdata.data[el.locale]={
                                title:el.title,
                                description:el.description
                            }
                        });

                        submitdata.data.location = l.location;
                        submitdata.data.phone = l.phone;
                        submitdata.data.email = l.email;

                    })
                    .catch((err) => {
                        console.log(err);
                    })
                    .finally(() => {
                        loading.value = false;
                    })

            }, 50);
        }

        // onBeforeMount(() => {
        //     resetModal();
        // });

         //start design
         let submitdata =  reactive({
            data:{
                location: '',
                phone: '',
                email:'',
            }
        });

        const rules = computed(() => {
            return {
                ...langValidation.value,
                location: {required},
                phone: {required},
                email: {required},
            }
        });

        const v$ = useVuelidate(rules,submitdata.data);

        return {t,id,loading,languages,resetModal,...toRefs(submitdata),v$,errors};

    },
    methods: {
        AddSubmit() {

        this.v$.$validate();
        this.errors = {};

        let formData = new FormData();
        this.languages.forEach((el)=>{
            formData.append(`translations[${el.code}][title]`, this.data[el.code].title);
            formData.append(`translations[${el.code}][description]`, this.data[el.code].description);
        });
            formData.append('location', this.data.location);
            formData.append('phone', this.data.phone);
            formData.append('email', this.data.email);

            formData.append('_method','PUT');
        if(!this.v$.$error) {
            this.loading = true;
            adminApi.post(`dashboard/contact-us/${this.id}`,formData)
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

