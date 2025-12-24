<template>
    <div class="modal fade" id="language-modal" tabindex="-1"
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

                        <div class="col-md-6" v-if="type == 'create'">
                            <label class="form-label">{{ $t('label.title') }} </label>
                            <input type="text" class="form-control"  v-model="v$.title.$model"
                                   :placeholder="$t('label.title')"
                                   :class="{'is-invalid': v$.title.$error || errors[`translations.${data.code}.title`],
                                   'is-valid': !v$.title.$invalid && !errors[`translations.${data.code}.title`]}">

                            <div class="invalid-feedback">
                                <span v-if="v$.title.required.$invalid">{{ $t('validation.fieldRequired') }}<br /> </span>
                                <span v-if="v$.title.minLength.$invalid">{{ $t('validation.TitleIsMustHaveAtLeast') }} {{
                                        v$.title.minLength.$params.min
                                    }} {{ $t('validation.Letters') }} <br />
                                </span>
                                <span v-if="v$.title.maxLength.$invalid">{{ $t('validation.TitleIsMustHaveAtMost') }} {{
                                        v$.title.maxLength.$params.max
                                    }} {{ $t('validation.Letters') }}
                                </span></div>
                            <template v-if="data.code && errors[`translations.${data.code}.title`]">
                                <error-message v-for="(errorMessage, index) in errors[`translations.${data.code}.title`]" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>

                        <div class="col-md-6" v-if="type == 'create'">
                            <label class="form-label">{{ $t('label.description') }} </label>
                            <textarea
                                class="form-control summernote"
                                rows="2"
                                v-model.trim="v$.description.$model"
                                :class="{'is-invalid': v$.description.$error ||errors[`translations.${data.code}.description`],
                                'is-valid':!v$.description.$invalid && !errors[`translations.${data.code}.description`]}">
                            </textarea>
                            <div class="invalid-feedback">
                                <span v-if="v$.description.required.$invalid">{{ $t('validation.fieldRequired') }}<br /> </span>
                            </div>
                            <template v-if="errors[`translations.${data.code}.description`]">
                                <error-message v-for="(errorMessage, index) in errors[`translations.${data.code}.description`]" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>



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

                        <div class="col-md-6" v-if="data.ar" v-for="lang in languages">
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
                        <div class="col-md-6">
                            <label class="form-label">{{ $t('global.code') }}</label>
                            <input type="text" class="form-control" v-model="v$.code.$model"
                                :placeholder="$t('global.code')" :class="{
                                    'is-invalid': v$.code.$error || errors[`code`],
                                    'is-valid': !v$.code.$invalid && !errors[`code`]
                                }">

                            <div class="invalid-feedback">
                                <span v-if="v$.code.required.$invalid">{{ $t('validation.fieldRequired') }}<br />
                                </span>

                            </div>
                            <template v-if="errors[`code`]">
                                <error-message v-for="(errorMessage, index) in errors[`code`]" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>
                        <div class="col-md-6 mt-4">
                            <div class="custom-toggle-switch d-flex align-items-center mb-4">
                                <input id="toggleswitchPrimary" v-model="data.status" type="checkbox">
                                <label for="toggleswitchPrimary" class="label-primary"></label><span class="ms-3">{{ $t('label.status') }}</span>
                            </div>
                            <template v-if="errors['status']">
                                <error-message v-for="(errorMessage, index) in errors['status']" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>

                        <div class="col-md-12 mt-3 row flex-fill">
                            <div class="btn btn-outline-light waves-effect"  style="width: 90%; height:90%">

                                <span v-if="type != 'edit' && !numberOfImage"  style="margin-top:30%;">
                                    {{$t('global.ChooseImages')}}
                                    <br><i class="bi bi-cloud-upload fs-40" ></i>
                                    <i class="fas fa-cloud-upload-alt ml-3" aria-hidden="true"></i>
                                </span>

                                <div id="container-images" v-show="image &&numberOfImage"></div>

                                <div  v-if="type == 'edit'" v-show="!numberOfImage">
                                    <figure>
                                        <figcaption>
                                            <img class="img-fluid rounded" :src="`${imageUpload}`">
                                        </figcaption>
                                    </figure>
                                </div>
                                <input name="mediaPackage" type="file" @change="preview" id="mediaPackage" accept="image/*">

                                <template v-if="errors['file']">
                                    <error-message v-for="(errorMessage, index) in errors['file']" :key="index">
                                        {{ errorMessage }}
                                    </error-message>
                                </template>
                                    <template class="text-danger text-center" v-if="requiredn">
                                        <error-message>{{$t('global.ImagesIsMustHaveAtLeast1Photos')}}<br /></error-message>
                                    </template>
                            </div>
                            <p class="num-of-files">{{numberOfImage ? numberOfImage + $t('global.FilesSelected') : $t('global.NoFilesChosen') }}</p>

                            <template v-if="errors[`image`]">
                                <error-message v-for="(errorMessage, index) in errors[`image`]" :key="index">
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
import {maxLength, minLength, required, requiredIf} from "@vuelidate/validators";
import useVuelidate from "@vuelidate/core";
import adminApi from "../../../api/adminAxios";

