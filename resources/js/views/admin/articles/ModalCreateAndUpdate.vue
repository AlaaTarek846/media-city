<template>
    <div class="modal fade" id="areas" tabindex="-1"
         aria-labelledby="exampleModalLgLabel" aria-hidden="true" >
        <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
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

                            <Editor ref="descRef" v-model="data[lang.code].description"/>

<!--                            <textarea-->
<!--                                class="form-control summernote"-->
<!--                                rows="6"-->
<!--                                v-model.trim="v$[lang.code].description.$model"-->
<!--                                :class="{'is-invalid': v$[lang.code].description.$error ||errors[`translations.${lang.code}.description`],-->
<!--                                'is-valid':!v$[lang.code].description.$invalid && !errors[`translations.${lang.code}.description`]}">-->
<!--                            </textarea>-->
                            <div class="invalid-feedback">
                            </div>
                            <template v-if="errors[`translations.${lang.code}.description`]">
                                <error-message v-for="(errorMessage, index) in errors[`translations.${lang.code}.description`]" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>

                        <!-- Slug Field -->
                        <div class="col-md-6 mt-3" v-if="data.ar" v-for="lang in languages">
                            <label class="form-label">
                                <i class="ri-link me-1"></i>
                                {{ $t('label.slug') }} ({{lang.title}})
                            </label>
                            <input type="text" class="form-control" v-model="data[lang.code].slug"
                                   :placeholder="$t('label.slug') + ' ' + lang.title"
                                   :class="{'is-invalid': errors[`translations.${lang.code}.slug`], 'is-valid': !errors[`translations.${lang.code}.slug`]}">
                            <small class="form-text text-muted">
                                <i class="ri-information-line me-1"></i>
                                {{ $t('label.slugHint') }}
                            </small>
                            <template v-if="errors[`translations.${lang.code}.slug`]">
                                <error-message v-for="(errorMessage, index) in errors[`translations.${lang.code}.slug`]" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>

                        <!-- Keywords Field with Tabs -->
                        <div class="col-md-12 mt-3" v-if="data.ar" v-for="lang in languages">
                            <label class="form-label mb-3">
                                <i class="ri-keyword-line me-1"></i>
                                {{ $t('label.keywords') }} ({{lang.title}})
                                <span class="badge bg-success-transparent ms-2" v-if="data[lang.code]?.keywords?.length">
                                    {{ $t('label.bestKeywords') }}
                                </span>
                            </label>

                            <!-- Tabs -->
                            <ul class="nav nav-tabs keywords-tabs mb-3" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" :id="`keywords-tab-${lang.code}`" data-bs-toggle="tab"
                                            :data-bs-target="`#keywords-pane-${lang.code}`" type="button" role="tab">
                                        <i class="ri-keyword-line me-1"></i>
                                        {{ $t('label.keywordTab') }}
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" :id="`suggestions-tab-${lang.code}`" data-bs-toggle="tab"
                                            :data-bs-target="`#suggestions-pane-${lang.code}`" type="button" role="tab">
                                        <i class="ri-lightbulb-line me-1"></i>
                                        {{ $t('label.suggestionsTab') }}
                                    </button>
                                </li>
                            </ul>

                            <!-- Tab Content -->
                            <div class="tab-content keywords-tab-content">
                                <!-- Keywords Input Tab -->
                                <div class="tab-pane fade show active" :id="`keywords-pane-${lang.code}`" role="tabpanel">
                                    <div class="keywords-input-wrapper">
                                        <input type="text" class="form-control keywords-input"
                                               v-model="keywordsInput[lang.code]"
                                               :placeholder="$t('label.keywordsPlaceholder')"
                                               @blur="updateKeywords(lang.code)"
                                               @keyup.enter="addKeywordFromInput(lang.code)">
                                        <button type="button" class="btn btn-sm btn-primary ms-2" @click="addKeywordFromInput(lang.code)">
                                            <i class="ri-add-line"></i> {{ $t('label.addKeyword') }}
                                        </button>
                                    </div>

                                    <!-- Keywords Tags Display -->
                                    <div class="keywords-tags mt-3" v-if="data[lang.code]?.keywords?.length">
                                        <span class="badge bg-primary-transparent keywords-badge me-2 mb-2"
                                              v-for="(keyword, index) in data[lang.code].keywords" :key="index">
                                            {{ keyword }}
                                            <button type="button" class="btn-close btn-close-white ms-1"
                                                    @click="removeKeyword(lang.code, index)"
                                                    style="font-size: 0.6rem;"></button>
                                        </span>
                                    </div>

                                    <small class="form-text text-muted d-block mt-2">
                                        <i class="ri-information-line me-1"></i>
                                        {{ $t('label.keywordsHint') }}
                                    </small>
                                </div>

                                <!-- Suggestions Tab -->
                                <div class="tab-pane fade" :id="`suggestions-pane-${lang.code}`" role="tabpanel">
                                    <div class="suggested-keywords-wrapper">
                                        <p class="text-muted mb-3">
                                            <i class="ri-lightbulb-line me-1"></i>
                                            {{ $t('label.suggestedKeywords') }}
                                        </p>
                                        <div class="suggested-keywords-list">
                                            <button type="button"
                                                    class="btn btn-sm btn-outline-primary me-2 mb-2 suggested-keyword-btn"
                                                    v-for="(suggestion, index) in getSuggestedKeywords(lang.code)"
                                                    :key="index"
                                                    @click="addSuggestedKeyword(lang.code, suggestion)">
                                                <i class="ri-add-line me-1"></i>
                                                {{ suggestion }}
                                                <span class="badge bg-success ms-1" v-if="isBestKeyword(suggestion)">
                                                    <i class="ri-star-fill"></i>
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <template v-if="errors[`translations.${lang.code}.keywords`]">
                                <error-message v-for="(errorMessage, index) in errors[`translations.${lang.code}.keywords`]" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>


                        <div class="col-md-6 mt-3">
                            <label class="form-label">{{ $t('global.selectCategory') }}</label>

                            <Select v-model="data.category_id" :filterFields="['id','title']" :options="categories" filter
                                    :invalid="v$.category_id.$error || errors[`category_id`]"
                                    optionLabel="title" optionValue="id"
                                    :class="['w-full w-100', { 'is-invalid': v$.category_id.$error || errors[`category_id`], 'is-valid': !v$.category_id.$invalid && !errors[`category_id`] }]">

                            </Select>
                            <div class="invalid-feedback">
                                <span v-if="v$.category_id.required.$invalid">{{
                                        $t('global.ThisFieldIsRequired') }}<br />
                                </span>
                            </div>
                            <template v-if="errors['category_id']">
                                <error-message v-for="(errorMessage, index) in errors['category_id']" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>

                        <!-- Tags Field -->
                        <div class="col-md-6 mt-3">
                            <label class="form-label">
                                <i class="ri-price-tag-3-line me-1"></i>
                                {{ $t('label.tags') }}
                            </label>
                            <Select v-model="data.tags" :options="tags" filter multiple
                                    optionLabel="name" optionValue="id"
                                    :placeholder="$t('label.selectTags')"
                                    :class="['w-full w-100', { 'is-invalid': errors['tags'], 'is-valid': !errors['tags'] }]">
                            </Select>
                            <div class="mt-2">
                                <div class="input-group">
                                    <input type="text" class="form-control" v-model="newTagName"
                                           :placeholder="$t('label.addNewTag')"
                                           @keyup.enter="addNewTag">
                                    <button type="button" class="btn btn-primary" @click="addNewTag">
                                        <i class="ri-add-line me-1"></i>
                                        {{ $t('global.add') }} {{ $t('label.tag') }}
                                    </button>
                                </div>
                            </div>
                            <template v-if="errors['tags']">
                                <error-message v-for="(errorMessage, index) in errors['tags']" :key="index">
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

                        <p class="mt-3">{{$t('global.ChooseImages')}} (ع 700 * ط 500)</p>
                        <div class="col-md-12 mt-3 row flex-fill">
                            <div class="btn btn-outline-light waves-effect"  style="width: 90%; height:90%">

                                <span v-if="type != 'edit' && !numberOfImage"  style="width: 90%; height: 90%; margin-top: 30%">
                                    {{$t('global.ChooseImages')}}
                                    <br><i class="bi bi-cloud-upload fs-40" ></i>
                                    <i class="fas fa-cloud-upload-alt ml-3" aria-hidden="true"></i>
                                </span>

                                <div id="container-images" v-show="image &&numberOfImage"></div>

                                <div  v-if="type == 'edit'" v-show="!numberOfImage">
                                    <figure>
                                        <figcaption>
                                            <img class="img-fluid rounded" style="max-width: 150px; height: 150px" :src="`${imageUpload}`">
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
import {maxLength, minLength, required,numeric} from "@vuelidate/validators";
import useVuelidate from "@vuelidate/core";
import adminApi from "../../../api/adminAxios";
import Editor from 'primevue/editor';

