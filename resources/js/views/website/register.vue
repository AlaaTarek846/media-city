<template>
    <!-- Start::app-content -->

    <section class="py-5">
        <div class="container px-3">
           <div class="row g-4 g-lg-5 align-items-center">
             <div class="col-12 col-xl-6">
               <div class="auth-register p-4 p-sm-5 rounded-3 border">
                  <h4 class="mb-0">{{$t('global.Create an account')}}</h4>
                  <p>{{ $t('global.I already have an account') }} <a href="/login" class="text-decoration-underline link-body-emphasis">{{$t('auth.signIn')}}</a></p>
                  <div class="form-body mt-5">
                    <div class="row row-cols-1 g-3">
                       <div class="col">
                          <label for="name" class="form-label">{{ $t('global.name') }} <span class="text-danger">*</span></label>
                          <input type="text" class="form-control form-control-lg border-2" id="name" v-model="v$.data.name.$model"
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
                       <div class="col">
                          <label for="EmailAddress" class="form-label">{{ `${$t('global.email')}` }} <span class="text-danger">*</span></label>
                          <input type="email" class="form-control form-control-lg border-2" id="EmailAddress" v-model.trim="v$.data.email.$model"
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
                       <div class="col">
                            <label class="form-label">
                                {{ `${$t('global.Mobile number, including country code')}` }}
                                <span class="text-danger">*</span>
                            </label>
                            <vue-tel-input @validate="phoneValidation" v-model="v$.data.phone.$model"
                                defaultCountry="EG" :placeholder="'REE'" :onlyCountries="['SA','EG','AE','QA','KW','SY']" autocomplete="off"
                                :styleClasses="['form-control form-control-lg border-2', { 'is-invalid': v$.data.phone.$error || !is_valid || errors[`phone`], 'is-valid': !v$.data.phone.$invalid && !errors[`phone`] && is_valid }]"></vue-tel-input>
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
                       <div class="col">
                        <label for="inputChoosePassword" class="form-label">{{ $t('global.password') }} <span class="text-danger">*</span></label>
                        <div class="input-group" id="show_hide_password">
                            <input type="password" id="inputChoosePassword" v-model.trim="v$.data.password.$model" :class="['form-control form-control-lg border-end-0', { 'is-invalid': v$.data.password.$error || errors[`password`], 'is-valid': !v$.data.password.$invalid && !errors[`password`] }]">
                           <a href="javascript:;" class="input-group-text bg-transparent"><i class="bi bi-eye-slash-fill"></i></a>
                           <div class="invalid-feedback">
                                <span v-if="v$.data.password.required.$invalid">{{ $t('global.PasswordIsRequired')
                                    }}<br />
                                </span>
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
                      </div>
                      <div class="col">
                        <label for="ConfirmPassword" class="form-label">{{ $t('global.password_confirmation') }} <span class="text-danger">*</span></label>
                        <div class="input-group" id="show_hide_password_confirm">
                            <input type="password" id="ConfirmPassword" v-model.trim="v$.data.confirmation.$model" :class="['form-control form-control-lg border-end-0', { 'is-invalid': v$.data.confirmation.$error || errors[`confirmation`], 'is-valid': !v$.data.confirmation.$invalid && !errors[`confirmation`] }]">
                            <a href="javascript:;" class="input-group-text bg-transparent"><i class="bi bi-eye-slash-fill"></i></a>

                            <div class="invalid-feedback">
                                <span v-if="v$.data.confirmation.required.$invalid">{{
                                    $t('global.ConfirmIsRequired') }}<br />
                                </span>
                                <span v-if="v$.data.confirmation.sameAs.$invalid">{{
                                    $t('global.ConfirmationMustMatchPassword') }}
                                    <br /></span>
                            </div>
                            <template v-if="errors['confirmation']">
                                <error-message v-for="(errorMessage, index) in errors['confirmation']" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>
                      </div>
                      <!-- <div class="col">
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                          <label class="form-check-label" for="flexCheckChecked">
                            I agree to the User
                          </label>
                        </div>
                      </div> -->
                      <div class="col">
                        <div class="d-grid">
                            <button type="button" @click.prevent="AddSubmit" class="btn btn-dark btn-lg px-4 rounded-3" v-if="!loading">
                                <span class="fs-6">{{ $t('auth.SignUp') }}</span>
                            </button>
                            <button class="btn btn-dark btn-lg px-4 rounded-3" style="cursor: not-allowed" disabled v-else>
                                <span class="me-2">{{ $t('auth.Loading') }}</span>
                                <span class="loading"><i class="ri-loader-2-fill fs-16"></i></span>
                            </button>
                        </div>
                      </div>
                      <!-- <div class="col">
                        <div class="separator section-padding mt-4">
                          <div class="line"></div>
                          <p class="mb-0">OR SIGN UP WITH</p>
                          <div class="line"></div>
                        </div>
                      </div>
                      <div class="col">
                        <div class="d-flex flex-column flex-lg-row align-items-center gap-2">
                           <button type="button" class="btn btn-outline-dark w-100 border border-2 flex-fill d-flex align-items-center gap-2 justify-content-center"><i class="bi bi-facebook"></i>Facebook</button>
                           <button type="button" class="btn btn-outline-dark w-100 border border-2 flex-fill d-flex align-items-center gap-2 justify-content-center"><i class="bi bi-twitter-x"></i>Twitter</button>
                           <button type="button" class="btn btn-outline-dark w-100 border border-2 flex-fill d-flex align-items-center gap-2 justify-content-center"><i class="bi bi-apple"></i>Apple</button>
                        </div>
                      </div> -->
                    </div><!--end row-->
                  </div>
               </div>
             </div>
             <div class="col-12 col-xl-6 d-none d-xl-flex">
               <div class="auth-register-img">
                  <img src="/website/images/gallery/auth/register.png" class="img-fluid" width="650" alt="">
               </div>
             </div>
           </div><!--end row-->
        </div>
    </section>

    <!-- End::app-content -->
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
    name: "register",

    setup() {

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
                        required,
                        minLength: minLength(8),
                        maxLength: maxLength(16),
                        alphaNum
                    },
                    confirmation: {
                        required,
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
                webApi.post(`/web/register`, formData)
                    .then((res) => {
                        Swal.fire({
                            icon: 'success',
                            // title: `${this.t('global.TheDataHasBeenSentSuccessfullyAndYouWillBeRespondedToByCustomerServiceSoon')}`,
                            title: `The data has been sent successfully`,
                            showConfirmButton: false,
                            timer: 6000
                        });

                        setTimeout(() => window.location='/', 5000);

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

$(document).ready(function () {
      $("#show_hide_password a").on('click', function (event) {
        event.preventDefault();
        if ($('#show_hide_password input').attr("type") == "text") {
          $('#show_hide_password input').attr('type', 'password');
          $('#show_hide_password i').addClass("bi-eye-slash-fill");
          $('#show_hide_password i').removeClass("bi-eye-fill");
        } else if ($('#show_hide_password input').attr("type") == "password") {
          $('#show_hide_password input').attr('type', 'text');
          $('#show_hide_password i').removeClass("bi-eye-slash-fill");
          $('#show_hide_password i').addClass("bi-eye-fill");
        }
      });
    });

     $(document).ready(function () {
      $("#show_hide_password_confirm a").on('click', function (event) {
        event.preventDefault();
        if ($('#show_hide_password_confirm input').attr("type") == "text") {
          $('#show_hide_password_confirm input').attr('type', 'password');
          $('#show_hide_password_confirm i').addClass("bi-eye-slash-fill");
          $('#show_hide_password_confirm i').removeClass("bi-eye-fill");
        } else if ($('#show_hide_password_confirm input').attr("type") == "password") {
          $('#show_hide_password_confirm input').attr('type', 'text');
          $('#show_hide_password_confirm i').removeClass("bi-eye-slash-fill");
          $('#show_hide_password_confirm i').addClass("bi-eye-fill");
        }
      });
    });
</script>

<style scoped>

</style>
