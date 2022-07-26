<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import { Head } from "@inertiajs/inertia-vue3";
import SummaryClient from "@/Components/SummaryClient.vue";
import { ref } from "vue";



const props = defineProps({
    reclamation: Object,
});
const showPayments = ref(false);
const showSalaries = ref(false);
const statusColors = {
    1: { 'label': 'bg-systems-300', 'bg': 'bg-systems-100' },
    2: { 'label': 'bg-yellow-300', 'bg': 'bg-yellow-100' },
    3: { 'label': 'bg-green-300', 'bg': 'bg-green-100' },
    4: { 'label': 'bg-red-300', 'bg': 'bg-red-100' }
}

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



            <!-- данные по рекламации -->

            <div class=" bg-white flex flex-col gap-4 p-3 rounded-md my-4"
                :class="reclamation.deleted_at ? 'contrast-50' : ''">
                <div v-if="reclamation.deleted_at" class=" text-center p-4 font-semibold uppercase">Рекламация в архиве
                </div>
                <div v-else class=" text-center p-4 font-semibold uppercase">Данные по рекламации
                </div>
                <div class="w-fit ">
                    <span class=" font-bold "> Статус -</span> <span class="px-2 py-1 rounded-sm"
                        :class="statusColors[props.reclamation.status?.id].label"> {{ props.reclamation.status.title
                        }}</span>
                </div>
                <div>
                    <span class=" font-bold "> Отправлена -</span> {{ props.reclamation.created_at }}
                </div>
                <div>
                    <span class=" font-bold "> Рекрутер -</span> {{ props.reclamation.recruiter.name }}
                </div>
                <div>
                    <span class=" font-bold "> Клиент - </span> {{ props.reclamation.client.name }}, {{
                            props.reclamation.client.pasport
                    }}
                </div>
                <div>
                    <span class=" font-bold ">Проект и период оплаты - </span> {{ props.reclamation.project }}, {{
                            props.reclamation.period
                    }}
                </div>
                <div>
                    <span class=" font-bold ">Комментарий - </span> {{ props.reclamation.comment }}
                </div>
                <div>
                    <span class=" font-bold "> Ответ - </span> {{ props.reclamation.answer }}
                </div>
            </div>

            <!-- /данные по рекламации -->



            <div class=" bg-systems-300 mt-0 rounded-md p-2">
                <SummaryClient :pasport="props.reclamation?.client.pasport" />
            </div>


        </div>
    </MainLayout>
</template>
