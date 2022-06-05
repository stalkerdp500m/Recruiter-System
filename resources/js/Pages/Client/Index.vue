<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import { Head } from "@inertiajs/inertia-vue3";
import PaymentsTable from "@/Components/PaymentsTable.vue";
import { Inertia } from '@inertiajs/inertia';
import { reactive } from "vue";
const props = defineProps({
    payments: Object,
});
// VVXDOPH7W7N
console.log(props.payments);
const searchPasport = reactive({
    'pasport': ''
});
function serchClient () {
    console.log(searchPasport.pasport);
    Inertia.get('/clients', searchPasport)
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

        <!-- Поиск -->
        <div class="py-10 md:px-8 2xl:px-56  items-center flex">
            <div
                class="px-10  py-4 max-w-fit  grid grid-flow-col gap-2 justify-center   items-center w-full  bg-white shadow-sm rounded-md ">
                <div class=" ">

                    <input type="text" v-model="searchPasport.pasport" class="rounded-md" placeholder="Паспорт клиента">

                </div>
                <div class=" ">

                    <div @click="serchClient"
                        class="px-3  py-2 bg-systems-700 rounded-sm cursor-pointer text-white flex flex-row items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 " fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Искать
                    </div>

                </div>

            </div>
        </div>
        <!-- /Поиск -->
        <div class=' transition-all overflow-auto px-2 md:px-10'>
            <PaymentsTable v-if="props.payments" :payments="props.payments.payments"></PaymentsTable>
        </div>


    </MainLayout>
</template>
