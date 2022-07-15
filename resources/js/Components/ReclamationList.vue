<script setup>
import { useForm } from "@inertiajs/inertia-vue3";
import { ref, reactive } from "vue";
import { Inertia } from '@inertiajs/inertia';
// import { defineEmits } from 'vue'


const props = defineProps({
    reclamations: Object
});

function toLocaleDate (date) {
    return new Date(date).toLocaleDateString('ru-RU', { year: '2-digit', month: 'numeric', day: 'numeric' });
}

const statusColors = {
    1: { 'label': 'bg-systems-300', 'bg': 'bg-systems-100' },
    2: { 'label': 'bg-yellow-300', 'bg': 'bg-yellow-100' },
    3: { 'label': 'bg-green-300', 'bg': 'bg-green-100' },
    4: { 'label': 'bg-red-300', 'bg': 'bg-red-100' }
}

function deleteReclamation (id) {
    useForm({ 'id': id }).delete(`./reclamations/${id}`, {
        onSuccess: () => {
            alert(id)
        }
    })

}

</script>

<template>
    <div>


        <!-- { "id": 28, "user_id": 1, "recruiter_id": 12, "client_id": 187, "status_id": 1, "project": "dfsdsfdsd", "period": "12-2021", "comment": "sdfsdfdsfsfds", "answer": null, "created_at": "2022-07-15T07:27:25.000000Z", "updated_at": "2022-07-15T07:27:25.000000Z",
"status": { "id": 1, "title": "Новая" },
"client": { "id": 187, "name": "Janina Przybylska", "pasport": "EQSMVX5O8Z0" },
"recruiter": { "id": 12, "name": "Tola Kamińska" } } -->

        <div class=" flex flex-col ">
            <div :class="statusColors[reclamation.status?.id].bg"
                class="p-2 my-2 shadow-sm rounded-md flex  items-center overflow-auto"
                v-for="reclamation in props.reclamations">

                <div class=" flex md:w-1/2 w-2/3  gap-2 align-baseline">
                    <div :class="statusColors[reclamation.status?.id].label"
                        class="md:w-1/12 w-20  rounded-md  flex justify-center md:h-28 truncate ">
                        <div class=" -rotate-90 my-auto ">{{ reclamation.status?.title }}</div>
                    </div>
                    <div
                        class="md:w-1/3 w-28 text-center bg-systems-300 p-2 rounded-md leading-tight flex flex-col justify-center ">
                        <div> {{ reclamation.period }}</div>
                        <span class=" text-xs  ">фактура</span>
                        <div class=" text-xs pt-2 ">создана: {{ toLocaleDate(reclamation.created_at) }}</div>
                    </div>
                    <div class="  md:w-2/3 w-36 break-all">
                        <div class=" ">🏭{{ reclamation.project }}</div>
                        <div class="font-bold ">🧑‍🏭{{ reclamation?.client?.name }}</div>
                        <div>{{ reclamation?.client?.pasport }}</div>
                    </div>
                </div>
                <div class=" w-1/2 flex">
                    <div class=" hidden md:flex md:w-2/3">
                        <div class="px-2 leading-tight  h-24 w-1/2">
                            <div class=" border border-systems-400 h-full rounded-md p-1 overflow-hidden ">
                                <div class="text-xs break-words ">коментарий:</div>{{ reclamation.comment }}
                            </div>
                        </div>
                        <div class="px-2 leading-tight  h-24 w-1/2">
                            <div class=" border border-systems-400 h-full rounded-md p-1 overflow-hidden ">
                                <div class="text-xs break-words ">ответ:</div>{{ reclamation.answer }}
                            </div>
                        </div>
                    </div>

                    <div
                        class="md:w-1/3  md:mx-3 ml-2 flex flex-col  text-center  items-stretch justify-end h-auto m-0 ">
                        <div
                            class=" bg-systems-400 px-1 py-2 text-xs mb-5 rounded-sm shadow-md cursor-pointer flex justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Смотреть
                        </div>
                        <div class=" bg-red-400 px-1 py-2 text-xs mb-5 rounded-sm shadow-md cursor-pointer flex justify-center gap-2"
                            @click="deleteReclamation(reclamation.id)">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            В архив
                        </div>
                    </div>
                </div>
                <!-- <div class=" bg-slate-600"> {{ reclamation }}</div> -->
            </div>

        </div>

    </div>
</template>