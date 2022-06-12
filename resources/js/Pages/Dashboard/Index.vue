<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import { Head } from "@inertiajs/inertia-vue3";
import { defineComponent, defineProps, ref, reactive, computed, watch } from 'vue';
import { Chart, registerables, _adapters } from "chart.js";
import { LineChart, useDoughnutChart, useLineChart } from 'vue-chart-3';
import VueMultiselect from 'vue-multiselect'
import 'chartjs-adapter-moment';
import { Inertia } from '@inertiajs/inertia'
import { number } from "tailwindcss/lib/util/dataTypes";


const props = defineProps({
    paymentCouns: Object,
    periodList: Object,
    autoStartPeriod: Object,
    autoEndPeriod: Object,
    filters: Object
});

const recruitersData = ref([]);
const recruitersShortList = ref([]);
const currenStart = props.filters.start ? props.filters.start : props.autoStartPeriod?.period// последний ключь-год
const currenEnd = props.filters.end ? props.filters.end : props.autoEndPeriod?.period

const periodModel = reactive(
    {
        'start': currenStart,
        'end': currenEnd,
    }
)
const recruitersList = [];





function* generateColorFunc () {
    const collorSet = [
        "#003f5c",
        "#665191",
        "#a05195",
        "#d45087",
        "#f95d6a",
        "#ff7c43",
        "#ffa600",
        "#2C5F2D",
        "#101820FF"
    ]

        ;
    for (let i = 0; i < collorSet.length; i++) {
        if (i == collorSet.length - 1) {
            i = 0
        }
        yield collorSet[i];
    }
}
const generateColor = generateColorFunc();



function randColor () {
    const randomInt = (min, max) => {
        return Math.floor(Math.random() * (max - min + 1)) + min;
    };
    let h = randomInt(0, 360);
    let s = randomInt(42, 98);
    let l = randomInt(40, 90);
    return `hsl(${h},${s}%,${l}%)`;
}








function selectedPeriod () {
    Inertia.get('/', periodModel)
}

function selectedRecruiter (list) {
    recruitersData.value.map((recrut) => {
        if (list.indexOf(recrut.label) == -1) {
            recrut.hidden = true
        } else {
            recrut.hidden = false
        }
    })
}


function deleteRecruiterFromLegends (e, item) {
    if (recruitersShortList.value.length != 0) {
        recruitersShortList.value = recruitersShortList.value.filter(recrut => {
            return recrut != item.text
        })
    } else {
        recruitersShortList.value.push(item.text)
    }
    selectedRecruiter(recruitersShortList.value)
}





let color = ''
for (const paymCount in props.paymentCouns) {

    const dataRecruiter = {};
    props.paymentCouns[paymCount].map(month => {
        //dataRecruiter.push(month.countPaym)
        dataRecruiter[month.month] = month.countPaym
    });
    recruitersList.push(props.paymentCouns[paymCount][0].rucruiterName);
    color = generateColor.next().value;
    recruitersData.value.push({
        label: props.paymentCouns[paymCount][0].rucruiterName,
        borderColor: color,
        data: dataRecruiter,
        backgroundColor: color,
        tension: 0.1,
        borderWidth: 5
        //  тут добавить толщину линии в зависимости от кол-ва рекрутаций
    })
}

const chartData = computed(() => ({
    'datasets': recruitersData.value
}))



Chart.register(...registerables);

const options = {
    layout: {
        padding: {
            x: 10
        }
    },
    hoverRadius: 20,
    plugins: {
        legend: {

            'position': 'bottom',
            'labels': {
                font: {
                    size: 14,
                    color: '#000000'
                },
                filter: (item) => {
                    return !item.hidden
                }
            }, onClick: (e, item) => {
                deleteRecruiterFromLegends(e, item)
            }
        }
    },
    scales: {
        y: {

            title: {
                display: true,
                text: 'Кол-во рекрутаций'
            },
            ticks: {
                stepSize: 1
            }
        },
        x: {
            type: 'time',
            title: {
                display: true,
                text: 'Месяц'
            },
            time: {
                unit: 'month',
                parser: (kay) => { return new Date(kay.split('-')[1], kay.split('-')[0] - 1) },
                displayFormats: {
                    month: 'M-Y '
                }
            }
        }
    }
}



const { lineChartProps, linetChartRef } = useLineChart({
    'chartData': {
        'datasets': recruitersData.value
    },
    "options": options,
});


</script>

