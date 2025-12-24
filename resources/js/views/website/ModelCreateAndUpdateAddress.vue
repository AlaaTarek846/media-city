<template>
       <!-- Add New address Modal -->
    <div class="modal fade" id="AddNewAddressModal" tabindex="-1">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header px-4">
            <h1 class="modal-title fs-5">{{ type == 'create' ? $t('global.Add new Address') : $t('global.Edit Address') }}</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body p-4">
             <div class="form-floating mb-3">
              <input type="text" class="form-control" id="floatingPinCode" v-model="v$.data.title.$model"
                    :class="{
                        'is-invalid': v$.data.title.$error || errors[`title`],
                        'is-valid': !v$.data.title.$invalid && !errors[`title`]
                    }">
              <label for="floatingPinCode">{{ $t('global.nameAddress') }}</label>
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
            <div class="form-floating mb-3">
              <textarea class="form-control" rows="4" cols="4" id="floatingAddress" v-model="v$.data.address.$model"
                    :class="{
                        'is-invalid': v$.data.address.$error || errors[`address`],
                        'is-valid': !v$.data.address.$invalid && !errors[`address`]
                    }"></textarea>
              <label for="floatingAddress">{{ $t('global.address') }}</label>
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
           <div class="row mt-3">
             <div class="col">
               <div class="form-floating">
                  <select class="form-select" id="SelectCountry" v-model="v$.data.country_id.$model"
                    :class="{
                        'is-invalid': v$.data.country_id.$error || errors[`country_id`],
                        'is-valid': !v$.data.country_id.$invalid && !errors[`country_id`]
                    }">
                    <option v-for="country in countries" :key="country.id" :value="country.id">{{ country.title }}</option>
                </select>
                <label for="floatingAddress">{{ $t('global.Select Country') }}</label>
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
             </div>
             <div class="col">
               <div class="form-floating">
                 <select class="form-select" id="SelectArea" v-model="v$.data.area_id.$model"
                    :class="{
                        'is-invalid': v$.data.area_id.$error || errors[`area_id`],
                        'is-valid': !v$.data.area_id.$invalid && !errors[`area_id`]
                    }">
                    <option v-for="area in areas" :key="area.id" :value="area.id">{{ area.title }}</option>
                </select>
                <label for="floatingState">{{ $t('global.selectArea') }}</label>
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
             </div>
            </div>
            <div class="row mt-3">
             <div class="col">
               <div class="form-floating">
                 <input type="text" class="form-control" id="building_number" v-model="v$.data.building_number.$model"
                    :class="{
                        'is-invalid': v$.data.building_number.$error || errors[`building_number`],
                        'is-valid': !v$.data.building_number.$invalid && !errors[`building_number`]
                    }">
                 <label for="building_number">{{$t('global.building_number')}}</label>
                 <div class="invalid-feedback">
                </div>
                <template v-if="errors[`building_number`]">
                    <error-message v-for="(errorMessage, index) in errors[`building_number`]" :key="index">
                        {{ errorMessage }}
                    </error-message>
                </template>
               </div>
             </div>
             <div class="col">
               <div class="form-floating">
                 <input type="text" class="form-control" id="floatingState" v-model="v$.data.floor_number.$model"
                    :class="{
                        'is-invalid': v$.data.floor_number.$error || errors[`floor_number`],
                        'is-valid': !v$.data.floor_number.$invalid && !errors[`floor_number`]
                    }">
                 <label for="floatingState">{{$t('global.floor_number')}}</label>
                 <div class="invalid-feedback">
                </div>
                <template v-if="errors[`floor_number`]">
                    <error-message v-for="(errorMessage, index) in errors[`floor_number`]" :key="index">
                        {{ errorMessage }}
                    </error-message>
                </template>
               </div>
             </div>
            </div>

            <div class="row mt-3">
             <div class="col">
               <div class="form-floating">
                 <input type="text" class="form-control" id="apartment_number" v-model="v$.data.apartment_number.$model"
                    :class="{
                        'is-invalid': v$.data.apartment_number.$error || errors[`apartment_number`],
                        'is-valid': !v$.data.apartment_number.$invalid && !errors[`apartment_number`]
                    }">
                 <label for="apartment_number">{{$t('global.apartment_number')}}</label>
                 <div class="invalid-feedback">
                </div>
                <template v-if="errors[`apartment_number`]">
                    <error-message v-for="(errorMessage, index) in errors[`apartment_number`]" :key="index">
                        {{ errorMessage }}
                    </error-message>
                </template>
               </div>
             </div>
             <div class="col">
               <div class="form-floating">
                 <input type="text" class="form-control" id="distinctive_mark" v-model="v$.data.distinctive_mark.$model"
                    :class="{
                        'is-invalid': v$.data.distinctive_mark.$error || errors[`distinctive_mark`],
                        'is-valid': !v$.data.distinctive_mark.$invalid && !errors[`distinctive_mark`]
                    }">
                 <label for="distinctive_mark">{{$t('global.distinctive_mark')}}</label>
                 <div class="invalid-feedback">
                    </div>
                    <template v-if="errors[`distinctive_mark`]">
                        <error-message v-for="(errorMessage, index) in errors[`distinctive_mark`]" :key="index">
                            {{ errorMessage }}
                        </error-message>
                    </template>
               </div>
             </div>
            </div>
            <div class="col-md-6 mt-2">
                <div class="custom-toggle-switch d-flex align-items-center my-4 ">
                    <input id="toggleswitchPrimary" class="form-check-input" v-model="data.is_primary" type="checkbox">
                    <label for="toggleswitchPrimary" class="form-check-label"></label><span class="ms-3">{{ $t('global.make this Address primary') }}</span>
                </div>
                <template v-if="errors['is_primary']">
                    <error-message v-for="(errorMessage, index) in errors['is_primary']" :key="index">
                        {{ errorMessage }}
                    </error-message>
                </template>
            </div>

         </div>
          <div class="modal-footer px-4">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal" >{{$t('global.close')}}</button>
            <button type="button" class="btn btn-dark"  @click.prevent="AddSubmit" v-if="!loading" >{{$t('global.Save changes')}}</button>
            <button class="btn btn-dark py-2 rounded-3 btn-loader" style="cursor: not-allowed" disabled v-else>
                <span class="me-2">{{ $t('auth.Loading') }}</span>
                <span class="loading"><i class="ri-loader-2-fill fs-16"></i></span>
            </button>
          </div>
        </div>
      </div>
    </div>
    <!-- Add New address Modal -->
