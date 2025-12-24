<template>
    <div class="container-fluid">
        <!-- Start::page-header -->

        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div>
                <p class="fw-semibold fs-18 mb-0">{{$t('global.WelcomeBack')}}, {{$store.state.authAdmin.user?.name}} !</p>
                <span class="fs-semibold text-muted">اليك بعض الاحصائيات</span>
            </div>
            <!-- <div class="btn-list mt-md-0 mt-2">
                <button type="button" class="btn btn-primary btn-wave">
                    <i class="ri-filter-3-fill me-2 align-middle d-inline-block"></i>Filters
                </button>
                <button type="button" class="btn btn-outline-secondary btn-wave">
                    <i class="ri-upload-cloud-line me-2 align-middle d-inline-block"></i>Export
                </button>
            </div> -->
        </div>

        <!-- End::page-header -->

        <!-- Start::row-1 -->
        <div class="row">
            <div class="col-xxl-9 col-xl-9">
                <div class="row">
                    <div class="col-xl-4">
                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card custom-card">
                                <div class="card-header">
                                    <div class="card-title">{{$t('global.clientStatistics')}}</div>
                                </div>
                                <div class="card-body">
                                    <div id="client-statistics"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card custom-card">
                                        <div class="card-header  justify-content-between">
                                            <div class="card-title">
                                                اكثر 5 مستخدمين لديهم طلبات
                                            </div>

                                        </div>
                                        <div class="card-body">
                                            <ul class="list-unstyled crm-top-deals mb-0" v-if="statistics?.top_five_users_has_orders">
                                                <li v-for="item in statistics.top_five_users_has_orders" :key="item.id">
                                                    <div class="d-flex align-items-top flex-wrap">

                                                        <div class="flex-fill">
                                                            <p class="fw-semibold mb-0">{{item.name}}</p>
                                                            <span class="text-muted fs-12">{{item.phone}}</span>
                                                        </div>
                                                        <div class="fw-semibold fs-15">{{item.orders_count}}</div>
                                                    </div>
                                                </li>


                                            </ul>
                                        </div>
                                    </div>
                        </div>

                    </div>
                    <div class="col-xl-8">
                        <div class="row">
                            <div class="col-xxl-6 col-lg-6 col-md-6">
                                <div class="card custom-card overflow-hidden">
                                    <div class="card-body">
                                        <div class="d-flex align-items-top justify-content-between">
                                            <div>
                                                <span class="avatar avatar-md avatar-rounded bg-primary">
                                                    <i class="ti ti-users fs-16"></i>
                                                </span>
                                            </div>
                                            <div class="flex-fill ms-3">
                                                <div class="d-flex align-items-center justify-content-between flex-wrap">
                                                    <div>
                                                        <p class="text-muted mb-0">{{$t('global.clientCount')}}</p>
                                                        <h4 class="fw-semibold mt-1">{{ statistics.clientCount }}</h4>
                                                    </div>
                                                    <div id="crm-total-customers"></div>
                                                </div>
                                                <div class="d-flex align-items-center justify-content-between mt-1">
                                                    <div>
                                                        <router-link :to="{name:'user'}" class="text-primary">
                                                            {{$t('global.viewAll')}}<i class="ti ti-arrow-narrow-right ms-2 fw-semibold d-inline-block"></i>
                                                        </router-link>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-6 col-lg-6 col-md-6">
                                <div class="card custom-card overflow-hidden">
                                    <div class="card-body">
                                        <div class="d-flex align-items-top justify-content-between">
                                            <div>
                                                <span class="avatar avatar-md avatar-rounded bg-success">
                                                    <i class="ti ti-package fs-16"></i>
                                                </span>
                                            </div>
                                            <div class="flex-fill ms-3">
                                                <div class="d-flex align-items-center justify-content-between flex-wrap">
                                                    <div>
                                                        <p class="text-muted mb-0">عدد المنتجات</p>
                                                        <h4 class="fw-semibold mt-1">{{ statistics.productCount }}</h4>
                                                    </div>
                                                    <div id="crm-conversion-ratio"></div>
                                                </div>
                                                <div class="d-flex align-items-center justify-content-between mt-1">
                                                    <div>
                                                        <router-link :to="{name:'product'}" class="text-success">
                                                            {{$t('global.viewAll')}}<i class="ti ti-arrow-narrow-right ms-2 fw-semibold d-inline-block"></i>
                                                        </router-link>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-6 col-lg-6 col-md-6">
                                <div class="card custom-card overflow-hidden">
                                    <div class="card-body">
                                        <div class="d-flex align-items-top justify-content-between">
                                            <div>
                                                <span class="avatar avatar-md avatar-rounded bg-secondary">
                                                    <i class="ti ti-file-invoice fs-16"></i>
                                                </span>
                                            </div>
                                            <div class="flex-fill ms-3">
                                                <div class="d-flex align-items-center justify-content-between flex-wrap">
                                                    <div>
                                                        <p class="text-muted mb-0">{{$t('global.invoicesCount')}}</p>
                                                        <h4 class="fw-semibold mt-1">{{ statistics.orderCount }}</h4>
                                                    </div>
                                                    <div id="crm-total-customers"></div>
                                                </div>
                                                <div class="d-flex align-items-center justify-content-between mt-1">
                                                    <div>
                                                        <!-- <router-link :to="{name:'invoice'}" class="text-secondary">
                                                            {{$t('global.viewAll')}}<i class="ti ti-arrow-narrow-right ms-2 fw-semibold d-inline-block"></i>
                                                        </router-link> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-6 col-lg-6 col-md-6">
                                <div class="card custom-card overflow-hidden">
                                    <div class="card-body">
                                        <div class="d-flex align-items-top justify-content-between">
                                            <div>
                                                <span class="avatar avatar-md avatar-rounded bg-warning">
                                                    <i class="ti ti-report-money fs-16"></i>
                                                </span>
                                            </div>
                                            <div class="flex-fill ms-3">
                                                <div class="d-flex align-items-center justify-content-between flex-wrap">
                                                    <div>
                                                        <p class="text-muted mb-0">{{$t('global.totalInvoiceRevenue')}}</p>
                                                        <h4 class="fw-semibold mt-1">{{ statistics.invoiceRevenue }} {{ statistics.setting?.translation?.title }}</h4>
                                                    </div>
                                                    <div id="crm-conversion-ratio"></div>
                                                </div>
                                                <div class="d-flex align-items-center justify-content-between mt-1">
                                                    <div>
                                                        <!-- <router-link :to="{name:'invoice'}" class="text-warning">
                                                            {{$t('global.viewAll')}}<i class="ti ti-arrow-narrow-right ms-2 fw-semibold d-inline-block"></i>
                                                        </router-link> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="card custom-card">
                                    <div class="card-header">
                                        <div class="card-title">{{$t('global.invoiceStatisticsMonth')}}</div>
                                    </div>
                                    <div class="card-body">
                                        <div id="area-basic"></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-xl-3">
                <div class="row">
                    <div class="col-xxl-12 col-xl-12">
                        <div class="row">

                            <div class="col-xxl-12 col-xl-12">
                                <div class="card custom-card">
                                    <div class="card-header justify-content-between">
                                        <div class="card-title">
                                            احصائيات الطلبات
                                        </div>
                                    </div>
                                    <div class="card-body p-0 overflow-hidden">
                                        <div class="leads-source-chart d-flex align-items-center justify-content-center">
                                            <canvas id="leads-source" class="chartjs-chart w-100 p-4"></canvas>
                                            <div class="lead-source-value">
                                                <span class="d-block fs-14">{{$t('global.total')}}</span>
                                                <span class="d-block fs-25 fw-bold">{{statistics.total_booking}}</span>
                                            </div>
                                        </div>
                                        <div class="row row-cols-12 border-top border-block-start-dashed">

                                            <div class="col p-0">
                                                <div class="p-3 text-center border-end border-inline-end-dashed">
                                                    <span class="text-muted fs-12 mb-1 crm-lead-legend mobile d-inline-block">{{$t('global.processing')}}</span>
                                                    <div><span class="fs-16 fw-semibold">{{ statistics.processing }}</span></div>
                                                </div>
                                            </div>
                                            <div class="col p-0">
                                                <div class="p-3 text-center">
                                                     <span class="text-muted fs-12 mb-1 crm-lead-legend tablet d-inline-block">{{$t('global.completed')}}</span>
                                                    <div><span class="fs-16 fw-semibold">{{ statistics.delivered }}</span></div>
                                                </div>
                                            </div>
                                            <div class="col p-0">
                                                <div class="p-3 text-center">
                                                     <span class="text-muted fs-12 mb-1 crm-lead-legend canceled d-inline-block">{{$t('global.canceled')}}</span>
                                                    <div><span class="fs-16 fw-semibold">{{ statistics.canceled }}</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-12 col-xl-12">
                                <div class="card custom-card">
                                        <div class="card-header  justify-content-between">
                                            <div class="card-title">
                                                اكثر 5 منتجات مبيعاً
                                            </div>

                                        </div>
                                        <div class="card-body">
                                            <ul class="list-unstyled crm-top-deals mb-0" v-if="statistics?.top_five_products_has_orders">
                                                <li v-for="item in statistics.top_five_products_has_orders" :key="item.id">
                                                    <div class="d-flex align-items-top flex-wrap">
                                                        <div class="me-2">
                                                            <span class="avatar avatar-sm avatar-rounded">
                                                                <img :src="item.image" alt="">
                                                            </span>
                                                        </div>
                                                        <div class="flex-fill">
                                                            <p class="fw-semibold mb-0">{{item.name}}</p>
                                                        </div>
                                                        <div class="fw-semibold fs-15">{{item.order_items_count}}</div>
                                                    </div>
                                                </li>


                                            </ul>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End::row-1 -->
    </div>
