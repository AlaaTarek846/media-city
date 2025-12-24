<template>
    <div class="modal fade" id="areas" tabindex="-1"
         aria-labelledby="exampleModalLgLabel" aria-hidden="true" >
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLgLabel">
                        {{type == 'create' ? $t('global.add') : $t('global.update')}}
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
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
                                <span v-if="v$[lang.code].title.maxLength.$invalid">{{ $t('validation.TitleIsMustHaveAtMost') }} {{
                                        v$[lang.code].title.maxLength.$params.max
                                    }} {{ $t('validation.Letters') }}
                                </span></div>
                            <template v-if="errors[`translations.${lang.code}.title`]">
                                <error-message v-for="(errorMessage, index) in errors[`translations.${lang.code}.title`]" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>

                        <div class="col-md-6 mt-3" v-if="data.ar" v-for="lang in languages">
                            <label class="form-label">{{ $t('label.description') }} ({{lang.title}})</label>
                            <textarea
                                class="form-control summernote"
                                rows="6"
                                v-model.trim="v$[lang.code].description.$model"
                                :class="{'is-invalid': v$[lang.code].description.$error ||errors[`translations.${lang.code}.description`],
                                'is-valid':!v$[lang.code].description.$invalid && !errors[`translations.${lang.code}.description`]}">
                            </textarea>
                            <div class="invalid-feedback">
                            </div>
                            <template v-if="errors[`translations.${lang.code}.description`]">
                                <error-message v-for="(errorMessage, index) in errors[`translations.${lang.code}.description`]" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>

                          <div class="col-md-6 mt-3">
                            <label for="code" class="form-label"  >{{ $t('global.code') }}</label>
                            <button  @click="generateCode" class="btn btn-sm btn-success-light mx-5">{{ $t('global.generateCode') }}</button>
                            <input type="text" class="form-control"
                                   v-model.trim="v$.code.$model"
                                   id="code"
                                   :placeholder="$t('global.code')"
                                   :class="{'is-invalid': v$.code.$error ||errors[`code`], 'is-valid':!v$.code.$invalid && !errors[`code`]}"
                            >

                            <div class="invalid-feedback">
                                <span v-if="v$.code.required.$invalid">{{ $t('validation.fieldRequired') }}<br /> </span>
                                <span v-if="v$.code.minLength.$invalid">{{ $t('validation.TitleIsMustHaveAtLeast') }} {{ v$.code.minLength.$params.min}} {{ $t('validation.Letters') }} <br />
                                </span>
                            </div>
                             <template v-if="errors['code']">
                                <error-message v-for="(errorMessage, index) in errors['code']" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>

                        <div class="col-md-6 mt-3">
                            <label for="type" class="form-label"  >{{ $t('global.type') }}</label>
                            <select class="form-select" v-model.trim="v$.type.$model" id="type"
                            :class="{'is-invalid': v$.type.$error ||errors[`type`], 'is-valid':!v$.type.$invalid && !errors[`type`]}"
                            >
                                <option value="fixed">{{$t('global.Fixed')}}</option>
                                <option value="percentage">{{$t('global.Percentage')}}</option>
                            </select>

                            <div class="invalid-feedback">
                                <span v-if="v$.type.required.$invalid">{{ $t('validation.fieldRequired') }}<br /> </span>
                            </div>
                            <template v-if="errors['type']">
                                <error-message v-for="(errorMessage, index) in errors['type']" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>

                        <div class="col-md-6 mt-3">
                            <label for="value" class="form-label"  >{{ $t('global.value') }}</label>
                            <input type="number" class="form-control"
                                   v-model.trim="v$.value.$model"
                                   id="value"
                                   :placeholder="$t('global.value')"
                                   :class="{'is-invalid': v$?.value.$error || errors['value'], 'is-valid': !v$?.value.$invalid  && !errors['value']}"
                            >

                            <div class="invalid-feedback">
                                 <span v-if="v$?.value?.required?.$invalid">{{ $t('validation.fieldRequired') }}<br /> </span>
                            </div>
                            <template v-if="errors['value']">
                                <error-message v-for="(errorMessage, index) in errors['value']" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="user_count" class="form-label"  >{{ $t('global.user_count') }}</label>
                            <input type="text" class="form-control" v-model.trim="v$.user_count.$model" id="user_count" :placeholder="$t('global.user_count')"
                                   :class="{'is-invalid': v$?.user_count.$error  || errors['user_count'], 'is-valid': !v$?.user_count.$invalid && !errors['user_count']}"
                            >

                            <div class="invalid-feedback">
                                <span v-if="v$?.user_count?.required?.$invalid">{{ $t('validation.fieldRequired') }}<br /> </span>
                            </div>
                            <template v-if="errors['user_count']">
                                <error-message v-for="(errorMessage, index) in errors['user_count']" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="start_date" class="form-label"  >{{ $t('global.start_date') }}</label>
                            <input type="date" class="form-control"
                                   v-model.trim="data.start_date"
                                   id="start_date"
                                   :placeholder="$t('global.start_date')"
                                   :class="{'is-invalid': v$?.start_date.$error  || errors['start_date'], 'is-valid': !v$?.start_date.$invalid && !errors['start_date']}"
                            >

                            <div class="invalid-feedback">
                            </div>
                            <template v-if="errors['start_date']">
                                <error-message v-for="(errorMessage, index) in errors['start_date']" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="expire_date" class="form-label"  >{{ $t('global.expire_date') }}</label>
                            <input type="date" class="form-control"
                                   v-model.trim="data.expire_date"
                                   id="expire_date"
                                   :placeholder="$t('global.expire_date')"
                                   :class="{'is-invalid': v$?.expire_date.$error  || errors['expire_date'], 'is-valid': !v$?.expire_date.$invalid && !errors['expire_date']}"
                            >

                            <div class="invalid-feedback">
                            </div>
                            <template v-if="errors['expire_date']">
                                <error-message v-for="(errorMessage, index) in errors['expire_date']" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="greater_than" class="form-label"  >{{ $t('global.greater_than') }}</label>
                            <input type="number" class="form-control"
                                   v-model.trim="data.greater_than"
                                   id="greater_than"
                                   :placeholder="$t('global.greater_than')"
                                   :class="{'is-invalid': v$?.greater_than.$error  || errors['greater_than'], 'is-valid': !v$?.greater_than.$invalid && !errors['greater_than']}"
                            >

                            <div class="invalid-feedback">
                            </div>
                            <template v-if="errors['greater_than']">
                                <error-message v-for="(errorMessage, index) in errors['greater_than']" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>

                         <div class="col-md-6 mt-4">
                            <div class="custom-toggle-switch d-flex align-items-center mt-4">
                                <input id="toggleswitchPrimary" v-model="data.status" type="checkbox">
                                <label for="toggleswitchPrimary" class="label-primary"></label><span class="ms-3">{{ $t('label.status') }}</span>
                            </div>
                            <template v-if="errors['status']">
                                <error-message v-for="(errorMessage, index) in errors['status']" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button v-if="type != 'edit'" :disabled="!is_disabled"
                            @click.prevent="resetModal" type="button" class="btn btn-secondary">{{$t('global.AddNewRecord')}}</button>
                    <template v-if="!is_disabled">
                        <button type="submit" v-if="!loading" @click.prevent="AddSubmit" class="btn btn-primary">{{ $t('global.Submit') }}</button>

                        <button class="btn btn-primary btn-loader" v-else>
                            <span class="me-2">{{$t('global.Loading')}}</span>
                            <span class="loading"><i class="ri-loader-2-fill fs-16"></i></span>
                        </button>
                    </template>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {computed, onMounted, reactive, ref, toRefs, watch,nextTick} from "vue";
