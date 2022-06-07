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

console.log(props.paymentCouns)

for (const paymCount in props.paymentCouns) {
    console.log(props.paymentCouns[paymCount]);
}

Chart.register(...registerables);

const options = {
    scales: {
        y: {
            title: {
                display: true,
                text: 'Кол-во рерутаций'
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
    labels: ['Paris', 'Nîmes', 'Toulon', 'Perpignan', 'Autre'],
    datasets: [
        {
            label: 'рекрутер 1',
            borderColor: '#FF0000',
            data: [30, 40, 60, 70, 105],
            backgroundColor: '#77CEFF',
        },
        {
            label: 'рекрутер 2',
            borderColor: '#008080',
            data: [10, 300, 60, 250, 95],
            backgroundColor: '#77CEFF',
        }, {
            label: 'рекрутер 3',
            borderColor: 'grean',
            data: [15, 3, 60, 250, 95],
            backgroundColor: '#77CEFF',
        }
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
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <LineChart :chartData="paymentsData" :options="options" />
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>
