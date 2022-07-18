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

    let confirmDelete = confirm("Отправить рекламацию в архив?");
    if (confirmDelete) {
        useForm({ 'id': id }).delete(`./reclamations/${id}`, {
            onSuccess: () => {
            }
        })
    }

}


</script>



    <!-- { "id": 28, "user_id": 1, "recruiter_id": 12, "client_id": 187, "status_id": 1, "project": "dfsdsfdsd", "period": "12-2021", "comment": "sdfsdfdsfsfds", "answer": null, "created_at": "2022-07-15T07:27:25.000000Z", "updated_at": "2022-07-15T07:27:25.000000Z",
"status": { "id": 1, "title": "Новая" },
"client": { "id": 187, "name": "Janina Przybylska", "pasport": "EQSMVX5O8Z0" },
"recruiter": { "id": 12, "name": "Tola Kamińska" } } -->





<template>


    <div>
        <div v-for="reclamation in props.reclamations" :class="statusColors[reclamation.status?.id].bg"
            class=" flex  w-full   gap-2 my-2 shadow-sm rounded-md p-2 ">

            <div class="w-full md:w-7/12  h-40 gap-2 flex ">

                <div class="w-1/12 bg-white h-40   rounded-md  flex justify-center  truncate"
                    :class="statusColors[reclamation.status?.id].label">
                    <div class=" -rotate-90 my-auto ">{{ reclamation.status?.title }}</div>
                </div>

                <div
                    class="w-4/12 h-40 text-center bg-systems-300 p-2 rounded-md leading-tight flex flex-col justify-center cursor-pointer ">

                    <div> {{ reclamation.period }}</div>
                    <div> {{ reclamation?.recruiter?.name }}</div>
                    <div class=" text-xs pt-2 ">отправлена: {{ toLocaleDate(reclamation.created_at) }}</div>
                </div>


                <div class="w-7/12 bg-white rounded-md p-3 h-40 justify-evenly flex flex-col overflow-clip">
                    <div class=" ">🏭{{ reclamation.project }}</div>
                    <div class="font-bold ">🧑‍🏭{{ reclamation?.client?.name }}</div>
                    <div>{{ reclamation?.client?.pasport }}</div>

                </div>
            </div>

            <div class="w-5/12 h-40 gap-2 hidden md:flex ">
                <div class="w-6/12 h-40 ">
                    <div class=" border border-systems-400 h-full rounded-md p-1 overflow-hidden ">
                        <div class="text-xs break-words ">коментарий:</div>{{ reclamation.comment }}
                    </div>
                </div>
                <div class="w-6/12  h-40 ">
                    <div class=" border border-systems-400 h-full rounded-md p-1  ">
                        <div class="text-xs break-words ">ответ:</div>{{ reclamation.answer }}
                    </div>
                </div>
            </div>
            <div class="w-1/12    flex justify-end items-end ">

                <div class="group transition-all bg-red-400  md:hover:w-28 w-10 h-10  text-xs  rounded-full shadow-md cursor-pointer absolute flex justify-center items-center "
                    @click="deleteReclamation(reclamation.id)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4  " fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    <div class="hidden md:group-hover:flex truncate font-bold">в архив</div>
                </div>
            </div>
        </div>

    </div>
</template>