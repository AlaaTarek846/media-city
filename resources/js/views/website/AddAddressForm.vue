<template>
      <div class="mt-4 checkout-form p-4 border rounded-3">
        <h5 class="mb-4">{{ t('global.Add Address') }}</h5>
        <div class="row g-4">
            <div class="col-12 col-lg-12">
                <label for="nameAddress" class="form-label">{{ $t('global.nameAddress') }}</label>
                <input type="text" class="form-control form-control-lg border-2" id="nameAddress" :placeholder="$t('global.nameAddress')" v-model="v$.data.title.$model"
                    :class="{
                        'is-invalid': v$.data.title.$error || errors[`title`],
                        'is-valid': !v$.data.title.$invalid && !errors[`title`]
                    }">
                <div class="invalid-feedback">
                    <span v-if="v$.data.title.required.$invalid">{{ $t('validation.fieldRequired')
                        }}<br />
                    </span>
                    <span v-if="v$.data.title.minLength.$invalid">{{
                        $t('validation.TitleIsMustHaveAtLeast') }} {{
                            v$.data.title.minLength.$params.min
                        }} {{ $t('validation.Letters') }} <br />
                    </span>
                    <span v-if="v$.data.title.maxLength.$invalid">{{
                        $t('validation.TitleIsMustHaveAtMost') }} {{
                            v$.data.title.maxLength.$params.max
                        }} {{ $t('validation.Letters') }}
                    </span>
                </div>
                <template v-if="errors[`title`]">
                    <error-message v-for="(errorMessage, index) in errors[`title`]" :key="index">
                        {{ errorMessage }}
                    </error-message>
                </template>
            </div>
            <div class="col-12 col-lg-12">
                <label for="address" class="form-label">{{ $t('global.address') }}</label>
                <textarea class="form-control border-2" rows="4" cols="4" :placeholder="$t('global.address')" v-model="v$.data.address.$model"
                    :class="{
                        'is-invalid': v$.data.address.$error || errors[`address`],
                        'is-valid': !v$.data.address.$invalid && !errors[`address`]
                    }"></textarea>
                <div class="invalid-feedback">
                    <span v-if="v$.data.address.required.$invalid">{{ $t('validation.fieldRequired') }}<br />
                    </span>
                </div>
                <template v-if="errors[`address`]">
                    <error-message v-for="(errorMessage, index) in errors[`address`]" :key="index">
                        {{ errorMessage }}
                    </error-message>
                </template>
            </div>
            <div class="col-12 col-lg-6">
                <label for="SelectCountry" class="form-label">{{ $t('global.Select Country') }}</label>
                <select class="form-select form-select-lg border-2" id="SelectCountry" v-model="v$.data.country_id.$model"
                    :class="{
                        'is-invalid': v$.data.country_id.$error || errors[`country_id`],
                        'is-valid': !v$.data.country_id.$invalid && !errors[`country_id`]
                    }">
                    <option v-for="country in countries" :key="country.id" :value="country.id">{{ country.title }}</option>
                </select>
                <div class="invalid-feedback">
                    <span v-if="v$.data.country_id.required.$invalid">{{ $t('validation.fieldRequired') }}<br />
                    </span>
                </div>
                <template v-if="errors[`country_id`]">
                    <error-message v-for="(errorMessage, index) in errors[`country_id`]" :key="index">
                        {{ errorMessage }}
                    </error-message>
                </template>
            </div>
            <div class="col-12 col-lg-6">
                <label for="SelectArea" class="form-label">{{ $t('global.selectArea') }}</label>
                <select class="form-select form-select-lg border-2" id="SelectArea" v-model="v$.data.area_id.$model"
                    :class="{
                        'is-invalid': v$.data.area_id.$error || errors[`area_id`],
                        'is-valid': !v$.data.area_id.$invalid && !errors[`area_id`]
                    }">
                    <option v-for="area in areas" :key="area.id" :value="area.id">{{ area.title }}</option>
                </select>
                <div class="invalid-feedback">
                    <span v-if="v$.data.area_id.required.$invalid">{{ $t('validation.fieldRequired') }}<br />
                    </span>
                </div>
                <template v-if="errors[`area_id`]">
                    <error-message v-for="(errorMessage, index) in errors[`area_id`]" :key="index">
                        {{ errorMessage }}
                    </error-message>
                </template>
            </div>
            <div class="col-12 col-lg-6">
                <label for="building_number" class="form-label">{{$t('global.building_number')}}</label>
                <input type="text" class="form-control form-control-lg border-2" id="building_number" :placeholder="$t('global.building_number')" v-model="v$.data.building_number.$model"
                    :class="{
                        'is-invalid': v$.data.building_number.$error || errors[`building_number`],
                        'is-valid': !v$.data.building_number.$invalid && !errors[`building_number`]
                    }">
                <div class="invalid-feedback">
                </div>
                <template v-if="errors[`building_number`]">
                    <error-message v-for="(errorMessage, index) in errors[`building_number`]" :key="index">
                        {{ errorMessage }}
                    </error-message>
                </template>
            </div>
            <div class="col-12 col-lg-6">
                <label for="floor_number" class="form-label">{{ $t('global.floor_number') }}</label>
                <input type="text" class="form-control form-control-lg border-2" id="floor_number" :placeholder="$t('global.floor_number')" v-model="v$.data.floor_number.$model"
                    :class="{
                        'is-invalid': v$.data.floor_number.$error || errors[`floor_number`],
                        'is-valid': !v$.data.floor_number.$invalid && !errors[`floor_number`]
                    }">
                <div class="invalid-feedback">
                </div>
                <template v-if="errors[`floor_number`]">
                    <error-message v-for="(errorMessage, index) in errors[`floor_number`]" :key="index">
                        {{ errorMessage }}
                    </error-message>
                </template>
            </div>

            <div class="col-12 col-lg-6">
                <label for="apartment_number" class="form-label">{{$t('global.apartment_number')}}</label>
                <input type="text" class="form-control form-control-lg border-2" id="apartment_number" :placeholder="$t('global.apartment_number')" v-model="v$.data.apartment_number.$model"
                    :class="{
                        'is-invalid': v$.data.apartment_number.$error || errors[`apartment_number`],
                        'is-valid': !v$.data.apartment_number.$invalid && !errors[`apartment_number`]
                    }">
                <div class="invalid-feedback">
                </div>
                <template v-if="errors[`apartment_number`]">
                    <error-message v-for="(errorMessage, index) in errors[`apartment_number`]" :key="index">
                        {{ errorMessage }}
                    </error-message>
                </template>
            </div>
            <div class="col-12 col-lg-12">
                <label for="WriteNote" class="form-label">{{$t('global.distinctive_mark')}}</label>
                <textarea class="form-control border-2" rows="4" cols="4" :placeholder="$t('global.distinctive_mark')" v-model="v$.data.distinctive_mark.$model"
                    :class="{
                        'is-invalid': v$.data.distinctive_mark.$error || errors[`distinctive_mark`],
                        'is-valid': !v$.data.distinctive_mark.$invalid && !errors[`distinctive_mark`]
                    }"></textarea>
                    <div class="invalid-feedback">
                    </div>
                    <template v-if="errors[`distinctive_mark`]">
                        <error-message v-for="(errorMessage, index) in errors[`distinctive_mark`]" :key="index">
                            {{ errorMessage }}
                        </error-message>
                    </template>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-dark py-2 rounded-3" @click.prevent="AddSubmit" v-if="!loading" >{{ t('global.Add Address') }}</button>
                <button class="btn btn-dark py-2 rounded-3 btn-loader" style="cursor: not-allowed" disabled v-else>
                    <span class="me-2">{{ $t('auth.Loading') }}</span>
                    <span class="loading"><i class="ri-loader-2-fill fs-16"></i></span>
                </button>
            </div>
        </div><!--end row-->
    </div>
