<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import PaymentsTable from "@/Components/PaymentsTable.vue";
import { Head } from "@inertiajs/inertia-vue3";
import { Inertia } from '@inertiajs/inertia'
import { ref, reactive } from "vue";
const props = defineProps({
    payments: Object,
    ranges: Object,
    filters: Object
});
const currenYear = props.filters.year ? props.filters.year : Object.keys(props.ranges).reverse()[0]// последний ключь-год
const currenMonth = props.filters.month ? props.filters.month : props.ranges[currenYear][0]

const rangeModel = reactive(
    {
        'year': currenYear,
        'month': currenMonth
    }
)

function selectedRange () {
    console.log(rangeModel.value);
    Inertia.get('/payments', rangeModel)
}

console.log(props.ranges[currenYear][0]);

// function paymentsSum (payments) {
//     let sum = 0;
//     let count = 0;
//     payments.forEach(paym => {
//         if (paym.bonus > 0) {
//             sum += paym.bonus;
//             count++
//         }
//     });
//     return `всего ${sum} PLN за ${count} клиентов`;
// }
// console.log(props.payments);
</script>

<template>

    <Head title="Dashboard" />

    <MainLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Выплаты
            </h2>
        </template>

        <div class="pt-10 md:px-8 2xl:px-56 flex flex-row items-center">
            <div class="bg-white flex items-baseline justify-start mr-1 pt-2 shadow-md">
                <label for="year" name="year" class="px-4">Год</label>
                <div class="mb-3  ">
                    <select id="year" v-model="rangeModel.year" @change="selectedRange"
                        class=" form-select focus:ring-0 ring-0 border-0 mr-5 bg-transparent " aria-label="year">
                        <option v-for="month, year in props.ranges">{{ year }}</option>

                    </select>
                </div>
            </div>
            <div class="bg-white flex items-baseline justify-start mr-1 pt-2 shadow-md">
                <label for="month" class="px-4">Месяц</label>
                <div class="mb-3 ">
                    <select v-model="rangeModel.month" @change="selectedRange" id="month" name="month"
                        class="form-select focus:ring-0 ring-0 border-0 mr-5 bg-transparent">
                        <option v-for="month in props.ranges[rangeModel.year]">{{ month }}</option>
                    </select>
                </div>
            </div>

        </div>

        <div class="py-2">
            <PaymentsTable :payments="props.payments"></PaymentsTable>
        </div>
    </MainLayout>
</template>