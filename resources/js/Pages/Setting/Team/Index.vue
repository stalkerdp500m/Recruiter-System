<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import VueMultiselect from 'vue-multiselect'
import { Link, useForm, usePage } from "@inertiajs/inertia-vue3";
import CreateTeamForm from "@/Components/CreateTeamForm";
import { Head } from "@inertiajs/inertia-vue3";
import { ref } from "vue";


const props = defineProps({
    recruiterList: Object,
    teamsList: Object,
    userList: Object
});



console.log(props);

const showCreateRecruiterForm = ref(false);


const updateRecruitersTeamForm = useForm({
    'recruiters': [],
    'action': 'recruiters',
    'teamName': ''
});
const updateAssistantTeamForm = useForm({
    'assistants': [],
    'action': 'assistants',
    'teamName': ''
});





function teamUpdate (newRecruitersList, team) {

    updateRecruitersTeamForm.recruiters = [];
    newRecruitersList.forEach(recruiter => {
        updateRecruitersTeamForm.recruiters.push(recruiter.id)
    });
    updateRecruitersTeamForm.teamName = team.name;
    updateRecruitersTeamForm.put(route('control.teams.update', { 'id': team.id }), { preserveScroll: true });
}


function teamUpdateAssistants (newAssistantsList, team) {
    updateAssistantTeamForm.assistants = [];
    newAssistantsList.forEach(recruiter => {
        updateAssistantTeamForm.assistants.push(recruiter.id)
    });
    updateAssistantTeamForm.teamName = team.name;
    updateAssistantTeamForm.put(route('control.teams.update', { 'id': team.id }), { preserveScroll: true });
}

const filteredTeamsList = ref(props.teamsList);
const searchRecruiterQuery = ref('');

function serched (input) {
    searchRecruiterQuery.value = input;
    filteredTeamsList.value = props.teamsList.filter((team) => {
        let searchStr = input.toLowerCase();
        return team.name.toLowerCase().includes(searchStr)
    })
}



</script>

<template>

    <Head title="Управлиение командами" />

    <MainLayout>
        <div class="md:px-10">
            <h1 class="text-2xl  text-center my-8">Управление командами</h1>
            <h2 class="text-xl  text-center my-8">Команда - сущность к которой привязываютсы рерутеры и пользователи
            </h2>
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
                        <p class=" md:ml-4"> Добавить команду</p>
                    </div>
                </div>
            </div>

            <CreateTeamForm :showForm="showCreateRecruiterForm" />

            <div class="bg-white my-2 p-3 rounded-md shadow-md   " v-for="(team, i) in filteredTeamsList" :key="i">
                <div class="flex justify-start cursor-pointer items-center h-12 ">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="h-5 w-5 mx-2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                    </svg>

                    <h3 class="text-xl">{{ team.name }} </h3>
                </div>
                <div
                    class=" py-4 border-t-2 border-systems-700/50   w-full gap-2  flex flex-col items-center md:justify-center justify-evenly flex-wrap">
                    <div class="w-full">
                        <h3 class="flex-1 ">Рекрутеры</h3>
                        <div class="  justify-center flex items-center w-11/12">
                            <VueMultiselect @update:model-value="teamUpdate($event, team)" :multiple="true"
                                selectLabel="Перенести в эту команду" track-by="name"
                                deselectLabel="убрать из этой команды" v-model="team.recruiters"
                                :options="props.recruiterList" label="name" :searchable="true"
                                placeholder="выбор рекрутера">
                            </VueMultiselect>
                        </div>
                    </div>
                </div>
                <div
                    class=" py-4 border-t-2  bg-systems-300 p-4 rounded-md  w-full gap-2  flex flex-col items-center md:justify-center justify-evenly flex-wrap">
                    <div class="w-full">
                        <h3 class="flex-1 my-2 ">Асистенты</h3>
                        <div class="   justify-center flex items-center w-11/12">
                            <VueMultiselect @update:model-value="teamUpdateAssistants($event, team)" :multiple="true"
                                selectLabel="Назначить асистентом команды" track-by="name"
                                deselectLabel="убрать из этой команды" v-model="team.assistants"
                                :options="props.userList" label="name" :searchable="true"
                                placeholder="выбор пользователя">
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