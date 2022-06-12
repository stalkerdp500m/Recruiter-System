<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import { Head } from "@inertiajs/inertia-vue3";
import PaymentsTable from "@/Components/PaymentsTable.vue";
import SalariesTable from "@/Components/SalariesTable.vue";
import { Inertia } from '@inertiajs/inertia';
import { ref, reactive } from "vue";
const props = defineProps({
    searchPasport: Object,
    searchResults: Object,
});

console.log(props.searchResults);

const client = {
    'name': props.searchResults?.name,
    'pasport': props.searchResults?.pasport
}

const payments = props.searchResults?.payments.map(element => {
    return { ...element, client };
});
const salaries = props.searchResults?.salaries.map(element => {
    return { ...element, client };
});


const searchPasport = reactive({
    'pasport': props.searchPasport.pasport ? props.searchPasport.pasport : '',
});

const beforeSearch = ref(true)

function serchClient () {
    Inertia.get('/clients', searchPasport);
    beforeSearch.value = true;
}
</script>

<template>

    <Head title="Клиенты" />

    <MainLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Клиенты
            </h2>
        </template>

        <div class="py-2 md:w-full mx-auto ">
            <!-- Инструкция -->
            <div class="text-center text-2xl font-bold p-4   transition-all">
                <span v-if="searchPasport.pasport.length < 6 || !searchPasport.pasport"> Введите паспорт клиента для
                    поиска
                </span>
                <span v-else-if="!beforeSearch">Нажмите кнопку поиск</span>
                <span v-else>Результаты Поиска</span>
            </div>
            <!-- /Инструкция -->

            <!-- Поиск -->
            <div>
                <form @submit.prevent="serchClient" class=" flex justify-center py-5 gap-2 flex-wrap">
                    <input @input="beforeSearch = false" type="text" v-model="searchPasport.pasport"
                        class="rounded-md w-2/5 " placeholder="Паспорт клиента">
                    <button :disabled="searchPasport.pasport.length < 6" type="submit"
                        class="rounded-md px-3 disabled:bg-gray-500/60  py-2 bg-systems-700  cursor-pointer text-white flex flex-row items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 " fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Искать
                    </button>
                </form>
            </div>
            <!-- /Поиск -->

            <!-- Результаты -->
            <div v-if="beforeSearch && searchPasport.pasport && searchPasport.pasport != ''" class="pb-16 md:mx-10 ">
                <div class="mx-auto p-2 bg-white  shadow-sm rounded-md my-4">
                    <div v-if="payments" class=" transition-all h-fit px-2 md:px-10 overflow-y-clip">
                        <div class="text-center text-2xl font-bold py-4 "> Выплаты по клиенту </div>
                        <div class=" overflow-x-auto overflow-y-clip py-4">
                            <PaymentsTable showRecruiter :payments="payments"></PaymentsTable>
                        </div>
                    </div>
                    <div v-else class="font-bold text-2xl text-center ">Выплаты отсутсвуют</div>
                </div>
                <div class="mx-auto p-2 bg-white   shadow-sm rounded-md ">
                    <div v-if="salaries" class=' transition-all h-fit px-2 md:px-10 '>
                        <div class="text-center text-2xl font-bold py-4 "> Wynagrodzenia по клиенту </div>
                        <div class=" overflow-x-auto overflow-y-clip py-4 ">
                            <SalariesTable showRecruiter :salaries="salaries"></SalariesTable>
                        </div>
                    </div>
                    <div v-else class="font-bold text-2xl text-center ">Wynagrodzenia отсутсвуют</div>
                </div>
            </div>
            <!-- Результаты -->
        </div>
    </MainLayout>

</template>
