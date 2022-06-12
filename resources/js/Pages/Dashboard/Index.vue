<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import { Head } from "@inertiajs/inertia-vue3";
import { defineComponent, defineProps, ref, reactive, computed } from 'vue';
import { Chart, registerables, _adapters } from "chart.js";
import { LineChart, useDoughnutChart } from 'vue-chart-3';
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
const recruitersList = [];
const recruitersShortList = ref(recruitersList);


function randColor () {
    const randomInt = (min, max) => {
        return Math.floor(Math.random() * (max - min + 1)) + min;
    };
    let h = randomInt(0, 360);
    let s = randomInt(42, 98);
    let l = randomInt(40, 90);
    return `hsl(${h},${s}%,${l}%)`;
}

const currenStart = props.filters.start ? props.filters.start : props.autoStartPeriod?.period// последний ключь-год
const currenEnd = props.filters.end ? props.filters.end : props.autoEndPeriod?.period

const periodModel = reactive(
    {
        'start': currenStart,
        'end': currenEnd,
        'recruiterList': recruitersList
    }
)




function selectedPeriod () {
    Inertia.get('/', periodModel)
}

function selectedRecruiter () {

    console.log(recruitersData);
    recruitersData.value.map((recrut) => {
        if (recruitersShortList.value.indexOf(recrut.label) == -1) {
            recrut.hidden = true
        } else {
            recrut.hidden = false
        }
    })

}





let color = ''
for (const paymCount in props.paymentCouns) {
    console.log('paymCount', paymCount);
    const dataRecruiter = {};
    props.paymentCouns[paymCount].map(month => {
        //dataRecruiter.push(month.countPaym)
        dataRecruiter[month.month] = month.countPaym
    });
    recruitersList.push(props.paymentCouns[paymCount][0].rucruiterName);
    color = randColor()
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


//console.log(recruitersData);

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
                    color: 'black'
                }
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

// const paymentsData = {
//     datasets: [
//         {
//             label: 'рекрутер 1',
//             borderColor: '#FF0000',
//             data: {
//                 '1-2022': 50, '3-2022': 40, '5-2022': 70,
//             },
//             backgroundColor: '#77CEFF',
//         },
//         {
//             label: 'рекрутер 2',
//             borderColor: '#008080',
//             data: {
//                 'Paris': 90, 'dgdd': 50,
//             },
//             backgroundColor: '#77CEFF',
//         },
//     ]
// }


const { doughnutChartProps, doughnutChartRef } = useDoughnutChart({
    'chartData': {
        'datasets': recruitersData.value,
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

        <div class="py-12 px-4 flex flex-col">
            {{ recruitersShortList }}
            <!-- Фильтры -->
            <div class="py-4 flex  gap-2 flex-wrap ">
                <div class="bg-white  flex flex-wrap justify-center items-center  shadow-md rounded-md  py-1  ">
                    <label for=" start" name="start"
                        class="px-1 md:px-4 my-auto border-r border-systems-900/20 ">От</label>
                    <select id="start" v-model="periodModel.start" @change="selectedPeriod"
                        class=" form-select   cursor-pointer focus:ring-0 ring-0 border-0  bg-transparent  "
                        aria-label="year">
                        <option v-for="period in props.periodList">{{ period.period }}</option>
                    </select>
                </div>

                <div class="bg-white  flex flex-wrap justify-center items-center  shadow-md rounded-md  py-1">
                    <label for="end" name="end" class="px-1 md:px-4 my-auto border-r border-systems-900/20 ">До</label>

                    <select v-model="periodModel.end" @change="selectedPeriod" id="end" name="end"
                        class=" form-select   cursor-pointer focus:ring-0 ring-0 border-0  bg-transparent "
                        aria-label="year">
                        <option v-for="period in props.periodList">{{ period.period }}</option>
                    </select>
                </div>

                <div class="bg-white  flex flex-wrap justify-center items-center  shadow-md rounded-md  py-1  ">
                    <label for=" year" name="year"
                        class="px-1 md:px-4 my-auto border-r border-systems-900/20 ">Рекрутеры</label>

                    <select id="recruiter" v-model="recruitersShortList" @change="selectedRecruiter" multiple
                        class=" form-multiselect  text-clip cursor-pointer focus:ring-0 ring-0 border-0  bg-transparent "
                        aria-label="year">

                        <option class="text-clip flex" v-for="(recruiter, i) in recruitersList" :key="i">
                            <div class="flex">
                                {{ recruiter }}</div>
                        </option>

                    </select>

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
                        <LineChart class="h-full" v-bind="doughnutChartProps" />
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>
