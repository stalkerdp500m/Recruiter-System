<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import PaymentsTable from "@/Components/PaymentsTable.vue";
import { Head } from "@inertiajs/inertia-vue3";
import { Inertia } from '@inertiajs/inertia'
import { ref } from "vue";
const props = defineProps({
    payments: Object,
    ranges: Object,
    filters: Object
});

const currenYear = props.filters.year ? props.filters.year : Object.keys(props.ranges).reverse()[0]// последний ключь-год
const currenMonth = props.filters.month ? props.filters.month : props.ranges[currenYear][0]


const rangeModel = {
    'year': currenYear,
    'month': currenMonth
}

function selectedRange () {
    Inertia.get('/payments', rangeModel)
}


function recruiterAllSum (recruiter) {

    let sumForRecruits = 0;
    let sumForAdd = 0;
    let count = 0;
    recruiter.payments.forEach(paym => {
        if (paym.bonus > 0) {
            sumForRecruits += paym.bonus;
            count++
        }
    });
    sumForAdd += sumForRecruits;
    recruiter.add_payments.forEach(paym => {
        if (paym.summ) {
            sumForAdd += Number(paym.summ);
        }
    });
    return {
        'sumForRecruits': sumForRecruits,
        'sumForAdd': sumForAdd,
        'count': count
    };
}


</script>

<template>

    <Head title="Выплаты" />

    <MainLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Выплаты
            </h2>
        </template>

        <!-- Фильтры -->
        <div
            class="pt-10 md:px-8 2xl:px-56 grid  grid-flow-col overflow-x-clip justify-start md:gap-4   items-center md:w-2/3  ">
            <div class="bg-white  flex items-baseline justify-start  pt-2 shadow-md rounded-md w-11/12 md:w-fit ">
                <label for="year" name="year" class="px-4 border-r border-systems-900/20 ">Год</label>
                <div class="mb-3  ">
                    <select id="year" v-model="rangeModel.year" @change="selectedRange"
                        class=" form-select cursor-pointer focus:ring-0 ring-0 border-0 mr-5 bg-transparent "
                        aria-label="year">
                        <option v-for="month, year in props.ranges">{{ year }}</option>

                    </select>
                </div>
            </div>
            <div class="bg-white flex items-baseline justify-start  pt-2 shadow-md rounded-md w-11/12 md:w-fit">
                <label for="month" class="px-4 border-r border-systems-900/20">Месяц</label>
                <div class="mb-3 ">
                    <select v-model="rangeModel.month" @change="selectedRange" id="month" name="month"
                        class="cursor-pointer form-select focus:ring-0 ring-0 border-0 mr-5 bg-transparent">
                        <option v-for="month in props.ranges[rangeModel.year]">{{ month }}</option>
                    </select>
                </div>
            </div>
        </div>
        <!-- /Фильтры -->

        <div class="py-2 md:w-full  mx-auto">

            <div class=" mx-auto sm:px-6 lg:px-8 ">
                <div class=" text-center p-10 font-bold bg-systems-600 rounded-sm my-10 shadow-xl"
                    v-if="props.payments.recruiters.length == 0">Нет рекрутеров для отбражения, пожалуйста обратитесь к
                    администратору</div>

                <div v-for="recruiter in props.payments.recruiters" :key="recruiter.id"
                    class="bg-white overflow-hidden shadow-sm rounded-lg my-5  transition-all">

                    <div @click="recruiter.show = !recruiter.show"
                        class="p-6  text-lg  bg-white  border-systems-200 overflow-hidden cursor-pointer">
                        <div class="font-semibold pr-2"> {{ recruiter.name }}
                            <span class="font-bold text-systems-800"> {{ `${recruiterAllSum(recruiter).sumForAdd} PLN`
                            }} </span>

                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-2 inline" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>

                        </div>
                        <div class="font-semibold text-sm">
                            <div class="text-green-800 "> {{
                                    `${recruiterAllSum(recruiter).sumForRecruits} PLN за ${recruiterAllSum(recruiter).count}
                            рекрутаций` }}</div>
                            <div v-for="addPaym in recruiter.add_payments">
                                <span
                                    :class="addPaym.summ < 0 ? 'text-red-700' : `text-green-800 before:content-['+']`">
                                    {{ `${addPaym.summ} PLN` }}
                                    {{ addPaym.type }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div :class="recruiter.show || props.payments.recruiters.length == 1 ? '' : 'opacity-0 hidden'"
                        class=' transition-all overflow-auto overflow-y-hidden h-fit px-2 md:px-10 py-5 '>
                        <PaymentsTable showBonus :payments="recruiter.payments"></PaymentsTable>
                    </div>

                </div>
            </div>
        </div>
    </MainLayout>
</template>