<template>

    <Head title="Dashboard" />

    <MainLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12 px-4 flex flex-col r ">
            <!-- Фильтры -->
            <div class="py-4 flex  gap-2 flex-wrap ">
                <div class="bg-white  flex flex-wrap justify-center items-center  shadow-md rounded-md  py-1 h-14 ">
                    <label for=" start" name="start"
                        class="px-1 md:px-4 my-auto border-r border-systems-900/20 ">От</label>
                    <select id="start" v-model="periodModel.start" @change="selectedPeriod"
                        class=" form-select   cursor-pointer focus:ring-0 ring-0 border-0  bg-transparent  "
                        aria-label="year">
                        <option v-for="period in props.periodList">{{ period.period }}</option>
                    </select>
                </div>

                <div class="bg-white  flex flex-wrap justify-center items-center  shadow-md rounded-md h-14  py-1">
                    <label for="end" name="end" class="px-1 md:px-4 my-auto border-r border-systems-900/20 ">До</label>

                    <select v-model="periodModel.end" @change="selectedPeriod" id="end" name="end"
                        class=" form-select   cursor-pointer focus:ring-0 ring-0 border-0  bg-transparent "
                        aria-label="year">
                        <option v-for="period in props.periodList">{{ period.period }}</option>
                    </select>
                </div>

                <div
                    class="bg-white  flex flex-wrap justify-center items-center  shadow-md rounded-md  py-1 md:w-3/5 w-full ">
                    <VueMultiselect @update:model-value="selectedRecruiter" :multiple="true"
                        selectLabel="добавить на график" deselectLabel="убрать с графика" v-model="recruitersShortList"
                        :options="recruitersList" placeholder="Выберите рекрутеров">
                    </VueMultiselect>

                    <!--  @update:model-value="selectedRecruiter"
                         <select id="recruiter" v-model="recruitersShortList" @change="selectedRecruiter" multiple
                        class=" form-multiselect  text-clip cursor-pointer focus:ring-0 ring-0 border-0  bg-transparent "
                        aria-label="year">

                        <option class="text-clip flex" v-for="(recruiter, i) in recruitersList" :key="i">
                            <div class="flex">
                                {{ recruiter }}</div>
                        </option>

                    </select> -->

                </div>
                <!-- <div class="bg-white flex items-center justify-start   shadow-md rounded-md py-1 ">
                    <label for="month" class="px-4 border-r border-systems-900/20">Конец</label>
                    <div class=" ">
                        <select v-model="periodModel.end" @change="selectedPeriod" id="end" name="end"
                            class="cursor-pointer form-select focus:ring-0 ring-0 border-0 mr-5 bg-transparent">
                            <option v-for="period in props.periodList">{{ period.period }}</option>
                        </select>
                    </div>
                </div> -->
            </div>
            <!-- /Фильтры -->
            <!-- Фильтры -->
            <!-- <div
                class="py-5   grid gap-2 md:grid-flow-col  md:justify-start md:gap-4  justify-center  items-center md:w-2/3  ">
                <div class="bg-white  flex items-baseline justify-start  pt-2 shadow-md rounded-md w-11/12 md:w-fit ">
                    <label for="year" name="year" class="px-4 border-r border-systems-900/20 ">Начало</label>
                    <div class="md:mb-3 ">
                        <select id="start" v-model="periodModel.start" @change="selectedPeriod"
                            class=" form-select cursor-pointer focus:ring-0 ring-0 border-0 mr-5 bg-transparent "
                            aria-label="year">
                            <option v-for="period in props.periodList">{{ period.period }}</option>
                        </select>
                    </div>
                </div>
                <div class="bg-white flex items-baseline justify-start  pt-2 shadow-md rounded-md w-11/12 md:w-fit">
                    <label for="month" class="px-4 border-r border-systems-900/20">Конец</label>
                    <div class="md:mb-3 ">
                        <select v-model="periodModel.end" @change="selectedPeriod" id="end" name="end"
                            class="cursor-pointer form-select focus:ring-0 ring-0 border-0 mr-5 bg-transparent">
                            <option v-for="period in props.periodList">{{ period.period }}</option>
                        </select>
                    </div>
                </div>
            </div> -->
            <!-- /Фильтры -->

            <div class="  ">
                <div class="bg-white overflow-hidden shadow-sm rounded-md">
                    <div class="p-4 bg-white border-b border-gray-200">
                        <LineChart class="h-full" v-bind="lineChartProps" />
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>
<style src="vue-multiselect/dist/vue-multiselect.css">
</style>