import {useI18n} from "vue-i18n";
import {maxLength, minLength, required,numeric} from "@vuelidate/validators";
import useVuelidate from "@vuelidate/core";
import adminApi from "../../../api/adminAxios";

export default {
    name: "ModalCreateAndUpdate",
    props: {
        type: {default: 'create'},
        dataRow: {default: ''},
    },
    data(){
        return {
            errors:{}
        }
    },
    setup(props){
        setTimeout(async () => {
            let myModalEl = document.getElementById('areas')
            myModalEl.addEventListener('show.bs.modal', function (event) {
                resetModal();
            })
            myModalEl.addEventListener('hidden.bs.modal', function (event) {
                resetModalHidden();
            })
        }, 150);
        const errors = ref([]);
        const languages = ref([]);
        const langValidation = ref({});
        let loading = ref(false);
        let is_disabled = ref(false);
        const {t} = useI18n({});
        const id = ref(null);

        onMounted(()=>{
            languages.value=JSON.parse(localStorage.getItem('languages'));
        });

       function defaultData(){

           languages.value.forEach((el)=>{
               submitdata.data[el.code]={title:'',description:''};
               langValidation.value[el.code] ={
                   title: {minLength: minLength(1),maxLength:maxLength(40),required,},
                    description: {},

               }
           });
           submitdata.data.type = '';
           submitdata.data.code = '';
            submitdata.data.value = '';
            submitdata.data.user_count = '';
              submitdata.data.start_date = '';
            submitdata.data.expire_date = '';
            submitdata.data.greater_than = 0;
           submitdata.data.status = true;
           is_disabled.value = false;
           loading.value = false;
           errors.value = [];
        }
       function resetModal() {
            defaultData();
            setTimeout(async () => {
                if (props.type != 'edit') {
                } else {
                    id.value = props.dataRow.id;

                adminApi.get(`dashboard/discount-coupon/${id.value}`)
                    .then((res) => {
                        loading.value = true;
                        let l = res.data.data;
                        l.translations.forEach((el)=>{
                            submitdata.data[el.locale]={
                                title:el.title,
                                description:el.description
                            }
                        });
                        submitdata.data.code = l.code;
                        submitdata.data.type = l.type;
                        submitdata.data.value = l.value;
                        submitdata.data.user_count = l.user_count;
                        submitdata.data.start_date = l.start_date;
                        submitdata.data.expire_date = l.expire_date;
                        submitdata.data.greater_than = l.greater_than;
                        submitdata.data.status = l.status == 1;
                    })
                    .catch((err) => {
                        console.log(err);
                    })
                    .finally(() => {
                        loading.value = false;
                    })
                }
            }, 50);
        }
       function resetModalHidden()
        {
            defaultData();
            nextTick(() => { v$.value.$reset() });
        }

        //start design
        let submitdata =  reactive({
            data:{
                code: '',
                type: '',
                value: '',
                user_count: '',
                start_date: '',
                expire_date: '',
                greater_than: 0,
                status: true,

            }
        });

        const rules = computed(() => {
            return {
                ...langValidation.value,
                code: {required, minLength: minLength(8)},
                type: {required},
                value: {required, numeric},
                user_count: {required, numeric},
                start_date: {},
                expire_date: {},
                greater_than: {numeric},
            }
        });

        const v$ = useVuelidate(rules,submitdata.data);

        function generateRandomString(length) {
            const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            let result = '';
            for (let i = 0; i < length; i++) {
                const randomIndex = Math.floor(Math.random() * characters.length);
                result += characters.charAt(randomIndex);
            }
            return result;
      }

       function generateCode (){
            submitdata.data.code = generateRandomString(10)
        };

        return {t,id,generateCode, loading,is_disabled,languages,resetModal,resetModalHidden,...toRefs(submitdata), v$,errors};
    },
    methods: {
        AddSubmit() {

        this.v$.$validate();
        this.errors = {};

        let formData = new FormData();
       this.languages.forEach((el)=>{
           formData.append(`translations[${el.code}][title]`, this.data[el.code].title);
            formData.append(`translations[${el.code}][description]`, this.data[el.code].description);
       })
        formData.append('code', this.data.code);
        formData.append('type', this.data.type);
        formData.append('value', this.data.value);
        formData.append('user_count', this.data.user_count);
        formData.append('start_date', this.data.start_date);
        formData.append('expire_date', this.data.expire_date);
        formData.append('greater_than', this.data.greater_than);
        formData.append('status', this.data.status ? 1 : 0);
        if (this.type !== 'edit') {
            if (!this.v$.$error) {
                this.is_disabled = false;
                this.loading = true;
                adminApi.post(`dashboard/discount-coupon`, formData)
                    .then((res) => {
                        Swal.fire({
                            icon: 'success',
                            title: `${this.t('global.AddedSuccessfully')}`,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    })
                    .catch((err) => {
                        this.errors = err.response.data.errors;
                    })
                    .finally(() => {
                        if (Object.keys(this.errors).length === 0) {
                                this.loading = false;
                                this.is_disabled = true;
                                this.$emit("created");
                        } else {
                            this.loading = false;
                            this.is_disabled = false;
                        }
                    });
            }
        }else if(!this.v$.$error) {
            this.is_disabled = false;
            this.loading = true;
            formData.append('_method','PUT');
            adminApi.post(`dashboard/discount-coupon/${this.id}`,formData)
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
                    this.$emit("created");
                });
        }

}
    }
}
</script>

<style scoped>
.coustom-select {
    height: 100px;
}
.card{
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

.ml-3{
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

.num-of-files{
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
</style>
