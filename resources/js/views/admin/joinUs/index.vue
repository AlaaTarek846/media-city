<template>
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <h1 class="page-title fw-semibold fs-18 mb-0">{{ $t('global.joinUs') }}</h1>
            <div class="ms-md-1 ms-0">
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><router-link :to="{name: 'dashboard'}">{{$t('global.home')}}</router-link></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $t('global.joinUs') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- Page Header Close -->
        <div class="card custom-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 mt-3">
                        <label for="facebook" class="form-label">{{$t('global.facebook')}}</label>
                        <input type="text" class="form-control" id="facebook" :placeholder="$t('global.facebook')"
                            v-model.trim="v$.facebook.$model"
                            :class="{'is-invalid': v$.facebook.$error ||errors[`facebook`],
                            'is-valid':!v$.facebook.$invalid && !errors[`facebook`]}">
                        <div class="invalid-feedback">
                            <span v-if="v$.facebook.required.$invalid">{{ $t('validation.fieldRequired') }}<br /> </span>
                        </div>
                        <template v-if="errors['facebook']">
                            <error-message v-for="(errorMessage, index) in errors['facebook']" :key="index">
                                {{ errorMessage }}
                            </error-message>
                        </template>
                    </div>
                    <div class="col-md-12 mt-3">
                        <label for="twitter" class="form-label">{{$t('global.twitter')}}</label>
                        <input type="text" class="form-control" id="twitter" :placeholder="$t('global.twitter')"
                            v-model.trim="v$.twitter.$model"
                            :class="{'is-invalid': v$.twitter.$error ||errors[`twitter`],
                            'is-valid':!v$.twitter.$invalid && !errors[`twitter`]}">
                        <div class="invalid-feedback">
                            <span v-if="v$.twitter.required.$invalid">{{ $t('validation.fieldRequired') }}<br /> </span>
                        </div>
                        <template v-if="errors['twitter']">
                            <error-message v-for="(errorMessage, index) in errors['twitter']" :key="index">
                                {{ errorMessage }}
                            </error-message>
                        </template>
                    </div>
                    <div class="col-md-12 mt-3">
                        <label for="instagram" class="form-label">{{$t('global.instagram')}}</label>
                        <input type="text" class="form-control" id="instagram" :placeholder="$t('global.instagram')"
                            v-model.trim="v$.instagram.$model"
                            :class="{'is-invalid': v$.instagram.$error ||errors[`instagram`],
                            'is-valid':!v$.instagram.$invalid && !errors[`instagram`]}">
                        <div class="invalid-feedback">
                            <span v-if="v$.instagram.required.$invalid">{{ $t('validation.fieldRequired') }}<br /> </span>
                        </div>
                        <template v-if="errors['instagram']">
                            <error-message v-for="(errorMessage, index) in errors['instagram']" :key="index">
                                {{ errorMessage }}
                            </error-message>
                        </template>
                    </div>
                    <div class="col-md-12 mt-3">
                        <label for="linkedin" class="form-label">{{$t('global.linkedin')}}</label>
                        <input type="text" class="form-control" id="linkedin" :placeholder="$t('global.linkedin')"
                            v-model.trim="v$.linkedin.$model"
                            :class="{'is-invalid': v$.linkedin.$error ||errors[`linkedin`],
                            'is-valid':!v$.linkedin.$invalid && !errors[`linkedin`]}">
                        <div class="invalid-feedback">
                            <span v-if="v$.linkedin.required.$invalid">{{ $t('validation.fieldRequired') }}<br /> </span>
                        </div>
                        <template v-if="errors['linkedin']">
                            <error-message v-for="(errorMessage, index) in errors['linkedin']" :key="index">
                                {{ errorMessage }}
                            </error-message>
                        </template>
                    </div>
                    <div class="col-md-12 mt-3">
                        <label for="youtube" class="form-label">{{$t('global.youtube')}}</label>
                        <input type="text" class="form-control" id="youtube" :placeholder="$t('global.youtube')"
                            v-model.trim="v$.youtube.$model"
                            :class="{'is-invalid': v$.youtube.$error ||errors[`youtube`],
                            'is-valid':!v$.youtube.$invalid && !errors[`youtube`]}">
                        <div class="invalid-feedback">
                            <span v-if="v$.youtube.required.$invalid">{{ $t('validation.fieldRequired') }}<br /> </span>
                        </div>
                        <template v-if="errors['youtube']">
                            <error-message v-for="(errorMessage, index) in errors['youtube']" :key="index">
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
    name: "joinUs",
    data(){
        return {
            errors:{}
        }
    },
    setup(){
        const errors = ref([]);
        let loading = ref(false);
        const {t} = useI18n({});
        const id = ref(1);

        function defaultData(){
           submitdata.data.facebook = '';
           submitdata.data.twitter = '';
           submitdata.data.instagram = '';
           submitdata.data.linkedin = '';
           submitdata.data.youtube = '';

           loading.value = false;
           errors.value = [];
        }
       function resetModal() {
            defaultData();
            setTimeout(async () => {
                adminApi.get(`dashboard/join-us/${id.value}`)
                    .then((res) => {
                        loading.value = true;
                        let l = res.data.data;
                        submitdata.data.facebook = l.facebook;
                        submitdata.data.twitter = l.twitter;
                        submitdata.data.instagram = l.instagram;
                        submitdata.data.linkedin = l.linkedin;
                        submitdata.data.youtube = l.youtube;

                    })
                    .catch((err) => {
                        console.log(err);
                    })
                    .finally(() => {
                        loading.value = false;
                    })

            }, 50);
        }

        onBeforeMount(() => {
            resetModal();
        });

         //start design
         let submitdata =  reactive({
            data:{
                facebook: '',
                twitter:'',
                instagram:'',
                linkedin:'',
                youtube:'',

            }
        });

        const rules = computed(() => {
            return {
                facebook: {required},
                twitter: {required},
                instagram: {required},
                linkedin: {required},
                youtube: {required},


            }
        });

        const v$ = useVuelidate(rules,submitdata.data);

        return {t,id,loading,resetModal,...toRefs(submitdata),v$,errors};

    },
    methods: {
        AddSubmit() {

        this.v$.$validate();
        this.errors = {};

        let formData = new FormData();
            formData.append('facebook', this.data.facebook);
            formData.append('twitter', this.data.twitter);
            formData.append('instagram', this.data.instagram);
            formData.append('linkedin', this.data.linkedin);
            formData.append('youtube', this.data.youtube);

            formData.append('_method','PUT');
        if(!this.v$.$error) {
            this.loading = true;
            adminApi.post(`dashboard/join-us/${this.id}`,formData)
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

