<template>
    <div class="modal fade" id="category-service" tabindex="-1"
         aria-labelledby="exampleModalLgLabel" aria-hidden="true" >
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLgLabel">
                        {{type == 'create' ? $t('global.add') : $t('global.update')}}
                    </h6>
                    <a type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
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
                                <span v-if="v$[lang.code].description.required.$invalid">{{ $t('validation.fieldRequired') }}<br /> </span>
                            </div>
                            <template v-if="errors[`translations.${lang.code}.description`]">
                                <error-message v-for="(errorMessage, index) in errors[`translations.${lang.code}.description`]" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>

                        <div class="col-md-4 mt-3">
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

                        <div class="col-md-3 mt-3">
                            <label class="form-label">{{ $t('global.selectBrand') }}</label>

                            <Select v-model="data.brand_id" :filterFields="['id','title']" :options="brands" filter
                                    :invalid="v$.brand_id.$error || errors[`brand_id`]"
                                        optionLabel="title" optionValue="id"
                                    :class="['w-full w-100', { 'is-invalid': v$.brand_id.$error || errors[`brand_id`], 'is-valid': !v$.brand_id.$invalid && !errors[`brand_id`] }]">

                            </Select>
                            <div class="invalid-feedback">
                                <span v-if="v$.brand_id.required.$invalid">{{
                                        $t('global.ThisFieldIsRequired') }}<br />
                                </span>
                            </div>
                            <template v-if="errors['brand_id']">
                                <error-message v-for="(errorMessage, index) in errors['brand_id']" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>

                         <div class="col-md-3 mt-3">
                            <label class="form-label">{{ $t('global.selectProductType') }}</label>

                            <div class="card-body d-sm-flex align-items-center">
                                 <div class="form-check form-check-md">
                                    <input class="form-check-input" type="radio" v-model="data.type" id="Radio-md" value="standard" checked>
                                    <label class="form-check-label" for="Radio-md">
                                        {{ $t('global.standard') }}
                                    </label>
                                </div>
                                <div class="form-check form-check-md mx-4">
                                    <input class="form-check-input" type="radio" v-model="data.type" id="Radio-md" value="variant">
                                    <label class="form-check-label" for="Radio-md">
                                        {{ $t('global.variant') }}
                                    </label>
                                </div>
                            </div>

                            <div class="invalid-feedback">
                                <span v-if="v$.brand_id.required.$invalid">{{
                                        $t('global.ThisFieldIsRequired') }}<br />
                                </span>
                            </div>
                            <template v-if="errors['brand_id']">
                                <error-message v-for="(errorMessage, index) in errors['brand_id']" :key="index">
                                    {{ errorMessage }}
                                </error-message>
                            </template>
                        </div>

                        <div class="col-md-2 mt-5">
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

                        <div class="row">

                             <div class="col-md-6 mt-3">

                                <h4 class="text-center"> {{ $t("global.mainPhoto") }}</h4>

                                <div class="btn btn-outline-light waves-effect"  style="width: 100%; height:300px; overflow: hidden; display: flex; align-items: center; justify-content: center;">

                                    <span v-if="type != 'edit' && !numberOfImage"  style="text-align: center">
                                        {{$t('global.ChooseImages')}}
                                        <br><i class="bi bi-cloud-upload fs-40" ></i>
                                        <i class="fas fa-cloud-upload-alt ml-3" aria-hidden="true"></i>
                                    </span>

                                    <div id="container-images" v-show="image &&numberOfImage"></div>

                                    <div  v-if="type == 'edit'" v-show="!numberOfImage">
                                        <figure  style="margin: 0">
                                            <figcaption>
                                                <img class="img-fluid rounded" style="max-width: 250px; height: 250px" :src="`${imageUpload}`">
                                            </figcaption>
                                        </figure>
                                    </div>
                                    <input name="mediaPackage" type="file" @change="preview" id="mediaPackage" accept="image/*">
                                    <template v-if="requiredn">
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

                             <div class="col-md-6 mt-3">

                                <h4 class="text-center"> {{ $t("global.productPhotos") }} </h4>

                                <div class="btn btn-outline-light waves-effect" style=" width: 100%; height: 300px; overflow-y: auto; display: flex; align-items: flex-start; justify-content: center; flex-wrap: wrap;">

                                    <span v-if="type != 'edit' && !numberOfImageUpload" style="margin-top: 20%; text-align: center">
                                        {{ $t("global.ChooseImages") }}
                                        <br />
                                        <i class="bi bi-cloud-upload fs-40"></i>
                                        <i class="fas fa-cloud-upload-alt ml-3" aria-hidden="true" ></i>
                                    </span>

                                    <div id="container-images-group" v-show="imagesGroup && numberOfImageUpload" ></div>

                                    <div v-if="type == 'edit'" v-show="!numberOfImageUpload" >
                                        <figure v-for="( imagePath, index ) in imagesGroup" :key="index" style="display: inline-block; margin: 10px;">
                                            <img class="img-fluid rounded" :src="imagePath" alt="Other Photo" style="width: 100px; height: 100px; border-radius: 5px;"/>
                                        </figure>
                                    </div>
                                    <input name="mediaPackageUpload" multiple type="file" @change="previewGroup" id="mediaPackageUpload" accept="image/*" />
                                </div>

                                <span class="text-danger text-center" v-if="requiredn">{{ $t("global.ImagesIsMustHaveAtLeast1Photos")}} <br/> </span>
                                <template v-if="errors['fileGroup']">
                                    <error-message v-for="(errorMessage, index) in errors['fileGroup']" :key="index">
                                        {{ errorMessage }}
                                    </error-message>
                                </template>
                            </div>

                        </div>

                        <div class="row ">
                            <h4 class="text-center">{{ $t('global.ProductFeatures') }}</h4>
                            <div class="col-md-6 mt-3" v-if="data.ar" v-for="lang in languages">
                                <label class="form-label">{{ $t('global.productFeature') }} ({{lang.title}})</label>

                                <Editor ref="descRef" v-model="data[lang.code].feature"/>

                                <div class="invalid-feedback">
                                    <span v-if="v$[lang.code].feature.required.$invalid">{{ $t('validation.fieldRequired') }}<br /> </span>
                                </div>
                                <template v-if="errors[`features.${lang.code}.title`]">
                                    <error-message v-for="(errorMessage, index) in errors[`features.${lang.code}.title`]" :key="index">
                                        {{ errorMessage }}
                                    </error-message>
                                </template>
                            </div>
                        </div>

                        <div class="col-md-12 mt-3">
                            <div class="row" v-if="data.type == 'variant'">
                                <div :class="type == 'create' ? 'col-md-6' :'col-md-12'">
                                    <h4 class="text-center">{{ $t('global.ProductAttributes') }}</h4>
                                </div>
                                <div class="col-md-6" v-if="type == 'create'">
                                    <Select v-model="attribute" @change="addAttribute" :filterFields="['id','title']" :options="attributes" filter optionLabel="title" optionValue="id" :class="['w-full w-100']">
                                    </Select>

                                    <div class="invalid-feedback">
                                        <span v-if="v$.attributes.required.$invalid">{{ $t('global.ThisFieldIsRequired') }}<br /></span>
                                    </div>
                                    <template v-if="errors['attributes']">
                                        <error-message v-for="(errorMessage, index) in errors['attributes']" :key="index">
                                            {{ errorMessage }}
                                        </error-message>
                                    </template>
                                </div>
                            </div>
                             <div class="row my-2" v-if="data.type == 'variant'">
                                <div class="col-md-12 mt-3" v-for="(el, index) in data.attributes" :key="index">
                                    <label for="number_of_phone_digits" class="form-label">
                                        {{ attributes.find(attr => attr.id === el.attribute_id)?.title || '' }}
                                    </label>
                                    <div>
                                        <span type="button" class="btn btn-outline-primary my-1 me-2 p-2"  v-for="(option, i) in data.attributes[index].options" :key="i">
                                            {{ option }} <button v-if="type == 'create'" type="button" @click="removeAttributeOption(index,i)" class="btn badge ms-2 p-1">X</button>
                                        </span>
                                    </div>
                                    <div class="d-flex">
                                        <input type="text" class="form-control" v-model.trim="data.attributes[index].option_data" :placeholder="attributes.find(attr => attr.id === el.attribute_id)?.title || '' ">
                                        <button type="button" class="btn btn-outline-secondary btn-wave waves-light" @click.prevent="addAttributeOptions(index)"><i class="ri-save-line"></i></button>
                                        <button v-if="type == 'create'" type="button" class="btn btn-outline-danger btn-wave waves-light" @click.prevent="removeAttribute(index)"><i class="ri-delete-bin-line"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body mt-2">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th v-if="data.type == 'variant'">{{ $t('label.status') }}</th>
                                            <th v-if="data.type == 'variant'">{{ $t('global.attribute_values') }}</th>
                                            <th>{{ $t('global.sku') }}</th>
                                            <th>{{ $t('global.price_before_discount') }}</th>
                                            <th>{{ $t('global.discount_percentage') }}</th>
                                            <th>{{ $t('global.price') }}</th>
                                            <th>{{ $t('global.quantity') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody v-for="(el, index) in data.variant" :key="index">
                                        <tr>
                                            <td v-if="data.type == 'variant'">
                                                <div class="form-check form-check-md">
                                                    <input class="form-check-input" type="checkbox" v-model="v$.variant[index].status.$model"
                                                           :class="{'is-invalid': v$.variant[index].status.$error || errors[`variant.${index}.status`],
                                                           'is-valid': !v$.variant[index].status.$invalid && !errors[`variant.${index}.status`] }">
                                                </div>
                                            </td>
                                            <td v-if="data.type == 'variant'"><input type="text" disabled v-model.trim="v$.variant[index].attribute_values.$model"
                                                       :class="{'is-invalid': v$.variant[index].attribute_values.$error || errors[`variant.${index}.attribute_values`],
                                                       'is-valid': !v$.variant[index].attribute_values.$invalid && !errors[`variant.${index}.attribute_values`] }"
                                                       class="form-control"></td>
                                            <td><input type="text" v-model.trim="v$.variant[index].sku.$model"
                                                       :class="{'is-invalid': v$.variant[index].sku.$error || errors[`variant.${index}.sku`],
                                                       'is-valid': !v$.variant[index].sku.$invalid && !errors[`variant.${index}.sku`] }"
                                                       class="form-control"></td>

                                            <td><input type="number" step="any" v-model.trim="v$.variant[index].price_before_discount.$model" @input="v$.variant[index].price.$model = v$.variant[index].price_before_discount.$model - (v$.variant[index].price_before_discount.$model * v$.variant[index].discount_percentage.$model / 100)"
                                                       :class="{'is-invalid': v$.variant[index].price_before_discount.$error || errors[`variant.${index}.price_before_discount`],
                                                       'is-valid': !v$.variant[index].price_before_discount.$invalid && !errors[`variant.${index}.price_before_discount`] }"
                                                       class="form-control"></td>

                                            <td><input type="number" step="any" v-model.trim="v$.variant[index].discount_percentage.$model" @input="v$.variant[index].price.$model = v$.variant[index].price_before_discount.$model - (v$.variant[index].price_before_discount.$model * v$.variant[index].discount_percentage.$model / 100)"
                                                       :class="{'is-invalid': v$.variant[index].discount_percentage.$error || errors[`variant.${index}.discount_percentage`],
                                                       'is-valid': !v$.variant[index].discount_percentage.$invalid && !errors[`variant.${index}.discount_percentage`] }"
                                                       class="form-control"></td>

                                            <td><input type="number" step="any" v-model.trim="v$.variant[index].price.$model"
                                                       :class="{'is-invalid': v$.variant[index].price.$error || errors[`variant.${index}.price`],
                                                       'is-valid': !v$.variant[index].price.$invalid && !errors[`variant.${index}.price`] }"
                                                       class="form-control" disabled></td>
                                            <td><input type="number" v-model.trim="v$.variant[index].quantity.$model"
                                                       :class="{'is-invalid': v$.variant[index].quantity.$error || errors[`variant.${index}.quantity`],
                                                       'is-valid': !v$.variant[index].quantity.$invalid && !errors[`variant.${index}.quantity`] }"
                                                       class="form-control"></td>

                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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
