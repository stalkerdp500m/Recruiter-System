<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import { Head } from "@inertiajs/inertia-vue3";
import ClientData from "@/Classes/ClientData"
import { ref } from "vue";



const props = defineProps({
    reclamation: Object,
});
console.log(props.reclamation);
const clientData = ref(new ClientData(props.reclamation?.client.pasport));





const showForm = ref(false);
const statuseShortList = ref([]);
const statuses = [];












</script>

<template>

    <Head title="Рекламации" />

    <MainLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Рекламация
            </h2>
        </template>



        <div class="py-2 md:w-full  mx-auto">



            <div v-if="clientData.haveResults" class=" bg-systems-300 mt-0 ">
                <div v-if="clientData.isEmpty" class=" text-center p-4 ">
                    Данные по этому паспорту отсутсвуют в системе</div>
                <div v-else>
                    <div class=" text-center p-4 font-semibold uppercase">Данные по клиенту
                    </div>
                    <div v-if="clientData.countPayments" class=" text-center px-4 font-bold ">
                        💸 Выплат {{ clientData.countPayments }},
                        последняя {{ clientData.maxPaymentDateLocal }},
                    </div>
                    <div v-if="clientData.countWorks" class=" text-center px-4 font-bold">
                        Работал(а) {{ clientData.countWorks }} месяца,
                        последний {{ clientData.maxWorkDateLocal }}, ⏰ часов всего {{
                                clientData.sumHours
                        }}</div>
                    <div v-if="clientData.countWorks" class=" text-center px-4 ">
                        <div v-for="(period, kay) in clientData.sequencePeriods">
                            Работал(а) {{ period.count }} месяца подряд с {{ period.started }} по {{ kay }}
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </MainLayout>
</template>
<style src="vue-multiselect/dist/vue-multiselect.css">
</style>