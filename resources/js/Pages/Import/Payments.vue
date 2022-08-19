<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import PaymentsTable from "@/Components/PaymentsTable.vue";
import { Head, useForm } from "@inertiajs/inertia-vue3";
import { ref } from "vue";


const props = defineProps({
    exemplData: Array,
    dopBonusData: Array,
    month: Number,
    year: Number
});


const form = useForm({
    month: new Date().getMonth(),
    year: new Date().getFullYear(),
    file: null
})

function getExampl () {
    form.post('./payments')
}
function storeData () {
    processData.value = true;
    form.post('./payments/store')
}

const processData = ref(false);

let exemplData = {};

function createExempl (rawData) {
    exemplData = rawData.map(paym => {
        return {
            'month': props.month,
            'year': props.year,
            'client': {
                'pasport': paym?.prac_identyfikator,
                'name': paym?.prac_nazwiskoimie
            },
            'recruiter': {
                'name': paym?.prac_rekruternazwiskoimie
            },
            'project': paym?.proj_nazwa,
            'hours': paym?.godziny_uop_enova,
            'bonus': paym?.premrek_kwotapremii_brutto,
            'category': paym?.projrek_kategoriaprojektudopremii,
            'status': paym?.status_wyplaty,

        }
    })
    return exemplData
}





</script>

<template>

    <Head title="Загрузить выплаты" />

    <MainLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Загрузить Выплаты
            </h2>
        </template>
        <div class="py-16">
            <!-- Фильтры -->
            <form @submit.prevent="getExampl" class="">
                <div class="flex gap-2 flex-wrap justify-center overflow-clip">

                    <div
                        class="flex-auto md:w-1/5 w-1/3  h-14 flex items-baseline   pt-2 shadow-md rounded-md bg-white ">
                        <label for="year" name="year" class="px-4 border-r border-systems-900/20 ">Год</label>
                        <div class=" mb-3 px-2 flex ">
                            <input v-model="form.year" type="text" class=" h-10 rounded-md w-10/12">
                        </div>
                    </div>
                    <div
                        class="flex-auto md:w-1/5 w-1/3 h-14 flex items-baseline   pt-2 shadow-md rounded-md bg-white ">
                        <label for="month" name="month" class="px-4 border-r border-systems-900/20 ">Месяц</label>
                        <div class=" mb-3 px-2   w-6/12">
                            <select id="month" v-model="form.month" @change="selectedRange"
                                class=" form-select cursor-pointer focus:ring-0 ring-0 border-0 bg-transparent "
                                aria-label="year">
                                <option v-for="i in 12">{{ i }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex-auto w-2/4      h-14 flex items-baseline   pt-2 shadow-md rounded-md bg-white ">
                        <input
                            class=" block w-full text-sm text-gray-500 file:mr-4 file:py-1 px-0 m-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-systems-600 file:text-white hover:file:bg-systems-500 file:cursor-pointer "
                            type="file" required @input="form.file = $event.target.files[0]" />
                    </div>
                </div>
                <div class="py-5 mx-auto flex">
                    <button v-if="!props.exemplData"
                        class="bg-systems-800 rounded-md text-white shadow-md px-4 py-2 w-1/3 mx-auto"
                        type="submit">Проверить</button>
                </div>
                <div v-if="props.exemplData && !processData" @click="storeData"
                    class="bg-systems-800 rounded-md text-white shadow-md px-4 py-2 w-1/3 mx-auto text-center cursor-pointer">
                    Сохранить</div>

                <div class=" py-5 w-fit  mx-auto ">
                    <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                        {{ form.progress.percentage }}%
                    </progress>
                </div>
                <div v-if="processData" class="fixed z-10 inset-0 overflow-y-auto">
                    <div class="flex items-end sm:items-center justify-center min-h-full p-4 text-center sm:p-0">
                        <div class="fixed inset-0 bg-systems-500/80 transition-opacity"></div>
                        <div
                            class="relative my-auto bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-lg sm:w-full">
                            <div class="bg-white">
                                <div class=" p-4 bg-white text-center rounded-md">
                                    <div class="animate-spin text-systems-800  text-8xl">.</div>
                                    <span class="font-bold"> Обработка. <br>Не закрывайте окно</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>





            </form>
            <div v-if="props.dopBonusData" class="overflow-x-auto ">

                <table class='mx-auto   rounded-lg bg-white divide-y divide-systems-300'>
                    <thead>
                        <tr class="font-semibold text-sm uppercase  text-center  ">
                            <th colspan="5" class="pb-6 pt-2"> Дополнтиельные выплаты</th>
                        </tr>
                        <tr class=" text-center">
                            <th class="font-semibold text-sm uppercase px-6 py-4 text-left"> Фактура </th>
                            <th class="font-semibold text-sm uppercase px-6 py-4 text-left"> Рекрутер </th>
                            <th class="font-semibold text-sm uppercase px-6 py-4 text-center"> Доплата за офис </th>
                            <th class="font-semibold text-sm uppercase px-6 py-4"> Коректировка премии </th>
                            <th class="font-semibold text-sm uppercase px-6 py-4"> Долг прошлый месяц </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-systems-200">
                        <tr v-for="recruitDop in props.dopBonusData">
                            <td class="px-6 py-4 ">
                                {{ props.month }}-{{ props.year }}
                            </td>
                            <td class="px-6 py-4 ">
                                {{ recruitDop.prac_rekruternazwiskoimie }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                {{ recruitDop.premrek_doplatazabiuro }} PLN
                            </td>
                            <td class="px-6 py-4 text-center">
                                {{ recruitDop.rekruter_korektapremii }} PLN
                            </td>
                            <td class="px-6 py-4 text-center">
                                {{ recruitDop.premrek_rekruterdlugpoprzednimiesiac }} PLN
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div v-if="props.exemplData" class=" mt-8   bg-white  mx-auto overflow-x-auto">
                <PaymentsTable showRecruiter showBonus :payments="createExempl(props.exemplData)"></PaymentsTable>
            </div>

        </div>
    </MainLayout>
</template>