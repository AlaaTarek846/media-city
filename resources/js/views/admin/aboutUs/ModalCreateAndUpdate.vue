<template>
    <div class="modal fade" id="aboutUsModal" tabindex="-1"
         aria-labelledby="aboutUsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-gradient-primary">
                    <h5 class="modal-title fw-bold" id="aboutUsModalLabel">
                        <i class="ri-file-edit-line me-2"></i>
                        {{ type == 'create' ? $t('global.add') : $t('global.update') }} {{ $t('global.aboutUs') }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Tabs Navigation -->
                    <ul class="nav nav-tabs nav-tabs-custom mb-4" id="aboutUsTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="translations-tab" data-bs-toggle="tab"
                                    data-bs-target="#translations" type="button" role="tab"
                                    aria-controls="translations" aria-selected="true">
                                <i class="ri-translate-2-line me-2"></i>
                                <span class="d-none d-md-inline">{{ $t('label.translations') }}</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="images-tab" data-bs-toggle="tab"
                                    data-bs-target="#images" type="button" role="tab"
                                    aria-controls="images" aria-selected="false">
                                <i class="ri-image-line me-2"></i>
                                <span class="d-none d-md-inline">{{ $t('label.images') }}</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="features-tab" data-bs-toggle="tab"
                                    data-bs-target="#features" type="button" role="tab"
                                    aria-controls="features" aria-selected="false">
                                <i class="ri-star-line me-2"></i>
                                <span class="d-none d-md-inline">{{ $t('label.features') }}</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="statistics-tab" data-bs-toggle="tab"
                                    data-bs-target="#statistics" type="button" role="tab"
                                    aria-controls="statistics" aria-selected="false">
                                <i class="ri-bar-chart-line me-2"></i>
                                <span class="d-none d-md-inline">{{ $t('label.statistics') }}</span>
                            </button>
                        </li>
                    </ul>

                    <!-- Tabs Content -->
                    <div class="tab-content" id="aboutUsTabsContent">
                        <!-- Tab 1: Translations -->
                        <div class="tab-pane fade show active" id="translations" role="tabpanel"
                             aria-labelledby="translations-tab">
                            <div class="row g-4">
                                <div class="col-md-6" v-if="data.ar" v-for="lang in languages" :key="lang.code">
                                    <div class="form-group-custom">
                                        <label class="form-label fw-semibold">
                                            <i class="ri-text me-1"></i>
                                            {{ $t('label.title') }} ({{ lang.title }})
                                        </label>
                                        <input type="text" class="form-control form-control-custom" v-model="v$[lang.code].title.$model"
                                               :placeholder="$t('label.title') + ' ' + lang.title"
                                               :class="{'is-invalid': v$[lang.code].title.$error || errors[`translations.${lang.code}.title`],
                                               'is-valid': !v$[lang.code].title.$invalid && !errors[`translations.${lang.code}.title`]}">
                                        <div class="invalid-feedback">
                                            <span v-if="v$[lang.code].title.required.$invalid">{{ $t('validation.fieldRequired') }}<br /></span>
                                        </div>
                                        <template v-if="errors[`translations.${lang.code}.title`]">
                                            <error-message v-for="(errorMessage, index) in errors[`translations.${lang.code}.title`]" :key="index">
                                                {{ errorMessage }}
                                            </error-message>
                                        </template>
                                    </div>
                                </div>

                                <div class="col-md-12" v-if="data.ar" v-for="lang in languages" :key="lang.code">
                                    <div class="form-group-custom">
                                        <label class="form-label fw-semibold">
                                            <i class="ri-file-text-line me-1"></i>
                                            {{ $t('label.description') }} ({{ lang.title }})
                                        </label>
                                        <div class="editor-wrapper">
                                            <Editor ref="descRef" v-model="data[lang.code].description"/>
                                        </div>
                                        <template v-if="errors[`translations.${lang.code}.description`]">
                                            <error-message v-for="(errorMessage, index) in errors[`translations.${lang.code}.description`]" :key="index">
                                                {{ errorMessage }}
                                            </error-message>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tab 2: Images -->
                        <div class="tab-pane fade" id="images" role="tabpanel" aria-labelledby="images-tab">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="image-upload-card">
                                        <label class="form-label fw-semibold mb-3">
                                            <i class="ri-image-line me-2"></i>
                                            {{ $t('label.image') }} 1 ( 321 × 214 px )
                                        </label>
                                        <div class="image-upload-wrapper">
                                            <div id="container-image-1" v-show="image1 && numberOfImage1" class="image-preview-container"></div>
                                            <div v-show="!numberOfImage1 && imageUpload1" class="image-preview-container">
                                                <img class="img-fluid rounded shadow-sm" :src="imageUpload1" alt="Image 1">
                                            </div>
                                            <div v-show="!numberOfImage1 && !imageUpload1" class="image-upload-placeholder">
                                                <i class="ri-image-add-line"></i>
                                                <p class="mb-0 mt-2">{{ $t('global.NoFilesChosen') }}</p>
                                            </div>
                                            <input name="image1" type="file" @change="preview1" id="image1" accept="image/*">
                                        </div>
                                        <p class="num-of-files text-center mt-2">
                                            <i class="ri-file-line me-1"></i>
                                            {{ numberOfImage1 ? numberOfImage1 + ' ' + $t('global.FilesSelected') : $t('global.NoFilesChosen') }}
                                        </p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="image-upload-card">
                                        <label class="form-label fw-semibold mb-3">
                                            <i class="ri-image-line me-2"></i>
                                            {{ $t('label.image') }} 2 ( 321 × 214 px )
                                        </label>
                                        <div class="image-upload-wrapper">
                                            <div id="container-image-2" v-show="image2 && numberOfImage2" class="image-preview-container"></div>
                                            <div v-show="!numberOfImage2 && imageUpload2" class="image-preview-container">
                                                <img class="img-fluid rounded shadow-sm" :src="imageUpload2" alt="Image 2">
                                            </div>
                                            <div v-show="!numberOfImage2 && !imageUpload2" class="image-upload-placeholder">
                                                <i class="ri-image-add-line"></i>
                                                <p class="mb-0 mt-2">{{ $t('global.NoFilesChosen') }}</p>
                                            </div>
                                            <input name="image2" type="file" @change="preview2" id="image2" accept="image/*">
                                        </div>
                                        <p class="num-of-files text-center mt-2">
                                            <i class="ri-file-line me-1"></i>
                                            {{ numberOfImage2 ? numberOfImage2 + ' ' + $t('global.FilesSelected') : $t('global.NoFilesChosen') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tab 3: Features -->
                        <div class="tab-pane fade" id="features" role="tabpanel" aria-labelledby="features-tab">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="mb-0 fw-bold">
                                    <i class="ri-star-fill me-2 text-warning"></i>
                                    {{ $t('label.features') }}
                                </h5>
                                <button type="button" class="btn btn-primary btn-add-item" @click="addFeature">
                                    <i class="ri-add-circle-line me-1"></i>
                                    {{ $t('global.add') }} {{ $t('label.feature') }}
                                </button>
                            </div>

                            <div v-if="data.features && data.features.length === 0" class="alert alert-info-custom">
                                <i class="ri-information-line me-2"></i>
                                {{ $t('label.noFeatures') }}
                            </div>

                            <div v-for="(feature, index) in data.features" :key="index" class="feature-card">
                                <div class="feature-card-header">
                                    <div class="d-flex align-items-center">
                                        <span class="feature-badge">{{ index + 1 }}</span>
                                        <h6 class="mb-0 ms-2">{{ $t('label.feature') }} #{{ index + 1 }}</h6>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-danger btn-remove"
                                            @click="removeFeature(index)" v-if="data.features.length > 1">
                                        <i class="ri-delete-bin-line me-1"></i>
                                        {{ $t('global.delete') }}
                                    </button>
                                </div>
                                <div class="feature-card-body">
                                    <div class="row g-3 justify-content-center">
                                        <div class="col-md-6" v-for="lang in languages" :key="lang.code">
                                            <label class="form-label fw-semibold">
                                                <i class="ri-text me-1"></i>
                                                {{ $t('label.title') }} ({{ lang.title }})
                                            </label>
                                            <input type="text" class="form-control form-control-custom"
                                                   v-model="feature.translations[lang.code].title"
                                                   :placeholder="$t('label.title') + ' ' + lang.title">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">
                                                <i class="ri-image-line me-1"></i>
                                                {{ $t('label.icon') }} ( 40 × 26 px )
                                            </label>
                                            <div class="icon-upload-wrapper">
                                                <div :id="'container-feature-icon-' + index" v-show="feature.iconFile" class="icon-preview-container"></div>
                                                <div v-show="!feature.iconFile && feature.icon" class="icon-preview-container">
                                                    <img class="img-fluid rounded shadow-sm" :src="feature.icon" alt="Feature Icon">
                                                </div>
                                                <div v-show="!feature.iconFile && !feature.icon" class="icon-upload-placeholder">
                                                    <i class="ri-image-add-line"></i>
                                                </div>
                                                <input :name="'featureIcon' + index" type="file" @change="previewFeatureIcon(index, $event)" :id="'featureIcon' + index" accept="image/*">
                                            </div>
                                            <p class="num-of-files-small text-center mt-2">
                                                {{ feature.iconFile ? '1 ' + $t('global.FilesSelected') : $t('global.NoFilesChosen') }}
                                            </p>
                                            <small class="form-text text-muted">
                                                <i class="ri-information-line me-1"></i>
                                                {{ $t('label.iconHint') }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tab 4: Statistics -->
                        <div class="tab-pane fade" id="statistics" role="tabpanel" aria-labelledby="statistics-tab">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="mb-0 fw-bold">
                                    <i class="ri-bar-chart-fill me-2 text-success"></i>
                                    {{ $t('label.statistics') }}
                                </h5>
                                <button type="button" class="btn btn-primary btn-add-item" @click="addStatistic">
                                    <i class="ri-add-circle-line me-1"></i>
                                    {{ $t('global.add') }} {{ $t('label.statistic') }}
                                </button>
                            </div>

                            <div v-if="data.statistics && data.statistics.length === 0" class="alert alert-info-custom">
                                <i class="ri-information-line me-2"></i>
                                {{ $t('label.noStatistics') }}
                            </div>

                            <div v-for="(statistic, index) in data.statistics" :key="index" class="statistic-card">
                                <div class="statistic-card-header">
                                    <div class="d-flex align-items-center">
                                        <span class="statistic-badge">{{ index + 1 }}</span>
                                        <h6 class="mb-0 ms-2">{{ $t('label.statistic') }} #{{ index + 1 }}</h6>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-danger btn-remove"
                                            @click="removeStatistic(index)" v-if="data.statistics.length > 1">
                                        <i class="ri-delete-bin-line me-1"></i>
                                        {{ $t('global.delete') }}
                                    </button>
                                </div>
                                <div class="statistic-card-body">
                                    <div class="row g-3">
                                        <div class="col-md-6" v-for="lang in languages" :key="lang.code">
                                            <label class="form-label fw-semibold">
                                                <i class="ri-text me-1"></i>
                                                {{ $t('label.title') }} ({{ lang.title }})
                                            </label>
                                            <input type="text" class="form-control form-control-custom"
                                                   v-model="statistic.translations[lang.code].title"
                                                   :placeholder="$t('label.title') + ' ' + lang.title">
                                        </div>
                                        <div class="col-md-6" v-for="lang in languages" :key="lang.code">
                                            <label class="form-label fw-semibold">
                                                <i class="ri-file-text-line me-1"></i>
                                                {{ $t('label.description') }} ({{ lang.title }})
                                            </label>
                                            <textarea class="form-control form-control-custom" rows="3"
                                                   v-model="statistic.translations[lang.code].description"
                                                   :placeholder="$t('label.description') + ' ' + lang.title"></textarea>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold">
                                                <i class="ri-number-1 me-1"></i>
                                                {{ $t('label.value') }}
                                            </label>
                                            <input type="text" class="form-control form-control-custom" v-model="statistic.value"
                                                   placeholder="10, 80K+, 90%">
                                            <small class="form-text text-muted">
                                                <i class="ri-information-line me-1"></i>
                                                {{ $t('label.valueHint') }}
                                            </small>
                                        </div>
                                        <div class="col-md-8">
                                            <label class="form-label fw-semibold">
                                                <i class="ri-image-line me-1"></i>
                                                {{ $t('label.icon') }} (117 × 114 px)
                                            </label>
                                            <div class="icon-upload-wrapper">
                                                <div :id="'container-statistic-icon-' + index" v-show="statistic.iconFile" class="icon-preview-container"></div>
                                                <div v-show="!statistic.iconFile && statistic.icon" class="icon-preview-container">
                                                    <img class="img-fluid rounded shadow-sm" :src="statistic.icon" alt="Statistic Icon">
                                                </div>
                                                <div v-show="!statistic.iconFile && !statistic.icon" class="icon-upload-placeholder">
                                                    <i class="ri-image-add-line"></i>
                                                </div>
                                                <input :name="'statisticIcon' + index" type="file" @change="previewStatisticIcon(index, $event)" :id="'statisticIcon' + index" accept="image/*">
                                            </div>
                                            <p class="num-of-files-small text-center mt-2">
                                                {{ statistic.iconFile ? '1 ' + $t('global.FilesSelected') : $t('global.NoFilesChosen') }}
                                            </p>
                                            <small class="form-text text-muted">
                                                <i class="ri-information-line me-1"></i>
                                                {{ $t('label.iconHint') }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-cancel" data-bs-dismiss="modal">
                        <i class="ri-close-line me-1"></i>
                        {{ $t('global.close') }}
                    </button>
                    <button type="button" class="btn btn-primary btn-submit" @click="submitForm" :disabled="loading">
                        <span v-if="!loading">
                            <i class="ri-save-line me-1"></i>
                            {{ type == 'create' ? $t('global.add') : $t('global.update') }}
                        </span>
                        <span v-else>
                            <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                            {{ $t('global.Loading') }}...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { computed, onMounted, reactive, ref, toRefs, watch, onBeforeMount, nextTick } from "vue";
import { useI18n } from "vue-i18n";
import { required } from "@vuelidate/validators";
import useVuelidate from "@vuelidate/core";
import adminApi from "../../../api/adminAxios";
import Editor from 'primevue/editor';

export default {
    name: "ModalCreateAndUpdate",
    props: {
        type: { default: 'create' },
        dataRow: { default: null },
    },
    components: {
        Editor
    },
    emits: ['created'],
    setup(props, { emit }) {

        setTimeout(async () => {
            let myModalEl = document.getElementById('aboutUsModal')
            myModalEl.addEventListener('show.bs.modal', function (event) {
                resetModal();
            })
            myModalEl.addEventListener('hidden.bs.modal', function (event) {
                defaultData();
            })
        }, 150);


        const errors = ref({});
        const languages = ref([]);
        const langValidation = ref({});
        let loading = ref(false);
        const { t } = useI18n({});
        const descRef = ref(null);

        // Image handling
        const imageMain = ref(null);
        const image1 = ref(null);
        const image2 = ref(null);
        const numberOfImageMain = ref(0);
        const numberOfImage1 = ref(0);
        const numberOfImage2 = ref(0);
        const imageUploadMain = ref('');
        const imageUpload1 = ref('');
        const imageUpload2 = ref('');

        function defaultData() {
            languages.value.forEach((el) => {
                submitdata.data[el.code] = { title: '', description: '' };
                langValidation.value[el.code] = {
                    title: { required },
                    description: { required }
                };
            });
            submitdata.data.features = [];
            submitdata.data.statistics = [];
            loading.value = false;
            errors.value = [];
            imageUpload1.value = '';
            imageUpload2.value = '';
            image1.value = null;
            image2.value = null;
            numberOfImage1.value = 0;
            numberOfImage2.value = 0;
        }

        function resetModal() {
            defaultData();
            if (props.type === 'edit' && props.dataRow) {
                setTimeout(async () => {
                    adminApi.get(`dashboard/about-us/${props.dataRow.id}`)
                        .then((res) => {
                            loading.value = true;
                            let l = res.data.data;
                            l.translations.forEach((el) => {
                                submitdata.data[el.locale] = {
                                    title: el.title,
                                    description: el.description,
                                };
                            });
                            imageUpload1.value = l.image_1 || '';
                            imageUpload2.value = l.image_2 || '';

                            // Load features
                            submitdata.data.features = (l.features || []).map(f => ({
                                id: f.id,
                                icon: f.icon || '',
                                translations: {}
                            }));
                            l.features?.forEach((f, idx) => {
                                f.translations?.forEach(t => {
                                    if (!submitdata.data.features[idx].translations[t.locale]) {
                                        submitdata.data.features[idx].translations[t.locale] = {};
                                    }
                                    submitdata.data.features[idx].translations[t.locale].title = t.title;
                                });
                            });

                            // Load statistics
                            submitdata.data.statistics = (l.statistics || []).map(s => ({
                                id: s.id,
                                icon: s.icon || '',
                                iconFile: null,
                                value: s.value || '',
                                translations: {}
                            }));
                            l.statistics?.forEach((s, idx) => {
                                s.translations?.forEach(t => {
                                    if (!submitdata.data.statistics[idx].translations[t.locale]) {
                                        submitdata.data.statistics[idx].translations[t.locale] = {};
                                    }
                                    submitdata.data.statistics[idx].translations[t.locale].title = t.title;
                                    submitdata.data.statistics[idx].translations[t.locale].description = t.description || '';
                                });
                            });
                        })
                        .catch((err) => {
                            console.log(err);
                        })
                        .finally(() => {
                            loading.value = false;
                            if (descRef.value) {
                                nextTick(() => {
                                    descRef.value.forEach((el) => {
                                        if (el && el.quill) {
                                            const delta = el.quill.clipboard.convert({ html: el.modelValue });
                                            el.quill.setContents(delta, 'silent');
                                        }
                                    });
                                });
                            }
                        });
                }, 50);
            }
        }

        onBeforeMount(() => {
            languages.value = JSON.parse(localStorage.getItem('languages'));
        });

        onMounted(() => {
            resetModal();
            setTimeout(() => {
                let myModalEl = document.getElementById('aboutUsModal');
                if (myModalEl) {
                    myModalEl.addEventListener('show.bs.modal', function (event) {
                        resetModal();
                    });
                }
            }, 150);
        });

        watch(() => props.dataRow, () => {
            if (props.type === 'edit') {
                resetModal();
            }
        });

        let submitdata = reactive({
            data: {}
        });

        // Image preview functions
        const preview1 = (e) => {
            let container = document.querySelector('#container-image-1');
            if (container) container.innerHTML = '';
            image1.value = {};
            numberOfImage1.value = e.target.files.length;
            image1.value = e.target.files[0];
            let reader = new FileReader();
            reader.onload = () => {
                if (container) {
                    let img = document.createElement('img');
                    img.setAttribute('src', reader.result);
                    img.classList.add('img-fluid', 'rounded', 'shadow-sm');
                    img.style.maxHeight = '100%';
                    img.style.maxWidth = '100%';
                    img.style.objectFit = 'contain';
                    container.appendChild(img);
                }
            };
            reader.readAsDataURL(image1.value);
        };

        const preview2 = (e) => {
            let container = document.querySelector('#container-image-2');
            if (container) container.innerHTML = '';
            image2.value = {};
            numberOfImage2.value = e.target.files.length;
            image2.value = e.target.files[0];
            let reader = new FileReader();
            reader.onload = () => {
                if (container) {
                    let img = document.createElement('img');
                    img.setAttribute('src', reader.result);
                    img.classList.add('img-fluid', 'rounded', 'shadow-sm');
                    img.style.maxHeight = '100%';
                    img.style.maxWidth = '100%';
                    img.style.objectFit = 'contain';
                    container.appendChild(img);
                }
            };
            reader.readAsDataURL(image2.value);
        };

        // Preview functions for feature and statistic icons
        const previewFeatureIcon = (index, e) => {
            let container = document.querySelector(`#container-feature-icon-${index}`);
            if (container) container.innerHTML = '';

            if (e.target.files && e.target.files[0]) {
                submitdata.data.features[index].iconFile = e.target.files[0];
                let reader = new FileReader();
                reader.onload = () => {
                    if (container) {
                        let img = document.createElement('img');
                        img.setAttribute('src', reader.result);
                        img.classList.add('img-fluid', 'rounded', 'shadow-sm');
                        img.style.maxHeight = '100%';
                        img.style.maxWidth = '100%';
                        img.style.objectFit = 'contain';
                        container.appendChild(img);
                    }
                };
                reader.readAsDataURL(submitdata.data.features[index].iconFile);
            }
        };

        const previewStatisticIcon = (index, e) => {
            let container = document.querySelector(`#container-statistic-icon-${index}`);
            if (container) container.innerHTML = '';

            if (e.target.files && e.target.files[0]) {
                submitdata.data.statistics[index].iconFile = e.target.files[0];
                let reader = new FileReader();
                reader.onload = () => {
                    if (container) {
                        let img = document.createElement('img');
                        img.setAttribute('src', reader.result);
                        img.classList.add('img-fluid', 'rounded', 'shadow-sm');
                        img.style.maxHeight = '100%';
                        img.style.maxWidth = '100%';
                        img.style.objectFit = 'contain';
                        container.appendChild(img);
                    }
                };
                reader.readAsDataURL(submitdata.data.statistics[index].iconFile);
            }
        };

        // Features and Statistics management
        const addFeature = () => {
            const newFeature = {
                icon: '',
                iconFile: null,
                translations: {}
            };
            languages.value.forEach(lang => {
                newFeature.translations[lang.code] = { title: '' };
            });
            submitdata.data.features.push(newFeature);
        };

        const removeFeature = (index) => {
            submitdata.data.features.splice(index, 1);
        };

        const addStatistic = () => {
            const newStatistic = {
                value: '',
                icon: '',
                iconFile: null,
                translations: {}
            };
            languages.value.forEach(lang => {
                newStatistic.translations[lang.code] = { title: '', description: '' };
            });
            submitdata.data.statistics.push(newStatistic);
        };

        const removeStatistic = (index) => {
            submitdata.data.statistics.splice(index, 1);
        };

        const rules = computed(() => {
            return {
                ...langValidation.value,
            };
        });

        const v$ = useVuelidate(rules, submitdata.data);

        return {
            t, loading, languages, descRef, ...toRefs(submitdata), v$, errors,
            image1, image2, numberOfImage1, numberOfImage2,
            imageUpload1, imageUpload2,
            preview1, preview2,
            previewFeatureIcon, previewStatisticIcon,
            addFeature, removeFeature, addStatistic, removeStatistic,
            resetModal
        };
    },
    methods: {
        submitForm() {
            this.v$.$validate();
            this.errors = {};

            let formData = new FormData();

            // Add translations
            this.languages.forEach((el) => {
                formData.append(`translations[${el.code}][title]`, this.data[el.code].title);
                formData.append(`translations[${el.code}][description]`, this.data[el.code].description);
            });

            // Add images
            if (this.image1) {
                formData.append('image_1', this.image1);
            }
            if (this.image2) {
                formData.append('image_2', this.image2);
            }


            // Add features
            this.data.features.forEach((feature, index) => {
                if (feature.iconFile) {
                    formData.append(`features[${index}][icon]`, feature.iconFile);
                }
                if (feature.id) {
                    formData.append(`features[${index}][id]`, feature.id);
                }
                this.languages.forEach(lang => {
                    if (feature.translations[lang.code]?.title) {
                        formData.append(`features[${index}][translations][${lang.code}][title]`, feature.translations[lang.code].title);
                    }
                });
            });

            // Add statistics
            this.data.statistics.forEach((statistic, index) => {
                formData.append(`statistics[${index}][value]`, statistic.value || '');
                if (statistic.iconFile) {
                    formData.append(`statistics[${index}][icon]`, statistic.iconFile);
                } else if (statistic.icon && !statistic.iconFile) {
                    // Keep existing icon if no new file uploaded
                    formData.append(`statistics[${index}][icon_existing]`, statistic.icon);
                }
                if (statistic.id) {
                    formData.append(`statistics[${index}][id]`, statistic.id);
                }
                this.languages.forEach(lang => {
                    if (statistic.translations[lang.code]?.title) {
                        formData.append(`statistics[${index}][translations][${lang.code}][title]`, statistic.translations[lang.code].title);
                    }
                    if (statistic.translations[lang.code]?.description) {
                        formData.append(`statistics[${index}][translations][${lang.code}][description]`, statistic.translations[lang.code].description);
                    }
                });
            });

            if (!this.v$.$error) {
                this.loading = true;
                const url = this.type === 'create'
                    ? 'dashboard/about-us'
                    : `dashboard/about-us/${this.dataRow.id}`;
                const method = this.type === 'create' ? 'post' : 'post';

                if (this.type === 'edit') {
                    formData.append('_method', 'PUT');
                }

                adminApi[method](url, formData)
                    .then((res) => {
                        Swal.fire({
                            icon: 'success',
                            title: `${this.t('global.' + (this.type === 'create' ? 'AddedSuccessfully' : 'EditSuccessfully'))}`,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        let myModalEl = document.getElementById('aboutUsModal');
                        if (myModalEl) {
                            let modal = bootstrap.Modal.getInstance(myModalEl);
                            if (modal) modal.hide();
                        }
                        this.$emit('created');
                    })
                    .catch((err) => {
                        this.errors = err.response?.data?.errors || {};
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
/* Modal Header */
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-bottom: none;
}

.modal-title {
    font-size: 1.25rem;
    display: flex;
    align-items: center;
}

/* Tabs Customization */
.nav-tabs-custom {
    border-bottom: 2px solid #e9ecef;
    padding-bottom: 0;
}

.nav-tabs-custom .nav-link {
    border: none;
    border-bottom: 3px solid transparent;
    color: #6c757d;
    padding: 0.75rem 1.5rem;
    transition: all 0.3s ease;
    font-weight: 500;
    background: transparent;
}

.nav-tabs-custom .nav-link:hover {
    color: #667eea;
    background: rgba(102, 126, 234, 0.1);
    border-bottom-color: rgba(102, 126, 234, 0.3);
}

.nav-tabs-custom .nav-link.active {
    color: #667eea;
    background: rgba(102, 126, 234, 0.1);
    border-bottom-color: #667eea;
    font-weight: 600;
}

/* Form Controls */
.form-group-custom {
    margin-bottom: 1.5rem;
}

.form-label {
    color: #495057;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
}

.form-control-custom {
    border: 1px solid #dee2e6;
    border-radius: 0.5rem;
    padding: 0.625rem 1rem;
    transition: all 0.3s ease;
}

.form-control-custom:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.editor-wrapper {
    border: 1px solid #dee2e6;
    border-radius: 0.5rem;
    overflow: hidden;
}

/* Image Upload */
.image-upload-card {
    background: #f8f9fa;
    border-radius: 1rem;
    padding: 1.5rem;
    border: 2px dashed #dee2e6;
    transition: all 0.3s ease;
}

.image-upload-card:hover {
    border-color: #667eea;
    background: #f0f4ff;
}

.image-upload-wrapper {
    position: relative;
    width: 100%;
    height: 250px;
    border-radius: 0.75rem;
    overflow: hidden;
    background: white;
    border: 2px solid #e9ecef;
    cursor: pointer;
    transition: all 0.3s ease;
}

.image-upload-wrapper:hover {
    border-color: #667eea;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
    transform: translateY(-2px);
}

.image-preview-container {
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 1rem;
}

.image-preview-container img {
    max-height: 100%;
    max-width: 100%;
    object-fit: contain;
}

.image-upload-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    color: #adb5bd;
    background: #f8f9fa;
}

.image-upload-placeholder i {
    font-size: 3.5rem;
    margin-bottom: 0.5rem;
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
    opacity: 0;
    z-index: 1;
}

.num-of-files {
    font-size: 0.875rem;
    color: #6c757d;
    font-weight: 500;
}

/* Icon Upload */
.icon-upload-wrapper {
    position: relative;
    width: 100%;
    height: 150px;
    border-radius: 0.75rem;
    overflow: hidden;
    background: white;
    border: 2px solid #e9ecef;
    cursor: pointer;
    transition: all 0.3s ease;
}

.icon-upload-wrapper:hover {
    border-color: #667eea;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
    transform: translateY(-2px);
}

.icon-preview-container {
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 1rem;
}

.icon-preview-container img {
    max-height: 100%;
    max-width: 100%;
    object-fit: contain;
}

.icon-upload-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    color: #adb5bd;
    background: #f8f9fa;
}

.icon-upload-placeholder i {
    font-size: 2.5rem;
}

.num-of-files-small {
    font-size: 0.75rem;
    color: #6c757d;
}

/* Feature & Statistic Cards */
.feature-card,
.statistic-card {
    background: white;
    border-radius: 1rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    margin-bottom: 1.5rem;
    overflow: hidden;
    transition: all 0.3s ease;
    border: 1px solid #e9ecef;
}

.feature-card:hover,
.statistic-card:hover {
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
    transform: translateY(-2px);
}

.feature-card-header,
.statistic-card-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 1rem 1.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 2px solid #dee2e6;
}

.feature-badge,
.statistic-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    font-weight: 600;
    font-size: 0.875rem;
}

.feature-card-body,
.statistic-card-body {
    padding: 1.5rem;
}

.btn-add-item {
    border-radius: 0.5rem;
    padding: 0.5rem 1.25rem;
    font-weight: 500;
    transition: all 0.3s ease;
    box-shadow: 0 2px 4px rgba(102, 126, 234, 0.2);
}

.btn-add-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(102, 126, 234, 0.3);
}

.btn-remove {
    border-radius: 0.5rem;
    transition: all 0.3s ease;
}

.btn-remove:hover {
    transform: scale(1.05);
}

/* Alerts */
.alert-info-custom {
    background: linear-gradient(135deg, #e7f3ff 0%, #d0e7ff 100%);
    border: 1px solid #b3d9ff;
    border-radius: 0.75rem;
    color: #004085;
    padding: 1rem 1.5rem;
    display: flex;
    align-items: center;
}

/* Modal Footer */
.modal-footer {
    border-top: 1px solid #e9ecef;
    padding: 1rem 1.5rem;
}

.btn-cancel {
    border-radius: 0.5rem;
    padding: 0.625rem 1.5rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-cancel:hover {
    transform: translateY(-2px);
    box-shadow: 0 2px 8px rgba(108, 117, 125, 0.2);
}

.btn-submit {
    border-radius: 0.5rem;
    padding: 0.625rem 1.5rem;
    font-weight: 500;
    transition: all 0.3s ease;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
}

.btn-submit:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}

.btn-submit:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

/* Container Images */
#container-image-1,
#container-image-2,
#container-feature-icon-*,
#container-statistic-icon-* {
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 1rem;
}

#container-image-1 img,
#container-image-2 img {
    max-height: 100%;
    max-width: 100%;
    object-fit: contain;
    border-radius: 0.5rem;
}

/* Animations */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.tab-pane {
    animation: fadeIn 0.3s ease;
}

.feature-card,
.statistic-card {
    animation: fadeIn 0.3s ease;
}

/* Responsive */
@media (max-width: 768px) {
    .nav-tabs-custom .nav-link {
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
    }

    .image-upload-wrapper {
        height: 200px;
    }

    .feature-card-header,
    .statistic-card-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.75rem;
    }
}
</style>