import {maxLength, minLength, required, requiredIf,numeric} from "@vuelidate/validators";
import useVuelidate from "@vuelidate/core";
import adminApi from "../../../api/adminAxios";
import Editor from 'primevue/editor';

export default {
    name: "ProductModalCreateAndUpdate",
    components: {
        Editor,
    },
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
            let myModalEl = document.getElementById('category-service')
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
        let variantValidation = ref([{
               attribute_values: {
                        required: requiredIf(function (model) {
                            return submitdata.data.type == "variant";
                        })
                    },
               sku: {required},
               price_before_discount: {required,numeric},
               discount_percentage: {required,numeric},
               price: {required,numeric},
               quantity: {required,numeric},
               status: {required}
           }]);
        let loading = ref(false);
        let is_disabled = ref(false);
        const {t} = useI18n({});
        const id = ref(null);
        let categories = ref([]);
        let brands = ref([]);
        let attributes = ref([]);
        let attribute = ref(null);
        const descRef = ref(null);

        onMounted(()=>{
            languages.value=JSON.parse(localStorage.getItem('languages'));
        });

         let getCategories = () => {
            loading.value = true;

            adminApi.get(`dashboard/categories-dropdown`)
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

         let getBrands = () => {
            loading.value = true;

            adminApi.get(`dashboard/brands-dropdown`)
                .then((res) => {
                    let l = res.data.data;
                    brands.value = l;
                })
                .catch((err) => {
                    console.log(err.response.data);
                })
                .finally(() => {
                    loading.value = false;
                })
        }

         let getProductAttributes = () => {
            loading.value = true;

            adminApi.get(`dashboard/product-attributes-dropdown`)
                .then((res) => {
                    let l = res.data.data;
                    attributes.value = l;
                })
                .catch((err) => {
                    console.log(err.response.data);
                })
                .finally(() => {
                    loading.value = false;
                })
        }

       function defaultData(){

           languages.value.forEach((el)=>{
               submitdata.data[el.code]={title:'',description:'',feature:''};
               langValidation.value[el.code] ={
                   title: {minLength: minLength(1),maxLength:maxLength(40),required,},
                   description: {required},
                     feature: {required},
               }
           });
           submitdata.data.status = true;
           submitdata.data.category_id = '';
           submitdata.data.brand_id = '';
           submitdata.data.type = 'standard';

           submitdata.data.variant=[
                { attribute_values:'', sku: '', price_before_discount: '', discount_percentage: 0, price: '', quantity: '', status: true }
           ];
           submitdata.data.attributes = [];

           attribute.value = '';
           imageUpload.value = '';
           is_disabled.value = false;
           loading.value = false;
           image.value=null
           imagesGroup.value = [];
           errors.value = [];
           empty();
        }
       function resetModal() {
            defaultData();
            setTimeout(async () => {
                getCategories();
                getBrands();
                getProductAttributes();
                if (props.type != 'edit') {
                } else {
                    id.value = props.dataRow.id;

                adminApi.get(`dashboard/products/${id.value}`)
                    .then((res) => {
                        loading.value = true;

                        let l = res.data.data;
                        l.translations.forEach((el)=>{
                            submitdata.data[el.locale]={
                                title:el.title,
                                description:el.description,
                                feature:'',
                            }
                        });
                        l.features.forEach((el)=>{
                            submitdata.data[el.locale]['feature'] = el.description;
                        });
                        submitdata.data.status = l.status==1;
                        submitdata.data.category_id = l.category_id;
                        submitdata.data.brand_id = l.brand_id;
                        submitdata.data.type = l.type;
                        l.attributes.forEach((attr) => {
                            submitdata.data.attributes.push({
                                attribute_id: attr.attribute_id,
                                options: typeof attr.options === 'string'
                                    ? attr.options.split(',').map(opt => opt.trim()).filter(opt => opt)
                                    : Array.isArray(attr.options) ? [...attr.options] : [],
                                option_data: '',
                            });
                        });

                        submitdata.data.variant=[];
                        l.variants.forEach((variant) => {
                            submitdata.data.variant.push({
                                attribute_values: variant.attribute_values,
                                sku: variant.sku,
                                price_before_discount: variant.price_before_discount,
                                discount_percentage: variant.discount_percentage,
                                price: variant.price,
                                quantity: variant.quantity,
                                status: variant.status==1
                            });
                        });

                        variantValidation.value = submitdata.data.variant.map(() => ({
                            attribute_values: {
                                required: requiredIf(() => submitdata.data.type === "variant")
                            },
                            sku: { required },
                            price_before_discount: { required, numeric },
                            discount_percentage: { required, numeric },
                            price: { required, numeric },
                            quantity: { required, numeric },
                            status: { required }
                        }));

                        imageUpload.value = l.image;
                        imagesGroup.value = l.groupImages;
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
                status: true,
                category_id: '',
                brand_id: '',
                type: 'standard',
                attributes: [],
                variant: [
                    { attribute_values:'', sku: '', price_before_discount: '', discount_percentage: 0, price: '', quantity: '', status: true }
                ]
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


        const numberOfImageUpload = ref(0);
        const imagesGroup = ref([]);

         let emptyOther = () => {
            numberOfImageUpload.value = 0;
            let clearInput = (document.querySelector(
                "#mediaPackageUpload",
            ).value = "");
            requiredn.value = false;
        };

        let previewGroup = (e) => {
            let containerImages = document.querySelector(
                "#container-images-group",
            );
            containerImages.innerHTML = "";
            imagesGroup.value = [];

            numberOfImageUpload.value = e.target.files.length;

            Array.from(e.target.files).forEach((file) => {
                imagesGroup.value.push(file);

                let reader = new FileReader();
                let figure = document.createElement("figure");

                reader.onload = () => {
                    let img = document.createElement("img");
                    img.setAttribute("src", reader.result);

                    // Set the image size
                    img.style.width = "100px"; // Adjust the width to your desired size
                    img.style.height = "100px"; // Maintain the aspect ratio
                    img.style.borderRadius = "5px"; // Optional: Add a border radius for styling

                    figure.appendChild(img); // Add the image to the figure
                };

                // Set figure to display inline-block so they appear side by side
                figure.style.display = "inline-block";
                figure.style.margin = "10px"; // Optional: Add some spacing between images

                containerImages.appendChild(figure);
                reader.readAsDataURL(file);
            });
        };

        watch(() => submitdata.data.type, (newType) => {
            if (newType === 'standard') {
                submitdata.data.attributes = [];
                submitdata.data.variant=[
                        { attribute_values:'', sku: '', price_before_discount: '', discount_percentage: 0, price: '', quantity: '', status: true }
                ];

                variantValidation.value = [{
                    attribute_values: {
                        required: requiredIf(() => submitdata.data.type === "variant")
                    },
                    sku: { required },
                    price_before_discount: { required, numeric },
                    discount_percentage: { required, numeric },
                    price: { required, numeric },
                    quantity: { required, numeric },
                    status: { required }
                }];

            } else if (newType === 'variant') {
                // Ensure attributes are initialized for variant type
                if (!submitdata.data.attributes.length) {

                    attributes.value.forEach((attr) => {
                        submitdata.data.attributes.push({
                            attribute_id: attr.id,
                            options: [],
                            option_data: ''
                        });
                    });
                }
            }
        });

        let addAttribute = () => {

            if (!attribute.value) return;

            // Prevent duplicate attribute_id
            const exists = submitdata.data.attributes.some(attr => attr.attribute_id === attribute.value);
            if (exists) {
                Swal.fire({
                    icon: 'warning',
                    title: t('global.AlreadyExists'),
                    showConfirmButton: false,
                    timer: 2000
                });
                return;
            }

            submitdata.data.attributes.push({
                attribute_id: attribute.value,
                options: [],
                option_data: ''
            });
            attribute.value = '';
            handelAttributeValuesInVariant();

        };

        function removeAttribute(index) {
            submitdata.data.attributes.splice(index, 1);
            handelAttributeValuesInVariant();
        }

        function addAttributeOptions(index) {

            if (submitdata.data.attributes[index].option_data === '') {
                return;
            }
            const attribute_data = submitdata.data.attributes[index];
            if (!attribute_data.options.includes(submitdata.data.attributes[index].option_data)) {
                attribute_data.options.push(submitdata.data.attributes[index].option_data);
                submitdata.data.attributes[index].option_data = '';
                handelAttributeValuesInVariant();
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: t('global.AlreadyExists'),
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        }

        function removeAttributeOption(index, optionIndex) {
            submitdata.data.attributes[index].options.splice(optionIndex, 1);
            handelAttributeValuesInVariant();
        }

        function handelAttributeValuesInVariant() {
            // Only add new combinations to variant if type is 'edit'
            const attributesArr = submitdata.data.attributes
                .filter(attr => Array.isArray(attr.options) && attr.options.length > 0)
                .map(attr => attr.options);

            function cartesian(arr) {
                return arr.reduce((a, b) =>
                    a.flatMap(d => b.map(e => [].concat(d, e)))
                );
            }

            let combinations = [];
            if (attributesArr.length > 0) {
                combinations = cartesian(attributesArr);
            }

            if (props.type === 'edit') {
                // Only add new combinations that don't exist in variant
                const existingValues = submitdata.data.variant.map(v => v.attribute_values);
                combinations.forEach(combo => {
                    const value = Array.isArray(combo) ? combo.join(' , ') : String(combo);
                    if (!existingValues.includes(value)) {
                        submitdata.data.variant.push({
                            attribute_values: value,
                            sku: '',
                            price_before_discount: '',
                            discount_percentage: 0,
                            price: '',
                            quantity: '',
                            status: true
                        });
                    }
                });
            } else {
                // For create, replace all variants
                submitdata.data.variant = combinations.map((combo) => ({
                    attribute_values: Array.isArray(combo) ? combo.join(' , ') : String(combo),
                    sku: '',
                    price_before_discount: '',
                    discount_percentage: 0,
                    price: '',
                    quantity: '',
                    status: true
                }));
            }

            // Add validation for each variant
            variantValidation.value = submitdata.data.variant.map(() => ({
                attribute_values: {
                    required: requiredIf(() => submitdata.data.type === "variant")
                },
                sku: { required },
                price_before_discount: { required, numeric },
                discount_percentage: { required, numeric },
                price: { required, numeric },
                quantity: { required, numeric },
                status: { required }
            }));


        }

        const rules = computed(() => {
            return {
                ...langValidation.value,
                category_id: {required},
                brand_id: {required},
                type: {required},
                variant:[...variantValidation.value],
                attributes: {
                    required: requiredIf(() => submitdata.data.type === "variant")
                },
            }
        });

        const v$ = useVuelidate(rules,submitdata.data);

        return {t,id,categories,brands,numberOfImageUpload,imagesGroup,previewGroup,emptyOther,attributes,addAttribute,attribute,addAttributeOptions,removeAttribute,removeAttributeOption,descRef,
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
       this.languages.forEach((el)=>{
           formData.append(`features[${el.code}][title]`, this.data[el.code].title);
           formData.append(`features[${el.code}][description]`, this.data[el.code].feature);
       })
        formData.append('status', this.data.status ? 1 : 0);
        formData.append('category_id', this.data.category_id);
        formData.append('brand_id', this.data.brand_id);
        formData.append('type', this.data.type);
        if (this.image) {
            formData.append('image', this.image);
        }
        this.imagesGroup.forEach((image, index) => {
            formData.append(`groupImages[${index}]`, image);
        });
        this.data.attributes.forEach((attr, index) => {
            formData.append(`attributes[${index}][attribute_id]`, attr.attribute_id);

            attr.options.forEach((option, optionIndex) => {
                formData.append(`attributes[${index}][options][${optionIndex}]`, option);
            });
        });
        this.data.variant.forEach((variant, index) => {
            formData.append(`variant[${index}][attribute_values]`, variant.attribute_values);
            formData.append(`variant[${index}][sku]`, variant.sku);
            formData.append(`variant[${index}][price_before_discount]`, variant.price_before_discount);
            formData.append(`variant[${index}][discount_percentage]`, variant.discount_percentage);
            formData.append(`variant[${index}][price]`, variant.price);
            formData.append(`variant[${index}][quantity]`, variant.quantity);
            formData.append(`variant[${index}][status]`, variant.status ? 1 : 0);
        });
        if (this.type !== 'edit') {
            if (!this.v$.$error && this.numberOfImage) {
                this.is_disabled = false;
                this.loading = true;
                adminApi.post(`dashboard/products`, formData)
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
            adminApi.post(`dashboard/products/${this.id}`,formData)
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
    color: #4b9f18;
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
    width: 60%;
    height: 50%;
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
#container-images-group {
    display: flex;
    flex-wrap: wrap;
    justify-content: start; /* Align images to the start */
    gap: 10px; /* Add space between images */
}

#container-images-group figure {
    display: inline-block;
    margin: 0;
}
</style>
