<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import { Head } from "@inertiajs/inertia-vue3";
import { defineComponent, defineProps } from 'vue';
import { LineChart } from 'vue-chart-3';
import { Chart, registerables } from "chart.js";


const props = defineProps({
    paymentCouns: Object,
    ranges: Object,
    filters: Object
});

function randColor () {
    return "#" + Math.floor(Math.random() * 16777215).toString(16).padStart(6, '0').toUpperCase();
}

console.log(props.paymentCouns)

let recruitersData = [];
for (const paymCount in props.paymentCouns) {
    const dataRecruiter = {};
    props.paymentCouns[paymCount].map(month => {
        dataRecruiter[month.month] = month.countPaym
    });
    recruitersData.push({
        label: props.paymentCouns[paymCount][0].rucruiterName,
        borderColor: randColor(),
        data: dataRecruiter,
        backgroundColor: randColor(),
    })
}

const chartData = {
    datasets: recruitersData
}
console.log(recruitersData);

Chart.register(...registerables);

const options = {
    layout: {
        padding: {
            x: 10
        }
    },
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
            }
        },
        x: {
            title: {
                display: true,
                text: 'Месяц'
            }
        }
    }
}

const paymentsData = {
    datasets: [
        {
            label: 'рекрутер 1',
            borderColor: '#FF0000',
            data: {
                '1-2022': 50, '3-2022': 40, '5-2022': 70,
            },
            backgroundColor: '#77CEFF',
        },
        {
            label: 'рекрутер 2',
            borderColor: '#008080',
            data: {
                'Paris': 90, 'dgdd': 50,
            },
            backgroundColor: '#77CEFF',
        },
    ]
}
</script>

<template>

    <Head title="Dashboard" />

    <MainLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">

            <div class=" mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 bg-white border-b border-gray-200">
                        <LineChart class="h-full" :chartData="chartData" :options="options" />
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>
