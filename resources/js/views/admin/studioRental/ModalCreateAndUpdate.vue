<template>
    <div class="modal fade" id="page" tabindex="-1"
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
                            </div>
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
                                <span v-if="v$[lang.code].description.required.$invalid">{{ $t('validation.fieldRequired') }}<br /> </span>
                            </div>
                            <template v-if="errors[`translations.${lang.code}.description`]">
                                <error-message v-for="(errorMessage, index) in errors[`translations.${lang.code}.description`]" :key="index">
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

                        <div class="col-md-12 mt-3 row flex-fill">
                            <div class="btn btn-outline-light waves-effect" style="width: 90%; height:90%">
                                <span v-if="type != 'edit' && !numberOfImageUpload" style="width: 90%; height: 90%; margin-top: 30%">
                                    {{ $t('global.ChooseImages') }}
                                    <br><i class="bi bi-cloud-upload fs-40"></i>
                                    <i class="fas fa-cloud-upload-alt ml-3" aria-hidden="true"></i>
                                </span>

                                <div id="container-images-group" v-show="imagesGroup && imagesGroup.length > 0"></div>

                                <div v-if="type == 'edit'" v-show="!numberOfImageUpload && existingImages && existingImages.length > 0">
                                    <div class="d-flex flex-wrap gap-2">
                                        <figure v-for="(img, index) in existingImages" :key="index" style="position: relative; display: inline-block;">
                                            <img class="img-fluid rounded" style="max-width: 150px; height: 150px" :src="img.image" alt="">
                                            <button v-if="getTotalImagesCount() > 1" type="button" @click.prevent="removeExistingImage(index)" class="btn btn-sm btn-danger" style="position: absolute; top: 5px; right: 5px;">
                                                <i class="ri-close-line"></i>
                                            </button>
                                        </figure>
                                    </div>
                                </div>
                                <input v-if="getTotalImagesCount() < 4" name="mediaPackageUpload" type="file" @change="previewGroup" id="mediaPackageUpload" accept="image/*" multiple>

                                <template v-if="errors['images']">
                                    <error-message v-for="(errorMessage, index) in errors['images']" :key="index">
                                        {{ errorMessage }}
                                    </error-message>
                                </template>
                            </div>
                            <p class="num-of-files">{{ numberOfImageUpload ? numberOfImageUpload + ' ' + $t('global.FilesSelected') : $t('global.NoFilesChosen') }}</p>
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
    name: "studioRental",
    props: {
        type: {default: 'create'},
        dataRow: {default: ''}
    },
    data(){
        return {
            errors:{}
        }
    },
    setup(props){
        setTimeout(async () => {
            let myModalEl = document.getElementById('page')
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
        const types = ref([]);
        
        // Images
        const numberOfImageUpload = ref(0);
        const imagesGroup = ref([]);
        const existingImages = ref([]);
        const deletedImages = ref([]);

        onMounted(()=>{
            const storedLanguages = localStorage.getItem('languages');
            if (storedLanguages) {
                try {
                    languages.value = JSON.parse(storedLanguages) || [];
                } catch (e) {
                    console.error('Error parsing languages from localStorage:', e);
                    languages.value = [];
                }
            } else {
                languages.value = [];
            }
            // Initialize data on mount
            defaultData();
        });

       function defaultData(){
           if (!languages.value || !Array.isArray(languages.value) || languages.value.length === 0) {
               const storedLanguages = localStorage.getItem('languages');
               if (storedLanguages) {
                   try {
                       languages.value = JSON.parse(storedLanguages) || [];
                   } catch (e) {
                       console.error('Error parsing languages from localStorage:', e);
                       languages.value = [];
                   }
               } else {
                   languages.value = [];
               }
           }
           
           // Reset langValidation
           langValidation.value = {};
           
           if (languages.value && languages.value.length > 0) {
               languages.value.forEach((el)=>{
                   if (el && el.code) {
                       submitdata.data[el.code] = {title:'',description:'',};
                       langValidation.value[el.code] = {
                           title: {minLength: minLength(1),required,},
                           description: {required}
                       }
                   }
               });
           }
           submitdata.data.status = true;
           is_disabled.value = false;
           loading.value = false;
           errors.value = [];
           empty();
        }
        let getTypesAndModel = () => {
            loading.value = true;

            adminApi.get(`dashboard/page/enums`)
                .then((res) => {
                    let l = res.data.data;
                    types.value = l.types;
                })
                .catch((err) => {
                    console.log(err.response.data);
                })
                .finally(() => {
                    loading.value = false;
                })
        }
       function resetModal() {
            if (!languages.value || !Array.isArray(languages.value) || languages.value.length === 0) {
                languages.value = JSON.parse(localStorage.getItem('languages')) || [];
            }
            defaultData();
            setTimeout(async () => {
                getTypesAndModel();
                if (props.type != 'edit') {
                } else {
                    id.value = props.dataRow.id;

                adminApi.get(`dashboard/studio-rentals/${id.value}`)
                    .then((res) => {
                        loading.value = true;
                        if (res && res.data && res.data.data) {
                            let l = res.data.data;
                            if (l.translations && Array.isArray(l.translations)) {
                                l.translations.forEach((el)=>{
                                    if (el && el.locale) {
                                        submitdata.data[el.locale]={
                                            title:el.title || '',
                                            description:el.description || '',
                                        }
                                    }
                                });
                            }
                            if (l.status !== undefined) {
                                submitdata.data.status = l.status == 1;
                            }
                            if (l.images && Array.isArray(l.images)) {
                                existingImages.value = l.images;
                            }
                        }
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
            nextTick(() => { 
                if (v$.value && typeof v$.value.$reset === 'function') {
                    v$.value.$reset();
                }
            });
        }

        // Empty function for compatibility (if needed by other components)
        let empty = () => {
            // This function can be used to clear image uploads or other fields if needed
            // Check if elements exist before accessing them to prevent null errors
            try {
                let mediaPackage = document.querySelector('#mediaPackageUpload');
                if (mediaPackage && mediaPackage !== null) {
                    mediaPackage.value = '';
                }
            } catch (e) {
                // Element doesn't exist, which is fine - ignore the error
                console.log('empty() function: mediaPackageUpload element not found, skipping');
            }
            numberOfImageUpload.value = 0;
            imagesGroup.value = [];
            existingImages.value = [];
            deletedImages.value = [];
        }

        let previewGroup = (e) => {
            let containerImages = document.querySelector('#container-images-group');
            if (!containerImages) return;
            
            // If files are selected, add them to imagesGroup
            if (e.target.files && e.target.files.length > 0) {
                Array.from(e.target.files).forEach((file) => {
                    if (!imagesGroup.value.find(img => img.name === file.name && img.size === file.size)) {
                        imagesGroup.value.push(file);
                    }
                });
            }
            
            // Rebuild preview
            containerImages.innerHTML = '';
            numberOfImageUpload.value = imagesGroup.value.length;

            imagesGroup.value.forEach((file, index) => {
                let reader = new FileReader();
                let figure = document.createElement('figure');

                reader.onload = () => {
                    let img = document.createElement('img');
                    img.setAttribute('src', reader.result);
                    img.style.width = '100px';
                    img.style.height = '100px';
                    img.style.borderRadius = '5px';
                    img.style.objectFit = 'cover';
                    figure.appendChild(img);
                };

                figure.style.display = 'inline-block';
                figure.style.margin = '10px';
                figure.style.position = 'relative';

                // Add remove button only if total count > 1
                const totalCount = (existingImages.value ? existingImages.value.length : 0) + imagesGroup.value.length;
                if (totalCount > 1) {
                    let removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.className = 'btn btn-sm btn-danger';
                    removeBtn.style.position = 'absolute';
                    removeBtn.style.top = '5px';
                    removeBtn.style.right = '5px';
                    removeBtn.innerHTML = '<i class="ri-close-line"></i>';
                    removeBtn.onclick = () => {
                        imagesGroup.value.splice(index, 1);
                        numberOfImageUpload.value = imagesGroup.value.length;
                        // Rebuild preview after removal
                        let container = document.querySelector('#container-images-group');
                        if (container) {
                            container.innerHTML = '';
                            imagesGroup.value.forEach((f, idx) => {
                                let r = new FileReader();
                                let fig = document.createElement('figure');
                                r.onload = () => {
                                    let im = document.createElement('img');
                                    im.setAttribute('src', r.result);
                                    im.style.width = '100px';
                                    im.style.height = '100px';
                                    im.style.borderRadius = '5px';
                                    im.style.objectFit = 'cover';
                                    fig.appendChild(im);
                                };
                                fig.style.display = 'inline-block';
                                fig.style.margin = '10px';
                                fig.style.position = 'relative';
                                const newTotalCount = (existingImages.value ? existingImages.value.length : 0) + imagesGroup.value.length;
                                if (newTotalCount > 1) {
                                    let btn = document.createElement('button');
                                    btn.type = 'button';
                                    btn.className = 'btn btn-sm btn-danger';
                                    btn.style.position = 'absolute';
                                    btn.style.top = '5px';
                                    btn.style.right = '5px';
                                    btn.innerHTML = '<i class="ri-close-line"></i>';
                                    btn.onclick = () => {
                                        imagesGroup.value.splice(idx, 1);
                                        numberOfImageUpload.value = imagesGroup.value.length;
                                        previewGroup({target: {files: []}});
                                    };
                                    fig.appendChild(btn);
                                }
                                container.appendChild(fig);
                                r.readAsDataURL(f);
                            });
                        }
                    };
                    figure.appendChild(removeBtn);
                }

                containerImages.appendChild(figure);
                reader.readAsDataURL(file);
            });
        }

        let removeExistingImage = (index) => {
            if (existingImages.value[index] && existingImages.value[index].id) {
                deletedImages.value.push(existingImages.value[index].id);
            }
            existingImages.value.splice(index, 1);
        }

        // Calculate total images count (existing + new - deleted)
        let getTotalImagesCount = () => {
            const existingCount = existingImages.value ? existingImages.value.length : 0;
            const newCount = imagesGroup.value ? imagesGroup.value.length : 0;
            return existingCount + newCount;
        }

        //start design
        let submitdata =  reactive({
            data:{
                status: true,
            }
        });

        const rules = computed(() => {
            return {
                ...(langValidation.value || {}),

            }
        });

        const v$ = useVuelidate(rules,submitdata.data);

        return {t,id,
            loading,is_disabled,languages,types,
            resetModal,resetModalHidden,empty,
            numberOfImageUpload,imagesGroup,existingImages,deletedImages,
            previewGroup,removeExistingImage,getTotalImagesCount,
            ...toRefs(submitdata),
            v$,errors};
    },
    methods: {
        AddSubmit() {

        this.v$.$validate();
        this.errors = {};

        let formData = new FormData();
       if (this.languages && Array.isArray(this.languages) && this.languages.length > 0) {
           this.languages.forEach((el)=>{
               if (this.data[el.code]) {
                   formData.append(`translations[${el.code}][title]`, this.data[el.code].title || '');
                   formData.append(`translations[${el.code}][description]`, this.data[el.code].description || '');
               }
           });
       }
        formData.append('status', this.data.status ? 1 : 0);
        
        // Add new images
        this.imagesGroup.forEach((image, index) => {
            formData.append(`images[${index}]`, image);
        });
        
        // Add deleted images IDs (for edit mode)
        if (this.type === 'edit' && this.deletedImages && this.deletedImages.length > 0) {
            this.deletedImages.forEach((imageId, index) => {
                formData.append(`deleted_images[${index}]`, imageId);
            });
        }
        if (this.type !== 'edit') {
            if (!this.v$.$error) {
                this.is_disabled = false;
                this.loading = true;
                adminApi.post(`dashboard/studio-rentals`, formData)
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
            adminApi.post(`dashboard/studio-rentals/${this.id}`,formData)
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