</template>

<script>
import {onMounted, ref} from "vue";
import adminApi from "../../../api/adminAxios";
import {useI18n} from "vue-i18n";
import Cookies from "js-cookie";
import CurrentMonthAndLastMonthDevidedWeeks from "./CurrentMonthAndLastMonthDevidedWeeks.vue";
import ChartForTotalAmountAndCountOfEachMonthInYear from "./ChartForTotalAmountAndCountOfEachMonthInYear.vue";
import ChartForPeakPeriods from "./ChartForPeakPeriods.vue";

export default {
    components:{
        CurrentMonthAndLastMonthDevidedWeeks,
        ChartForTotalAmountAndCountOfEachMonthInYear,
        ChartForPeakPeriods
    },
    setup(){
        const {t} = useI18n({});
        const user_name = ref('');
        const loading = ref(false);
        const statistics = ref('');
        const bookingStatistics = ref([]);

        let getData = (page = 1) => {
            loading.value = true;

            adminApi.get(`dashboard/statistics`)
                .then((res) => {
                    let l = res.data.data;
                    statistics.value = l;
                    clientStatistics(l.clientActiveCount,l.clientDeActiveCount);
                    invoiceChart(l.invoiceStatisticsMonth);

                    let booking_statistics = [];
                    booking_statistics.push(l.processing);
                    booking_statistics.push(l.delivered);
                    booking_statistics.push(l.canceled);
                    bookingStatistics.value = booking_statistics;
                    bookingStatisticsChart();

                })
                .catch((err) => {
                    loading.value = false;
                })
                .finally(() => {
                    loading.value = false;
                });
        }

        onMounted(() => {
            if (Cookies.get("tokenAdmin")){
                user_name.value = JSON.parse(localStorage.getItem("user")).name;
            }
            getData();

        });

        /* booking Statistics Chart */
        let bookingStatisticsChart = () => {
            Chart.defaults.elements.arc.borderWidth = 0;
            Chart.defaults.datasets.doughnut.cutout = '85%';
            var chartInstance = new Chart(document.getElementById("leads-source"), {
                type: 'doughnut',
                data: {
                    datasets: [{
                        label: 'My First Dataset',
                        data: bookingStatistics.value || '',
                        backgroundColor: [
                            'rgb(245, 184, 73)',
                            'rgb(38, 191, 148)',
                            'rgb(230, 83, 60)',

                        ]
                    }]
                },
                plugins: [{
                    afterUpdate: function (chart) {
                        const arcs = chart.getDatasetMeta(0).data;

                        arcs.forEach(function (arc) {
                            arc.round = {
                                x: (chart.chartArea.left + chart.chartArea.right) / 2,
                                y: (chart.chartArea.top + chart.chartArea.bottom) / 2,
                                radius: (arc.outerRadius + arc.innerRadius) / 2,
                                thickness: (arc.outerRadius - arc.innerRadius) / 2,
                                backgroundColor: arc.options.backgroundColor
                            }
                        });
                    },
                    afterDraw: (chart) => {
                        const {
                            ctx,
                            canvas
                        } = chart;

                        chart.getDatasetMeta(0).data.forEach(arc => {
                            const startAngle = Math.PI / 2 - arc.startAngle;
                            const endAngle = Math.PI / 2 - arc.endAngle;

                            ctx.save();
                            ctx.translate(arc.round.x, arc.round.y);
                            ctx.fillStyle = arc.options.backgroundColor;
                            ctx.beginPath();
                            ctx.arc(arc.round.radius * Math.sin(endAngle), arc.round.radius * Math.cos(endAngle), arc.round.thickness, 0, 2 * Math.PI);
                            ctx.closePath();
                            ctx.fill();
                            ctx.restore();
                        });
                    }
                }]
            });

        }

        /* invoice chart */
        let invoiceChart = (invoiceStatisticsMonth = []) => {
            let prices = [];
            let dates = [];
            invoiceStatisticsMonth.forEach(function(el) {
                prices.push(el.total_amount);
                dates.push(el.day);
            });
            var options = {
                series: [{
                    name: t('global.amount'),
                    data: prices
                }],
                chart: {
                    type: 'area',
                    height: 320,
                    zoom: {
                        enabled: true
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'straight',
                },
                subtitle: {
                    text: t('global.paymentMoves'),
                    align: 'left'
                },
                grid: {
                    borderColor: '#f2f5f7',
                },
                labels: dates,
                title: {
                    text: t('global.AnalysisOfBillCollectionsDuringTheMonth'),
                    align: 'left',
                    style: {
                        fontSize: '13px',
                        fontWeight: 'bold',
                        color: '#8c9097'
                    },
                },
                colors: ['#845adf'],
                xaxis: {
                    type: 'datetime',
                    labels: {
                        show: true,
                        style: {
                            colors: "#8c9097",
                            fontSize: '11px',
                            fontWeight: 600,
                            cssClass: 'apexcharts-xaxis-label',
                        },
                    }
                },
                yaxis: {
                    opposite: true,
                    labels: {
                        show: true,
                        style: {
                            colors: "#8c9097",
                            fontSize: '11px',
                            fontWeight: 600,
                            cssClass: 'apexcharts-xaxis-label',
                        },
                    }
                },
                legend: {
                    horizontalAlign: 'left'
                }
            };
            var chart = new ApexCharts(document.querySelector("#area-basic"), options);
            chart.render();
        }

        /* client chart */
        let clientStatistics = (clientActiveCount = 0,clientDeActiveCount = 0) =>{
            var options = {
                series: [ clientActiveCount, clientDeActiveCount],
                chart: {
                    height: 300,
                    type: "pie",
                },
                colors: ["#845adf", "#e6533c"],
                labels: [t('global.activated'), t('global.Inactive')],
                legend: {
                    position: "bottom",
                },
                dataLabels: {
                    dropShadow: {
                        enabled: false,
                    },
                },
            };
            var chart = new ApexCharts(document.querySelector("#client-statistics"), options);
            chart.render();
        };

        return {user_name,statistics};
    },
    data(){
      return {
      }
    },
    mounted(){
    }
}
</script>

<style scoped>
.crm-lead-legend.mobile:before {
    background-color: rgb(245, 184, 73) !important;
}
.crm-lead-legend.desktop:before {
    background-color: rgb(132, 90, 223) !important;
}
.crm-lead-legend.laptop:before {
    background-color: rgb(73, 182, 245) !important;
}
.crm-lead-legend.tablet:before {
    background-color: rgb(38, 191, 148) !important;
}
.crm-lead-legend.canceled:before {
    background-color: rgb(230, 83, 60) !important;
}

</style>
