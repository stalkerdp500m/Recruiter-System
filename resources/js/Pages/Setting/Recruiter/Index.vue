<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import VueMultiselect from 'vue-multiselect'
import { Link, useForm, usePage } from "@inertiajs/inertia-vue3";
import CreateRecruiterForm from "@/Components/CreateRecruiterForm";
import { Head } from "@inertiajs/inertia-vue3";
import { ref } from "vue";


const props = defineProps({
    recruiterList: Object,
    teamsList: Object
});

const showCreateRecruiterForm = ref(false);


const updateRecruiterForm = useForm({
    'userName': '',
    'team_id': '',
    'teamName': ''
});

function reloud () {
    Inertia.reload({ only: ['recruiterList'] })
}

function recruiterTeamUpdate (team, recruiter) {

    updateRecruiterForm.team_id = team.id
    updateRecruiterForm.teamName = team.name
    updateRecruiterForm.userName = recruiter.name
    updateRecruiterForm.put(route('recruiters.update', { 'id': recruiter.id }), { preserveScroll: true });
}

const filteredRecruiterList = ref(props.recruiterList);
const searchRecruiterQuery = ref('');

function serched (input) {
    searchRecruiterQuery.value = input;
    filteredRecruiterList.value = props.recruiterList.filter((recruiter) => {
        let searchStr = input.toLowerCase();
        return recruiter.name.toLowerCase().includes(searchStr)
    })
}



</script>

<template>

    <Head title="Управлиение пользователями" />

    <MainLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Управлиение рекрутерами
            </h2>
        </template>
        <div class="md:px-10">
            <h1 class="text-2xl  text-center my-8">Управление рекрутерами</h1>
            <h2 class="text-xl  text-center my-8">Рекрутер - сущность к которой привязываютсы выплаты и рекламации (не
                имеет доступа к системе)</h2>
            <div class="flex gap-2">
                <div class="  w-7/12  justify-center flex items-center bg-white rounded-md ">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2  z-10  " fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input @input="e => serched(e.target.value)" type="text"
                        class=" h-10  w-full md:w-4/5 focus:ring-0 border-0 " placeholder="Поиск рекрутера по названию">
                </div>
                <div class="w-4/12 ">
                    <div @click="showCreateRecruiterForm = !showCreateRecruiterForm"
                        class="bg-systems-800 rounded-md text-white shadow-md px-4 py-2  text-center cursor-pointer flex">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6  " fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class=" md:ml-4"> Добавить рекрутера</p>
                    </div>
                </div>
            </div>

            <CreateRecruiterForm :showForm="showCreateRecruiterForm" :teamsList="props.teamsList" />

            <div class="bg-white my-2 p-3 rounded-md shadow-md   " v-for="(recruiter, i) in filteredRecruiterList"
                :key="i">
                <div class="flex justify-start cursor-pointer items-center h-12 ">
                    <h3 class="text-xl">{{ recruiter.name }} </h3>
                </div>
                <div
                    class=" py-4 border-t-2 border-systems-700/50   w-full gap-2  flex flex-col items-center md:justify-center justify-evenly flex-wrap">
                    <div class="w-full">
                        <h3 class="flex-1 ">Команда</h3>
                        <div class="  justify-center flex items-center w-11/12">
                            <VueMultiselect @update:model-value="recruiterTeamUpdate($event, recruiter)"
                                :multiple="false" :value="recruiter" selectLabel="Изменить команду на эту"
                                v-model="recruiter.team" :options="props.teamsList" label="name" :searchable="true"
                                placeholder="выбор команды">
                            </VueMultiselect>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>
<style src="vue-multiselect/dist/vue-multiselect.css">
</style>