export default {
    name: "ModalCreateAndUpdate",
    props: {
        type: {default: 'create'},
        dataRow: {default: ''},
    },
    components: {
        Editor
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
        let categories = ref([]);
        let tags = ref([]);
        const descRef = ref(null);
        const keywordsInput = ref({});
        const newTagName = ref('');

        let getCategories = () => {
            loading.value = true;

            adminApi.get(`dashboard/articles/categories`)
                .then((res) => {
                    let l = res.data.data;
                    categories.value = l;
                })
                .catch((err) => {
                    console.log(err.response.data);
                })
                .finally(() => {
                    loading.value = false;
                })
        }

        let getTags = () => {
            adminApi.get(`dashboard/articles/tags`)
                .then((res) => {
                    tags.value = res.data.data || [];
                })
                .catch((err) => {
                    console.log(err.response.data);
                })
        }

        let addNewTag = () => {
            if (!newTagName.value.trim()) return;

            adminApi.post(`dashboard/articles/tags`, { name: newTagName.value })
                .then((res) => {
                    tags.value.push(res.data.data);
                    if (!submitdata.data.tags) submitdata.data.tags = [];
                    submitdata.data.tags.push(res.data.data.id);
                    newTagName.value = '';
                })
                .catch((err) => {
                    console.log(err.response.data);
                })
        }

        let updateKeywords = (locale) => {
            if (!submitdata.data[locale]) submitdata.data[locale] = {};
            if (keywordsInput.value[locale]) {
                const keywords = keywordsInput.value[locale].split(',').map(k => k.trim()).filter(k => k);
                submitdata.data[locale].keywords = keywords;
            }
        }

        let addKeywordFromInput = (locale) => {
            if (!submitdata.data[locale]) submitdata.data[locale] = {};
            if (!submitdata.data[locale].keywords) submitdata.data[locale].keywords = [];

            if (keywordsInput.value[locale]) {
                const newKeywords = keywordsInput.value[locale].split(',').map(k => k.trim()).filter(k => k);
                newKeywords.forEach(keyword => {
                    if (keyword && !submitdata.data[locale].keywords.includes(keyword)) {
                        submitdata.data[locale].keywords.push(keyword);
                    }
                });
                keywordsInput.value[locale] = '';
            }
        }

        let removeKeyword = (locale, index) => {
            if (submitdata.data[locale]?.keywords) {
                submitdata.data[locale].keywords.splice(index, 1);
            }
        }

        let getSuggestedKeywords = (locale) => {
            const title = submitdata.data[locale]?.title || '';
            const description = submitdata.data[locale]?.description || '';
            const text = (title + ' ' + description).toLowerCase();

            // استخراج كلمات من العنوان والوصف
            const words = text.split(/\s+/).filter(w => w.length > 3);
            const uniqueWords = [...new Set(words)];

            // كلمات مفتاحية شائعة للمقالات
            const commonKeywords = locale === 'ar'
                ? ['ذهب', 'مجوهرات', 'خواتم', 'أساور', 'قلائد', 'أطقم', 'سبائك', 'استثمار', 'عناية', 'صيانة']
                : ['gold', 'jewelry', 'rings', 'bracelets', 'necklaces', 'sets', 'bars', 'investment', 'care', 'maintenance'];

            // دمج الكلمات المستخرجة مع الكلمات الشائعة
            const suggestions = [...uniqueWords.slice(0, 10), ...commonKeywords];
            return [...new Set(suggestions)].slice(0, 15);
        }

        let isBestKeyword = (keyword) => {
            // كلمات مفتاحية ممتازة
            const bestKeywords = ['ذهب', 'مجوهرات', 'gold', 'jewelry', 'استثمار', 'investment'];
            return bestKeywords.includes(keyword.toLowerCase());
        }

        let addSuggestedKeyword = (locale, keyword) => {
            if (!submitdata.data[locale]) submitdata.data[locale] = {};
            if (!submitdata.data[locale].keywords) submitdata.data[locale].keywords = [];

            if (!submitdata.data[locale].keywords.includes(keyword)) {
                submitdata.data[locale].keywords.push(keyword);
            }
        }

        let empty = () => {
            numberOfImage.value = 0;
            let clearInput = document.querySelector('#mediaPackage').value = '';
            requiredn.value = false;
        }

        onMounted(()=>{
            languages.value=JSON.parse(localStorage.getItem('languages'));
        });

       function defaultData(){

           languages.value.forEach((el)=>{
               submitdata.data[el.code]={title:'',description:'',slug:'',keywords:[]};
               keywordsInput.value[el.code] = '';
               langValidation.value[el.code] ={
                   title: {minLength: minLength(1),maxLength:maxLength(40),required,},
                    description: {},

               }
           });
           submitdata.data.category_id = '';
           submitdata.data.tags = [];
           submitdata.data.status = true;
           imageUpload.value = '';
           image.value=null
           is_disabled.value = false;
           loading.value = false;
           empty();
           errors.value = [];
           newTagName.value = '';
        }
       function resetModal() {
            defaultData();
           getCategories();
           getTags();
            setTimeout(async () => {
                if (props.type != 'edit') {
                } else {
                    id.value = props.dataRow.id;

                adminApi.get(`dashboard/articles/${id.value}`)
                    .then((res) => {
                        loading.value = true;
                        let l = res.data.data;
                        l.translations.forEach((el)=>{
                            submitdata.data[el.locale]={
                                title:el.title,
                                description:el.description,
                                slug:el.slug || '',
                                keywords:el.keywords || []
                            };
                            keywordsInput.value[el.locale] = (el.keywords || []).join(', ');
                        });
                        submitdata.data.category_id = l.category_id;
                        submitdata.data.tags = l.tags || [];
                        submitdata.data.status = l.status == 1;
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
                category_id: '',
                status: true,

            }
        });
        const numberOfImage = ref(0);
        const image = ref({});
        const imageUpload = ref({});



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
                img.style.maxWidth = '150px';
                img.style.height = '150px';
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
                category_id: {required},
            }
        });

        const v$ = useVuelidate(rules,submitdata.data);





        return {t,id,categories,tags,newTagName,keywordsInput,imageUpload,image,descRef, loading,is_disabled,languages,empty,preview,resetModal,resetModalHidden,getTags,addNewTag,updateKeywords,addKeywordFromInput,removeKeyword,getSuggestedKeywords,isBestKeyword,addSuggestedKeyword,...toRefs(submitdata), v$,errors,numberOfImage,requiredn};
    },
    methods: {
        AddSubmit() {

        this.v$.$validate();
        this.errors = {};

        let formData = new FormData();
       this.languages.forEach((el)=>{
           formData.append(`translations[${el.code}][title]`, this.data[el.code].title);
            formData.append(`translations[${el.code}][description]`, this.data[el.code].description);
            if (this.data[el.code].slug) {
                formData.append(`translations[${el.code}][slug]`, this.data[el.code].slug);
            }
            if (this.data[el.code].keywords && this.data[el.code].keywords.length > 0) {
                this.data[el.code].keywords.forEach((keyword, index) => {
                    formData.append(`translations[${el.code}][keywords][${index}]`, keyword);
                });
            }
       })
        formData.append('category_id', this.data.category_id);
        if (this.data.tags && this.data.tags.length > 0) {
            this.data.tags.forEach((tagId, index) => {
                formData.append(`tags[${index}]`, tagId);
            });
        }
        formData.append('status', this.data.status ? 1 : 0);
        if (this.image) {
            formData.append('image', this.image);
        }
        if (this.type !== 'edit') {
            if (!this.v$.$error && this.numberOfImage) {
                this.is_disabled = false;
                this.loading = true;
                adminApi.post(`dashboard/articles`, formData)
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
            else {
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
            adminApi.post(`dashboard/articles/${this.id}`,formData)
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

/* Keywords Styles */
.keywords-tabs {
    border-bottom: 2px solid #e9ecef;
}

.keywords-tabs .nav-link {
    color: #6c757d;
    border: none;
    border-bottom: 2px solid transparent;
    padding: 0.75rem 1.5rem;
    transition: all 0.3s ease;
}

.keywords-tabs .nav-link:hover {
    color: #0d6efd;
    border-bottom-color: #0d6efd;
}

.keywords-tabs .nav-link.active {
    color: #0d6efd;
    border-bottom-color: #0d6efd;
    font-weight: 600;
}

.keywords-tab-content {
    min-height: 200px;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 0.375rem;
    border: 1px solid #e9ecef;
}

.keywords-input-wrapper {
    display: flex;
    gap: 0.5rem;
    align-items: flex-start;
}

.keywords-input {
    flex: 1;
}

.keywords-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    padding: 0.75rem;
    background: #fff;
    border-radius: 0.375rem;
    border: 1px solid #dee2e6;
    min-height: 60px;
}

.keywords-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
    border-radius: 0.375rem;
    cursor: default;
}

.suggested-keywords-wrapper {
    padding: 1rem;
}

.suggested-keywords-list {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.suggested-keyword-btn {
    transition: all 0.3s ease;
    border-radius: 0.375rem;
}

.suggested-keyword-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.suggested-keyword-btn .badge {
    font-size: 0.7rem;
    padding: 0.2rem 0.4rem;
}

/* Responsive */
@media (max-width: 768px) {
    .keywords-input-wrapper {
        flex-direction: column;
    }

    .keywords-input-wrapper .btn {
        width: 100%;
    }
}
</style>
