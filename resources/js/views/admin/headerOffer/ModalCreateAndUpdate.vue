<template>
    <div class="modal fade" id="banner-modal" tabindex="-1"
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

                        <div class="col-md-12 mt-3" v-if="data.ar" v-for="lang in languages">
                            <label class="form-label">{{ $t('label.description') }} ({{lang.title}})</label>
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


                        <div class="col-md-6 mt-2">
                            <div class="custom-toggle-switch d-flex align-items-center my-4 ">
                                <input id="toggleswitchPrimary" v-model="data.status" type="checkbox">
                                <label for="toggleswitchPrimary" class="label-primary"></label><span class="ms-3">{{ $t('label.status') }}</span>
                            </div>
                            <template v-if="errors['status']">
                                <error-message v-for="(errorMessage, index) in errors['status']" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>


<!--                        <div class="col-md-12 mt-3 row flex-fill">-->
<!--                            <div class="btn btn-outline-light waves-effect"  style="width: 90%; height:90%">-->

<!--                                <span v-if="type != 'edit' && !numberOfImage"  style="width: 90%; height: 90%; margin-top: 30%">-->
<!--                                    {{$t('global.ChooseImages')}}-->
<!--                                    <br><i class="bi bi-cloud-upload fs-40" ></i>-->
<!--                                    <i class="fas fa-cloud-upload-alt ml-3" aria-hidden="true"></i>-->
<!--                                </span>-->

<!--                                <div id="container-images" v-show="image &&numberOfImage"></div>-->

<!--                                <div  v-if="type == 'edit'" v-show="!numberOfImage">-->
<!--                                    <figure>-->
<!--                                        <figcaption>-->
<!--                                            <img class="img-fluid rounded" style="max-width: 150px; height: 150px" :src="`${imageUpload}`">-->
<!--                                        </figcaption>-->
<!--                                    </figure>-->
<!--                                </div>-->
<!--                                <input name="mediaPackage" type="file" @change="preview" id="mediaPackage" accept="image/*">-->

<!--                                <template v-if="errors['file']">-->
<!--                                    <error-message v-for="(errorMessage, index) in errors['file']" :key="index">-->
<!--                                        {{ errorMessage }}-->
<!--                                    </error-message>-->
<!--                                </template>-->
<!--                                    <template class="text-danger text-center" v-if="requiredn">-->
<!--                                        <error-message>{{$t('global.ImagesIsMustHaveAtLeast1Photos')}}<br /></error-message>-->
<!--                                    </template>-->
<!--                            </div>-->
<!--                            <p class="num-of-files">{{numberOfImage ? numberOfImage + $t('global.FilesSelected') : $t('global.NoFilesChosen') }}</p>-->

<!--                            <template v-if="errors[`image`]">-->
<!--                                <error-message v-for="(errorMessage, index) in errors[`image`]" :key="index">-->
<!--                                    {{ errorMessage }}-->
<!--                                </error-message>-->
<!--                            </template>-->
<!--                        </div>-->


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
import {computed, onMounted, reactive, ref, toRefs, nextTick} from "vue";
import {useI18n} from "vue-i18n";
import {maxLength, minLength, required} from "@vuelidate/validators";
import useVuelidate from "@vuelidate/core";
import adminApi from "../../../api/adminAxios";

export default {
    name: "brand-modal-create-and-update",
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
            let myModalEl = document.getElementById('banner-modal')
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
               submitdata.data[el.code]={description:'',};
               langValidation.value[el.code] ={
                   description: {minLength: minLength(1),required,},
               }
           });

           submitdata.data.date = '';
           submitdata.data.status = true;
           is_disabled.value = false;
           errors.value = [];
        }
       function resetModal() {
            defaultData();
            setTimeout(async () => {
                if (props.type != 'edit') {
                } else {
                    id.value = props.dataRow.id;
                    adminApi.get(`dashboard/header-offers/${id.value}`)
                    .then((res) => {
                        loading.value = true;
                        let l = res.data.data;
                        l.translations.forEach((el)=>{
                            submitdata.data[el.locale]={
                                description:el.description,
                            }
                        });
                        submitdata.data.status = l.status==1;
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
                status: true,
            }
        });

        const rules = computed(() => {
            return {
                ...langValidation.value,
            }
        });

        const v$ = useVuelidate(rules,submitdata.data);

        return {t,id,
            loading,is_disabled,languages,
            resetModal,resetModalHidden,
            ...toRefs(submitdata),
            v$,errors};
    },
    methods: {
        AddSubmit() {

        this.v$.$validate();
        this.errors = {};

        let formData = new FormData();

        this.languages.forEach((el)=>{
           formData.append(`translations[${el.code}][description]`, this.data[el.code].description);
       })
        formData.append('status', this.data.status ? 1 : 0);
        if (this.type !== 'edit') {
            if (!this.v$.$error) {
                this.is_disabled = false;
                this.loading = true;
                adminApi.post(`dashboard/header-offers`, formData)
                    .then((res) => {
                        Swal.fire({
                            icon: 'success',
                            description: `${this.t('global.AddedSuccessfully')}`,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        this.resetModalHidden();
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
            adminApi.post(`dashboard/header-offers/${this.id}`,formData)
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

</style>
