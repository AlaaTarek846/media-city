<template>

    <div class="my-profile">
               <div class="card border-0 rounded-3 bg-light">
                 <div class="card-body p-4">
                    <h5 class="mb-4">{{$t('global.My Information')}}</h5>
                    <form>
                      <div class="row g-3">
                        <div class="col-12 col-lg-6">
                          <label for="name" class="form-label">{{ $t('global.name') }}</label>
                          <input type="text" class="form-control border-2 py-2" id="name" v-model="v$.data.name.$model"
                                    :class="{
                                        'is-invalid': v$.data.name.$error || errors[`name`],
                                        'is-valid': !v$.data.name.$invalid && !errors[`name`]
                                    }">
                             <div class="invalid-feedback">
                                <span v-if="v$.data.name.required.$invalid">{{ $t('validation.fieldRequired')
                                    }}<br />
                                </span>
                                <span v-if="v$.data.name.minLength.$invalid">{{
                                    $t('validation.TitleIsMustHaveAtLeast') }} {{
                                        v$.data.name.minLength.$params.min
                                    }} {{ $t('validation.Letters') }} <br />
                                </span>
                                <span v-if="v$.data.name.maxLength.$invalid">{{
                                    $t('validation.TitleIsMustHaveAtMost') }} {{
                                        v$.data.name.maxLength.$params.max
                                    }} {{ $t('validation.Letters') }}
                                </span>
                            </div>
                            <template v-if="errors[`name`]">
                                <error-message v-for="(errorMessage, index) in errors[`name`]" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>

                        <div class="col-12 col-lg-6">
                          <label for="emailid" class="form-label">{{ `${$t('global.email')}` }}</label>
                          <input type="text" class="form-control border-2 py-2" id="emailid" v-model.trim="v$.data.email.$model"
                            :class="{ 'is-invalid': v$.data.email.$error || errors[`email`], 'is-valid': !v$.data.email.$invalid && !errors[`email`] }">
                            <div class="invalid-feedback">
                                <span v-if="v$.data.email.required.$invalid">{{
                                    $t('global.EmailIsRequired') }} <br /></span>
                                <span v-if="v$.data.email.email.$invalid">{{
                                    $t('global.ThisFieldMastBeEmail') }} <br /></span>
                            </div>
                            <template v-if="errors['email']">
                                <error-message v-for="(errorMessage, index) in errors['email']" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>
                        <div class="col-12 col-lg-6">
                          <label for="PhoneNumber" class="form-label">{{ `${$t('global.Mobile number, including country code')}` }}</label>
                          <vue-tel-input @validate="phoneValidation" v-model="v$.data.phone.$model"
                                defaultCountry="EG" :placeholder="'REE'" :onlyCountries="['SA','EG','AE','QA','KW','SY']" autocomplete="off"
                                :styleClasses="['form-control border-2 py-2', { 'is-invalid': v$.data.phone.$error || !is_valid || errors[`phone`], 'is-valid': !v$.data.phone.$invalid && !errors[`phone`] && is_valid }]"></vue-tel-input>
                            <div class="invalid-feedback">
                                <span v-if="v$.data.phone.required.$invalid">{{ $t('global.PhoneIsRequired') }}
                                    <br /></span>
                                <span
                                    v-if="v$.data.phone.integer.$invalid || v$.data.phone.maxLength.$invalid || !is_valid">{{
                                        $t('global.PhoneIsMustHaveAtLeast')
                                    }} <br /></span>
                            </div>
                            <template v-if="errors['phone']">
                                <error-message v-for="(errorMessage, index) in errors['phone']" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>

                        <div class="row">
                            <div class="col-12 col-lg-12">
                                <h5 class="mb-4 mt-4 text-center">{{$t('global.If you want to change your password, fill in the following fields')}}</h5>
                            </div>
                            <div class="col-12 col-lg-6">
                            <label for="inputChoosePassword" class="form-label">{{ $t('global.password') }}</label>
                            <input type="password" id="inputChoosePassword" v-model.trim="v$.data.password.$model" :class="['form-control border-2 py-2', { 'is-invalid': v$.data.password.$error || errors[`password`], 'is-valid': !v$.data.password.$invalid && !errors[`password`] }]">
                            <div class="invalid-feedback">
                                    <span v-if="v$.data.password.alphaNum.$invalid">{{
                                        $t('global.MustBeLettersOrNumbers') }}
                                        <br /></span>
                                    <span v-if="v$.data.password.minLength.$invalid">{{
                                        $t('global.PasswordIsMustHaveAtLeast') }}
                                        {{
                                            v$.data.password.minLength.$params.min
                                        }} {{ $t('global.Letters') }} <br /></span>
                                    <span v-if="v$.data.password.maxLength.$invalid">{{
                                        $t('global.PasswordIsMustHaveAtMost') }}
                                        {{
                                            v$.data.password.maxLength.$params.max
                                        }} {{ $t('global.Letters') }} </span>
                                </div>
                                <template v-if="errors['password']">
                                    <error-message v-for="(errorMessage, index) in errors['password']" :key="index">
                                        {{ errorMessage }}
                                    </error-message>
                                </template>
                            </div>
                            <div class="col-12 col-lg-6">
                            <label for="ConfirmPassword" class="form-label">{{ $t('global.password_confirmation') }}</label>
                                <input type="password" id="ConfirmPassword" v-model.trim="v$.data.confirmation.$model" :class="['form-control border-2 py-2', { 'is-invalid': v$.data.confirmation.$error || errors[`confirmation`], 'is-valid': !v$.data.confirmation.$invalid && !errors[`confirmation`] }]">

                                <div class="invalid-feedback">
                                    <span v-if="v$.data.confirmation.sameAs.$invalid">{{
                                        $t('global.ConfirmationMustMatchPassword') }}
                                        <br /></span>
                                </div>
                                <template v-if="errors['confirmation']">
                                    <error-message v-for="(errorMessage, index) in errors['confirmation']" :key="index">
                                        {{ errorMessage }}
                                    </error-message>
                                </template>
                                <div class="invalid-feedback">
                                    <span v-if="v$.data.email.required.$invalid">{{
                                        $t('global.EmailIsRequired') }} <br /></span>
                                    <span v-if="v$.data.email.email.$invalid">{{
                                        $t('global.ThisFieldMastBeEmail') }} <br /></span>
                                </div>
                                <template v-if="errors['email']">
                                    <error-message v-for="(errorMessage, index) in errors['email']" :key="index">
                                        {{ errorMessage }}
                                    </error-message>
                                </template>
                            </div>
                        </div>
                       
                        <div class="col-12 col-lg-12">
                          <button type="button" class="btn btn-dark px-4 py-2" @click.prevent="AddSubmit" v-if="!loading">{{$t('global.Save Changes')}}</button>

                          <button class="btn btn-dark px-4 py-2" style="cursor: not-allowed" disabled v-else>
                                <span class="me-2">{{ $t('auth.Loading') }}</span>
                                <span class="loading"><i class="ri-loader-2-fill fs-16"></i></span>
                            </button>
                        </div>

                      </div><!--end row-->
                    </form>
                 </div>
               </div>
            </div>
