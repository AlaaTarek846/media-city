<template>
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <h1 class="page-title fw-semibold fs-18 mb-0">{{ $t('global.aboutUs') }}</h1>
            <div class="ms-md-1 ms-0">
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><router-link :to="{name: 'dashboard'}">{{$t('global.home')}}</router-link></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $t('global.aboutUs') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- Page Header Close -->
        <div class="card custom-card">
            <div class="card-body">
                <div class="row">

                    <div class="col-md-12 mt-3" v-if="data.ar" v-for="lang in languages">
                        <label class="form-label">{{ $t('label.description') }} ({{lang.title}})</label>

                        <Editor ref="descRef" v-model="data[lang.code].description"/>

                        <div class="invalid-feedback">
                            <span v-if="v$[lang.code].description.required.$invalid">{{ $t('validation.fieldRequired') }}<br /> </span>
                        </div>
                        <template v-if="errors[`translations.${lang.code}.description`]">
                            <error-message v-for="(errorMessage, index) in errors[`translations.${lang.code}.description`]" :key="index">
                                {{ errorMessage }}
                            </error-message>
                        </template>
                    </div>

                    <div class="col-md-12 mt-3 row flex-fill">
                        <div class="btn btn-outline-light waves-effect"  style="width: 90%; height:90%">

                            <div id="container-images" v-show="image &&numberOfImage"></div>

                            <div v-show="!numberOfImage">
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
import Editor from 'primevue/editor';

export default {
    name: "joinUs",
    data(){
        return {
            errors:{}
        }
    },
    components: {
        Editor
    },
    setup(){
        const errors = ref([]);
        let loading = ref(false);
        const {t} = useI18n({});
        const id = ref(1);
        const languages = ref([]);
        const langValidation = ref({});
        const descRef = ref(null);

        function defaultData(){
            languages.value.forEach((el)=>{
               submitdata.data[el.code]={title:'',description:'',};
               langValidation.value[el.code] ={
                   title: {},
                   description: {required}
               }
           });
           loading.value = false;
           errors.value = [];
           imageUpload.value = '';
           image.value=null;
           empty();
        }
       function resetModal() {
            defaultData();
            setTimeout(async () => {
                adminApi.get(`dashboard/about-us/${id.value}`)
                    .then((res) => {
                        loading.value = true;
                        let l = res.data.data;
                        l.translations.forEach((el , index)=>{
                            submitdata.data[el.locale]={
                                title:el.title,
                                description:el.description,
                            }
                        });
                        imageUpload.value = l.image
                    })
                    .catch((err) => {
                        console.log(err);
                    })
                    .finally(() => {
                        loading.value = false;

                        descRef.value.forEach((el)=>{
                                const delta = el.quill.clipboard.convert({ html: el.modelValue })
                                el.quill.setContents(delta, 'silent');
                            });
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

            }
        });

        const v$ = useVuelidate(rules,submitdata.data);

        return {t,id,loading,languages,empty,preview,imageUpload,image,numberOfImage,requiredn,resetModal,descRef,...toRefs(submitdata),v$,errors};

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
            formData.append('_method','PUT');
        if (this.image) {
            formData.append('image', this.image);
        }
        if(!this.v$.$error) {
            this.loading = true;
            adminApi.post(`dashboard/about-us/${this.id}`,formData)
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