export default {
    name: "Language",
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
            let myModalEl = document.getElementById('language-modal')
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
               submitdata.data[el.code]={title:'',description:'',};
               langValidation.value[el.code] ={
                   title: {minLength: minLength(1),maxLength:maxLength(40),required,},
                   description: {required}
               }
           });
           submitdata.data.code = '';
           submitdata.data.title = '';
           submitdata.data.description = '';
           submitdata.data.status = true;
           imageUpload.value = '';
           is_disabled.value = false;
           loading.value = false;
           image.value=null
           errors.value = [];
           empty();
        }
       function resetModal() {
            defaultData();
            setTimeout(async () => {
                if (props.type != 'edit') {
                } else {
                    id.value = props.dataRow.id;

                adminApi.get(`dashboard/language/${id.value}`)
                    .then((res) => {
                        loading.value = true;
                        let l = res.data.data;
                        l.translations.forEach((el)=>{
                            submitdata.data[el.locale]={
                                title:el.title,
                                description:el.description,
                            }
                        });
                        submitdata.data.code = l.code;
                        submitdata.data.status = parseInt(l.status) == 1;
                        imageUpload.value = l.image;
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
                code:'',
                title:'',
                description:'',
            }
        });

        const numberOfImage = ref(0);
        const image = ref({});
        const imageUpload = ref({});

        let empty = () => {
            numberOfImage.value = 0;
            let clearInput = document.querySelector('#mediaPackage').value = '';
            requiredn.value = false;
        }

        let preview = (e) => {

            let containerImages = document.querySelector('#container-images');
            containerImages.innerHTML = '';
            image.value = {};

            numberOfImage.value = e.target.files.length;

            image.value = e.target.files[0];

            let reader = new FileReader();
            let figure = document.createElement('figure');
            let figcap = document.createElement('figcaption');

            figcap.innerText = image.value.name;
            figure.appendChild(figcap);

            reader.onload = () => {
                let img = document.createElement('img');
                img.setAttribute('src',reader.result);
                img.classList.add('img-fluid', 'rounded');
                figure.insertBefore(img,figcap);
            }

            containerImages.appendChild(figure);
            reader.readAsDataURL(image.value);


        }

        // validation image
        const requiredn = ref(false);

        watch(numberOfImage, (count, prevCount) => {
            if(!count){
                requiredn.value = true;
            }else {
                requiredn.value = false;
            }
        });

        const rules = computed(() => {
            return {
                ...langValidation.value,
                code: {required},
                title: {minLength: minLength(1),maxLength:maxLength(40),required:requiredIf(() => props.type == 'create'),},
                description: {required:requiredIf(() => props.type == 'create'),},
            }
        });

        const v$ = useVuelidate(rules,submitdata.data);

        return {t,id,
            loading,is_disabled,languages,
            resetModal,empty,preview,resetModalHidden,
            imageUpload,image,...toRefs(submitdata),
            v$,numberOfImage,requiredn,errors};
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
       if(this.type == 'create'){
        formData.append(`translations[${this.data.code}][title]`, this.data.title);
        formData.append(`translations[${this.data.code}][description]`, this.data.description);
       }

        formData.append('status', this.data.status ? 1 : 0);
        formData.append('code', this.data.code ?? '');
        if (this.image) {
            formData.append('flag', this.image);
        }
        if (this.type !== 'edit') {
            if (!this.v$.$error && this.numberOfImage) {
                this.is_disabled = false;
                this.loading = true;
                adminApi.post(`dashboard/language`, formData)
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
            } else {
                if(!this.numberOfImage){
                        this.loading = false;
                        this.is_disabled = false;
                        this.requiredn = true;
                }
            }
        }else if(!this.v$.$error) {
            this.is_disabled = false;
            this.loading = true;
            formData.append('_method','PUT');
            adminApi.post(`dashboard/language/${this.id}`,formData)
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