</template>

<script>
import { computed, reactive, ref, toRefs, onMounted, nextTick } from "vue";
import { alphaNum,  email,  maxLength, minLength, required, numeric} from "@vuelidate/validators";
import useVuelidate from "@vuelidate/core";
import webApi from "../../api/webAxios";
import { useI18n } from "vue-i18n";


export default {
    name: "AddAddressForm",
    props: {
        setting: {default: ''},
        user: {default: ''},
    },
    components:{
    },
    setup(props) {

        const errors = ref([]);
        let loading = ref(false);
        const { t } = useI18n({});
        let countries = ref([]);
        let areas = ref([]);

         onMounted(() => {
            getCountries();
            getAreas();
        });

        let getCountries = async () => {
            try {
                const response = await webApi.get(`/web/countries`);
                countries.value = response.data.data;
            } catch (error) {
                console.error("Error fetching countries:", error);
            }
        };

        let getAreas = async () => {
            try {
                const response = await webApi.get(`/web/areas`);
                areas.value = response.data.data;
            } catch (error) {
                console.error("Error fetching areas:", error);
            }
        };

        let submitdata = reactive({
            data: {
                title: '',
                country_id: 1,
                address: '',
                area_id: '',
                building_number: '',
                floor_number: '',
                apartment_number: '',
                distinctive_mark: '',
            },
        });

        const rules = computed(() => {
            return {
                data: {
                    title: {
                        minLength: minLength(2),
                        maxLength: maxLength(70),
                        required,
                    },
                    country_id: {
                        required,
                    },
                    address: {
                        required,
                    },
                    area_id: {
                        required,
                    },
                    building_number: {
                    },
                    floor_number: {
                    },
                    apartment_number: {
                    },
                    distinctive_mark: {
                    },
                }
            }
        });

        const v$ = useVuelidate(rules, submitdata);

        return { v$, ...toRefs(submitdata), loading, errors, t ,areas,countries}
    },
    methods: {

        AddSubmit() {
            this.v$.$validate();
            this.errors = {};

            if (!this.v$.$error) {

                let formData = new FormData();
                formData.append(`title`, this.data.title);
                formData.append(`country_id`, this.data.country_id);
                formData.append(`address`, this.data.address);
                formData.append(`area_id`, this.data.area_id);
                formData.append(`building_number`, this.data.building_number);
                formData.append(`floor_number`, this.data.floor_number);
                formData.append(`apartment_number`, this.data.apartment_number);
                formData.append(`distinctive_mark`, this.data.distinctive_mark);
                formData.append(`is_primary`, 1);

                this.loading = true;
                webApi.post(`/web/add-address`, formData)
                    .then((res) => {

                        Swal.fire({
                            icon: 'success',
                            title: res.data.message,
                            showConfirmButton: false,
                            timer: 3000
                        });

                        this.data =  {
                            title: '',
                            country_id: 1,
                            address: '',
                            area_id: '',
                            building_number: '',
                            floor_number: '',
                            apartment_number: '',
                            distinctive_mark: '',
                        };

                        this.errors =  [];


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
                         this.$emit("created");
                    });
            } else {
                this.loading = false;
            }
        }
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
