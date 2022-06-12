<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import PaymentsTable from "@/Components/PaymentsTable.vue";
import { Head, useForm } from "@inertiajs/inertia-vue3";
import { Inertia } from '@inertiajs/inertia'
import { ref, reactive } from "vue";


const props = defineProps({
    exemplData: Array,
    month: Number,
    year: Number
});

console.log(props.exemplData);
const form = useForm({
    month: new Date().getMonth(),
    year: new Date().getFullYear(),
    file: null
})

function getExampl () {
    form.post('/payments/create')
}
function storeData () {
    processData.value = true;
    form.post('/payments/import')
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
    console.log('exemplData', exemplData);
    return exemplData
}





</script>

<template>

    <Head title="Загрузить" />

    <MainLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Загрузить Выплаты
            </h2>
        </template>


        <div class="py-16">
            <!-- Фильтры -->
            <form @submit.prevent="getExampl" class="md:flex md:flex-col ">
                <div class=" md:gap-4 md:flex  mx-auto justify-center ">
                    <div
                        class="bg-white h-14 flex items-baseline   pt-2 shadow-md rounded-md  mx-auto w-1/2  md:w-1/4  ">
                        <label for="year" name="year" class="px-4 border-r border-systems-900/20 ">Год</label>
                        <div class=" mb-3 px-2  ">
                            <input v-model="form.year" type="text" class=" h-10 rounded-md w-11/12">
                        </div>
                    </div>
                    <div class="bg-white flex items-baseline my-5 md:my-0  h-14 pt-2 shadow-md rounded-md mx-auto ">
                        <label for="month" class="px-4 border-r border-systems-900/20">Месяц</label>
                        <div class="mb-3 ">
                            <select id="year" v-model="form.month" @change="selectedRange"
                                class=" form-select cursor-pointer focus:ring-0 ring-0 border-0 bg-transparent "
                                aria-label="year">
                                <option v-for="i in 12">{{ i }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="bg-white flex items-center   h-14  shadow-md rounded-md w-full md:w-2/4 ">
                        <input
                            class=" block w-full text-sm text-gray-500 file:mr-4 file:py-1 px-0 m-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-systems-600 file:text-white hover:file:bg-systems-500 file:cursor-pointer "
                            type="file" @input="form.file = $event.target.files[0]" />
                        <div class="mb-3 ">

                        </div>
                    </div>
                </div>
                <div class=" py-5 w-fit  mx-auto ">
                    <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                        {{ form.progress.percentage }}%
                    </progress>
                </div>

                <button v-if="!props.exemplData"
                    class="bg-systems-800 rounded-md text-white shadow-md px-4 py-2 w-1/3 mx-auto"
                    type="submit">Проверить</button>

                <div v-if="props.exemplData && !processData" @click="storeData"
                    class="bg-green-600 text-white text-center cursor-pointer rounded-md shadow-md px-4 py-1 w-1/3 mx-auto">
                    Если
                    данные подтянулись верно - нажмите чтобы сохранить</div>

                <div v-if="processData" class="mx-auto">
                    <div class="animate-spin   text-8xl">.</div>
                    Обработка
                </div>
            </form>



            <div v-if="props.exemplData" class=" mt-8  w-fit  mx-auto">
                <PaymentsTable showRecruiter showBonus :payments="createExempl(props.exemplData)"></PaymentsTable>
            </div>

        </div>
    </MainLayout>
</template>