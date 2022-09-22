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
    recruiterPaymentsCount: Object,
    periodList: Object,
    queryFilter: Object
});


const recruitersData = ref([]);
const recruitersShortList = ref([]);


const periodModel = reactive(
    {
        'start': props.queryFilter.start,
        'end': props.queryFilter.end,
    }
)
const recruitersList = [];

function* generateColorFunc () {
    const collorSet = [
        "rgba(33, 145, 81, 1)",
        "rgba(0, 63, 92, 1)",
        "rgba(102, 81, 145, 1)",
        "rgba(160, 81, 149, 1)",
        "rgba(212, 80, 135, 1)",
        "rgba(249, 93, 106, 1)",
        "rgba(255, 124, 67, 1)",
        "rgba(255, 166, 0, 1)",
        "rgba(44, 95, 45, 1)",
        "rgba(16, 24, 32, 1)"
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
    Inertia.get(route('dashboard'), periodModel)
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

function hoverRecruiterLegends (e, item) {
    recruitersData.value.map((recrut) => {
        if (recrut.label == item.text) {
            recrut.borderWidth = 10
            recrut.borderColor = recrut.backgroundColor = recrut.borderColor.replace(/[^,]+(?=\))/, '1')
            recrut.drawActiveElementsOnTop = true
        } else {
            recrut.borderWidth = 5
            recrut.drawActiveElementsOnTop = false
            recrut.borderColor = recrut.backgroundColor = recrut.borderColor.replace(/[^,]+(?=\))/, '0.1')
        }
    })
}
function leavHoverRecruiterLegends () {
    recruitersData.value.map((recrut) => {
        recrut.borderWidth = 5
        recrut.borderColor = recrut.backgroundColor = recrut.borderColor.replace(/[^,]+(?=\))/, '1')
    })
}


for (const recruiter in props.recruiterPaymentsCount) {
    const dataRecruiter = {};
    let color = ''
    props.recruiterPaymentsCount[recruiter].payments.map(paym => {
        dataRecruiter[`${paym.month}-${paym.year}`] = Number(paym.countpaym)
    });
    recruitersList.push(props.recruiterPaymentsCount[recruiter].name);
    color = generateColor.next().value;
    recruitersData.value.push({
        label: props.recruiterPaymentsCount[recruiter].name,
        borderColor: color,
        data: dataRecruiter,
        backgroundColor: color,
        tension: 0.1,
        borderWidth: 5,
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
    hover: {
        mode: 'dataset',
        intersect: false
    },
    hoverRadius: 7,
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
            }, onHover (e, item) {
                hoverRecruiterLegends(e, item)
            }, onLeave () {
                leavHoverRecruiterLegends()
            }
        },
        tooltip: {
            callbacks: {
                label: function (context) {
                    // console.log(context);
                    let label = context.dataset.label || '';
                    if (label) {
                        label = `${label.split(' ')[0]}: `
                    }
                    if (context.parsed.y !== null) {
                        label += ` ${context.parsed.y} рекрутаций`;
                    }
                    return label;
                },
                title: function (context) {
                    let title = context[0]?.label
                    if (title) {
                        const dateOptions = { year: 'numeric', month: 'long' };
                        return new Date(title).toLocaleDateString('ru-RU', dateOptions)
                    }
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


const { lineChartProps, linetChartRef } = useLineChart({
    'chartData': {
        'datasets': recruitersData.value
    },
    "options": options,
});


</script>

<template>

    <Head title="Аналитика" />

    <MainLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12 px-4 flex flex-col r ">
            <!-- Фильтры -->
            <div class="py-4 flex gap-1  md:gap-4 flex-wrap ">
                <div
                    class="bg-white  flex-1  box-border flex flex-wrap justify-center items-center  shadow-md rounded-md  py-1 h-14 ">
                    <label for=" start" name="start"
                        class="pr-1 md:px-4 my-auto border-r border-systems-900/20 ">От</label>
                    <select id="start" v-model="periodModel.start" @change="selectedPeriod"
                        class=" form-select   cursor-pointer focus:ring-0 ring-0 border-0  bg-transparent  "
                        aria-label="year">
                        <option v-for="period in props.periodList">{{ period.period }}</option>
                    </select>
                </div>

                <div
                    class="bg-white  flex-1  box-border flex flex-wrap justify-center items-center  shadow-md rounded-md h-14  py-1">
                    <label for="end" name="end" class="pr-1 md:px-4 my-auto border-r border-systems-900/20 ">До</label>

                    <select v-model="periodModel.end" @change="selectedPeriod" id="end" name="end"
                        class=" form-select   cursor-pointer focus:ring-0 ring-0 border-0  bg-transparent "
                        aria-label="year">
                        <option v-for="period in props.periodList">{{ period.period }}</option>
                    </select>
                </div>

                <div
                    class="bg-white   flex flex-wrap justify-center items-center  shadow-md rounded-md  py-1 md:w-3/5 w-full ">
                    <VueMultiselect @update:model-value="selectedRecruiter" :multiple="true"
                        selectLabel="добавить на график" deselectLabel="убрать с графика" v-model="recruitersShortList"
                        :options="recruitersList" placeholder="Выберите рекрутеров">
                    </VueMultiselect>
                </div>
            </div>
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

