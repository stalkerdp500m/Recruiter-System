<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import ReclamationForm from "@/Components/ReclamationForm.vue";
import ReclamationList from "@/Components/ReclamationList.vue";
import VueMultiselect from 'vue-multiselect'
import { useForm } from "@inertiajs/inertia-vue3";
import { Head } from "@inertiajs/inertia-vue3";
import { ref } from "vue";

const props = defineProps({
    periodList: Object,
    recruiterList: Object,
    reclamations: Object,
    statuseList: Object
});

console.log(props.reclamations);
console.log(props.statuseList);

const showForm = ref(false);
const statuseShortList = ref([])
const statuses = [] // тут записывать статусы в массив



const searchReclamation = useForm({
    'pasport': ''
})

function selectedRecruiter (list) {
    log(list)
}

</script>

<template>

    <Head title="Рекламации" />

    <MainLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Рекламации
            </h2>
        </template>



        <div class="py-2 md:w-full  mx-auto">
            <div class="flex h-20 items-center px-10">
                <div @click="showForm = true"
                    class="bg-systems-800 rounded-md text-white shadow-md px-4 py-2  text-center cursor-pointer flex">
                    Добавить рекламацию
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-3 " fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <!-- Фильтры
            поиск, фильтр статусы, архивные
            -->
            <div class="  rounded-md w-full h-20 gap-2  flex items-center justify-center">
                <div class=" w-2/6  justify-center flex items-center ">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4   -mr-5 z-10 hidden md:inline " fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input @type="text" v-model="searchReclamation.pasport"
                        class="rounded-md h-10 md:pl-8 w-full md:w-4/5" placeholder="Найти по паспорту">
                </div>
                <div class=" w-3/6 h-20 ">
                    <VueMultiselect @update:model-value="selectedRecruiter" :multiple="true"
                        selectLabel="добавить на график" deselectLabel="убрать с графика" v-model="statuseShortList"
                        :options="statuses" placeholder="Выберите рекрутеров">
                    </VueMultiselect>
                </div>
                <div class=" w-1/6 bg-black h-20 "></div>

            </div>
            <!-- /Фильтры -->


            <div>
                <ReclamationList :reclamations="props.reclamations" />
            </div>

            <ReclamationForm :periodList="props.periodList" :recruiterList="props.recruiterList" searchPasport="{a:b}"
                :showForm="showForm" @hide="showForm = false" />
        </div>
    </MainLayout>
</template>