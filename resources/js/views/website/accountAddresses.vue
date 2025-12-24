<template>
    <div class="my-profile">
        <h4 class="mb-4">{{$t('global.My Addresses')}}</h4>
        
        <div class="card rounded-3 border mt-4" v-for="(address,index) in addresses" :key="address.id">
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-3">
                    <h5 class="mb-0">{{ address.title }}</h5>
                    <span class="badge rounded-5 bg-dark" v-if="parseInt(address.is_primary)">Primary</span>
                </div>
                <div class="mt-3">
                    <address class="mb-0">{{address.building_number ? address.building_number +' , ' : ''}}{{ address.address }} <br>
                        {{ address.area?.translation?.title }}, {{ address.country?.translation?.title }}</address>
                </div>
                <div class="mt-3 d-flex align-items-center gap-3">
                    <button type="button" class="btn btn-sm btn-outline-dark px-4 rounded-3" data-bs-toggle="modal"
                        data-bs-target="#AddNewAddressModal" @click.prevent="showEditMode(address)">{{$t('global.Edit Address')}}</button>
                    <button type="button" class="btn btn-sm btn-outline-danger px-4 rounded-3" @click.prevent="deleteData(address.id,index)">{{$t('global.delete')}}</button>
                </div>
            </div>
        </div>
        <div class="mt-4">
            <button type="button" class="btn btn-sm btn-outline-dark border-2 border rounded-3 px-4" data-bs-toggle="modal" data-bs-target="#AddNewAddressModal" @click="showModel()"><i class="bi bi-plus-lg me-2"></i>{{$t('global.Add new Address')}}</button>
        </div>
        <ModelCreateAndUpdateAddress v-model="modalShow" :type="type" :dataRow="dataRow" @created="getAddresses()" />
    </div>
</template>

<script>
import { computed, reactive, ref, toRefs, onBeforeMount, nextTick } from "vue";
import { alphaNum, email, maxLength, minLength, required, numeric } from "@vuelidate/validators";
import useVuelidate from "@vuelidate/core";
import webApi from "../../api/webAxios";
import { useI18n } from "vue-i18n";
import ModelCreateAndUpdateAddress from "./ModelCreateAndUpdateAddress.vue";


export default {
    name: "checkout",
    props: {
        cart: { default: '' },
        setting: { default: '' },
        user: { default: '' },
    },
    components: {
        ModelCreateAndUpdateAddress
    },
    setup(props, { emit }) {

        const errors = ref([]);
        let loading = ref(false);
        const { t } = useI18n({});
        let addresses = ref([]);
        let modalShow = ref(false);
        let type = ref('create');
        let dataRow = ref('');

        onBeforeMount(() => {
            getAddresses();
        });

        let getAddresses = async () => {
            try {
                const response = await webApi.get(`/web/user-addresses`);
                addresses.value = response.data.data;
            } catch (error) {
                console.error("Error fetching addresses:", error);
            }
        };
       
        function deleteData(id, index) {
            Swal.fire({
                title: `${t('global.AreYouSureDelete')}`,
                text: `${t("global.YouWontBeAbleToRevertThis")}`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: t('global.yes'),
                cancelButtonText: t('global.no'),
            }).then((result) => {
                if (result.isConfirmed) {
                    webApi.delete(`/web/remove-address/${id}`)
                        .then((res) => {
                            addresses.value.splice(index, 1);
                            Swal.fire({
                                icon: 'success',
                                title: `${t('global.DeletedSuccessfully')}`,
                                showConfirmButton: false,
                                timer: 1500
                            });
                        })
                        .catch((err) => {
                            Swal.fire({
                                icon: 'error',
                                title: `${t('global.ThereIsAnErrorInTheSystem')}`,
                                text: `${t('global.YouCanNotDelete')}`,
                            });
                        });
                }
            });
        }

        let showModel = () => {
            modalShow.value = true;
        }
        let showEditMode = (row) => {
            dataRow.value=row;
            type.value='edit';
            modalShow.value=true;
        }

        return { loading, errors, t, deleteData, addresses, getAddresses, modalShow, type, dataRow, showModel,showEditMode}
    },

}
</script>