</template>

<script>
import { computed, reactive, ref, toRefs, onMounted, nextTick } from "vue";
import { alphaNum,  email,  maxLength, minLength, required, numeric} from "@vuelidate/validators";
import useVuelidate from "@vuelidate/core";
import webApi from "../../api/webAxios";
import { useI18n } from "vue-i18n";


export default {
    name: "ModelCreateAndUpdateAddress",
    props: {
        type: {default: 'create'},
        dataRow: {default: ''},
    },
    components:{
    },
    setup(props) {
         setTimeout(async () => {
            let myModalEl = document.getElementById('AddNewAddressModal')
            myModalEl.addEventListener('show.bs.modal', function (event) {
                resetModal();
            })
            myModalEl.addEventListener('hidden.bs.modal', function (event) {
                resetModalHidden();
            })
        }, 150);

        const errors = ref([]);
        let loading = ref(false);
        const { t } = useI18n({});
        const id = ref(null);
        let countries = ref([]);
        let areas = ref([]);

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

        function defaultData(){
           submitdata.data.title = '';
           submitdata.data.country_id = 1;
           submitdata.data.address = '';
           submitdata.data.area_id = '';
           submitdata.data.building_number = '';
           submitdata.data.floor_number = '';
           submitdata.data.apartment_number = '';
           submitdata.data.distinctive_mark = '';
           submitdata.data.is_primary = true;

           loading.value = false;
           errors.value = [];
        }
       function resetModal() {
            defaultData();
            setTimeout(async () => {
                getCountries();
                getAreas();
                if (props.type != 'edit') {
                } else {
                    id.value = props.dataRow.id;
                    submitdata.data.title = props.dataRow.title;
                    submitdata.data.country_id = props.dataRow.country_id;
                    submitdata.data.address = props.dataRow.address;
                    submitdata.data.area_id = props.dataRow.area_id;
                    submitdata.data.building_number = props.dataRow.building_number;
                    submitdata.data.floor_number = props.dataRow.floor_number;
                    submitdata.data.apartment_number = props.dataRow.apartment_number;
                    submitdata.data.distinctive_mark = props.dataRow.distinctive_mark;
                    submitdata.data.is_primary = props.dataRow.is_primary == 1;
                }
            }, 50);
        }
       function resetModalHidden()
        {
            defaultData();
            nextTick(() => { v$.value.$reset() });
        }

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
                is_primary: true,
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

        return { v$, ...toRefs(submitdata), loading, errors, t ,areas,countries,id}
    },
    methods: {

        AddSubmit() {
            this.v$.$validate();
            this.errors = {};
             let formData = new FormData();
                formData.append(`title`, this.data.title);
                formData.append(`country_id`, this.data.country_id);
                formData.append(`address`, this.data.address);
                formData.append(`area_id`, this.data.area_id);
                formData.append(`building_number`, this.data.building_number);
                formData.append(`floor_number`, this.data.floor_number);
                formData.append(`apartment_number`, this.data.apartment_number);
                formData.append(`distinctive_mark`, this.data.distinctive_mark);
                formData.append(`is_primary`, this.data.is_primary ? 1 : 0);

            if (this.type !== 'edit') {
                if (!this.v$.$error) {
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
            }else if(!this.v$.$error){
                this.is_disabled = false;
                this.loading = true;
                formData.append('_method','PUT');
                webApi.post(`/web/edit-address/${this.id}`,formData)
                    .then((res) => {
                        Swal.fire({
                            icon: 'success',
                            title: res.data.message,
                            showConfirmButton: false,
                            timer: 3000
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
                        this.$emit("created");
                    });

            }
        }
    }
}
</script>