</template>

<script>
import { computed, reactive, ref, toRefs, onMounted, watch } from "vue";
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
    name: "profile",
     props: {
        user: {default: ''},
    },

    setup(props, { emit }) {

        const errors = ref([]);
        let loading = ref(false);
        const { t } = useI18n({});
        let is_valid = ref(true);

        let submitdata = reactive({
            data: {
                name: "",
                email: '',
                password: '',
                confirmation: '',
                phone: '',
                code_country: '',
            },
        });

        onMounted(() => {
            submitdata.data.name = props.user.name;
            submitdata.data.email = props.user.email;

            // Extract code_country and phone number from props.user.phone
            if (props.user.phone) {
                // Remove '+20' if present at the start of the phone number
                let phone = props.user.phone.replace(/^\+02/, '');
                // Match +<code_country><phone> with optional spaces
                const match = phone.match(/^\+?(\d{1,3})\s*(.*)$/);
                if (match) {
                    submitdata.data.code_country = match[1];
                    // Remove all spaces from phone number
                    let phoneNumber = match[2].replace(/\s+/g, '');
                    submitdata.data.phone = phoneNumber;
                } else {
                    submitdata.data.code_country = '963';
                    let phoneNumber = phone.replace(/\s+/g, '');
                    submitdata.data.phone = phoneNumber;
                }
            } else {
                submitdata.data.code_country = '963';
                submitdata.data.phone = '';
            }
        });

        const mustBeCoolPhone = (value) => value.match(/[0-9 ]{12}/);

        const rules = computed(() => {
            return {
                data: {
                    name: {
                        minLength: minLength(2),
                        maxLength: maxLength(70),
                        required,
                    },
                    password: {
                        minLength: minLength(8),
                        maxLength: maxLength(16),
                        alphaNum
                    },
                    confirmation: {
                        sameAs: sameAs(submitdata.data.password)
                    },
                    phone: {
                        required,
                        maxLength: maxLength(12),
                        integer: mustBeCoolPhone
                    },
                    email: {
                        email,
                        required
                    },

                },
            }
        });

        const v$ = useVuelidate(rules, submitdata);

        setTimeout(() => {
            is_valid.value = true;
        }, 200);

        const phoneValidation = (e) => {
            is_valid.value = e.valid;
            submitdata.data.code_country = e.countryCallingCode;
        }

        return {v$, ...toRefs(submitdata), loading, errors , is_valid, t, phoneValidation}
    },
    methods: {
        AddSubmit() {

            this.v$.$validate();
            this.errors = {};

            if (!this.v$.$error && this.is_valid) {

                let formData = new FormData();
                formData.append('name', this.data.name);
                formData.append('email', this.data.email);
                formData.append('password', this.data.password);
                formData.append('confirmation', this.data.confirmation);
                formData.append('phone', `+${this.data.code_country}`+this.data.phone);

                this.loading = true;
                webApi.post(`/web/updateProfile`, formData)
                    .then((res) => {
                        Swal.fire({
                            icon: 'success',
                            title: `${this.t('global.Data updated successfully')}`,
                            showConfirmButton: false,
                            timer: 6000
                        });

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
