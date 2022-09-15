<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import VueMultiselect from 'vue-multiselect'
import CreateUserForm from "@/Components/CreateUserForm";
import { Link, useForm, usePage } from "@inertiajs/inertia-vue3";
import { Head } from "@inertiajs/inertia-vue3";
import { reactive, ref } from "vue";


const props = defineProps({
    userList: Object,
    recruiterList: Object,
    roleList: Object,
    teamsList: Object
});

console.log(props);


const searchUserQuery = ref('');
const filteredUserList = ref(props.userList);
const filterRoleStr = ref('');

function serched (input) {
    searchUserQuery.value = input
    filteredUserList.value = props.userList.filter((user) => {
        let searchStr = input.toLowerCase();
        let countLeters = searchStr.length;
        return user.name.toLowerCase().substring(0, countLeters).includes(searchStr) || user.email.toLowerCase().substring(0, countLeters).includes(searchStr)
    })
}

function filtered (role) {
    if (!role) { filteredUserList.value = props.userList }
    else {
        filteredUserList.value = props.userList.filter((user) => {
            return user.role == role;
        })
    }
}

const updateUserForm = useForm({
    'action': false,
    'recruiter_id': [],
    'role': '',
    'team_id': ''
});
const curentUserId = ref(null);

const showCreateUserForm = ref(false);

function recruiterListUpdate (list) {
    updateUserForm.action = 'recruitersList';
    updateUserForm.recruiter_id = [];
    list.forEach(recruiter => {
        updateUserForm.recruiter_id.push(recruiter.id)
    });
    updateUserForm.put(route('control.users.update', { 'id': curentUserId.value }), { preserveScroll: true });
}

function roleUpdate (role) {
    updateUserForm.action = 'role';
    updateUserForm.role = role;
    updateUserForm.put(route('control.users.update', { 'id': curentUserId.value }), { preserveScroll: true });
}
function teamUpdate (team) {
    updateUserForm.action = 'team';
    updateUserForm.team_id = team.id;
    updateUserForm.put(route('control.users.update', { 'id': curentUserId.value }), { preserveScroll: true });
}



</script>

<template>

    <Head title="Управлиение пользователями" />

    <MainLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Управлиение пользователями
            </h2>
        </template>

        <div class="md:px-10">
            <h1 class="text-2xl  text-center my-8">Управление ролями и доступами пользователей к рекрутерам</h1>

            <!-- Фильтры
            поиск, фильтр статусы, архивные
            -->
            <div class=" my-4  rounded-md w-full gap-2 flex items-start  justify-evenly flex-wrap  ">
                <div class=" w-7/12 md:w-6/12  justify-center flex items-center bg-white rounded-md ">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2  z-10  " fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input @input="e => serched(e.target.value)" type="text" :value="searchUserQuery"
                        class=" h-10  w-full md:w-4/5 focus:ring-0 border-0 "
                        placeholder="Найти пользователя (имя или email)">
                </div>



                <div class="w-4/12 md:w-2/12 justify-center flex items-center h-10 ">
                    <VueMultiselect @update:model-value="filtered" v-model="filterRoleStr" :multiple="false"
                        selectLabel="" deselectLabel="" :options="props.roleList" :searchable="false"
                        placeholder="роли">
                    </VueMultiselect>
                </div>
                <div class="w-full md:w-3/12 mt-3 md:my-0  justify-center flex items-center h-10 ">
                    <div @click="showCreateUserForm = !showCreateUserForm"
                        class="bg-systems-800 rounded-md text-white shadow-md px-4 py-2  text-center cursor-pointer flex">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6  " fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class=" md:ml-4"> создать пользователя </p>
                    </div>
                </div>
            </div>

            <CreateUserForm :showForm="showCreateUserForm" :teamsList="props.teamsList" :roleList="props.roleList"
                :recruiterList="props.recruiterList" />

            <div :class="user.id == curentUserId ? 'bg-systems-300 border-2 border-white' : ''"
                class="bg-white my-2 p-3 rounded-md shadow-md   " v-for="(user, i) in filteredUserList" :key="i">
                <div class="flex justify-start cursor-pointer items-center h-12 " @click="curentUserId = user.id">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="h-5 w-5 mx-2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <h3 class="text-xl">{{ user.name }} <span class="text-base"> {{ user.email }}</span> </h3>
                    <div :class="user.role == 'admin' ? 'bg-green-600' : 'bg-systems-600 text-white'"
                        class=" text-sm overflow-x-clip absolute mx-3 -mt-12 md:mr-14 md:-mt-5 right-0  h-fit rounded-sm px-1">
                        {{
                                user.role
                        }}</div>
                </div>
                <div v-if="user.id == curentUserId"
                    class=" py-4 border-t-2 border-systems-700/50   w-full gap-2  flex flex-col items-center md:justify-center justify-evenly flex-wrap">

                    <div class="w-full">
                        <h3 class="flex-1 ">Роль</h3>
                        <div class="  justify-center flex items-center w-11/12 ">
                            <!-- <VueMultiselect @update:model-value="user.recruiters" :multiple="true" -->
                            <VueMultiselect @update:model-value="roleUpdate" :multiple="false"
                                selectLabel="выбрать роль" v-model="user.role" :options="props.roleList"
                                :searchable="false" placeholder="выбор роли">
                            </VueMultiselect>
                        </div>
                    </div>
                    <div class="w-full">
                        <h3 class="flex-1 ">Команда</h3>
                        <div class="  justify-center flex items-center w-11/12 ">
                            <!-- <VueMultiselect @update:model-value="user.recruiters" :multiple="true" -->
                            <VueMultiselect @update:model-value="teamUpdate" :multiple="false"
                                selectLabel="Добавить в команду" v-model="user.team" :options="props.teamsList"
                                label="name" :searchable="true" placeholder="выбор команды">
                            </VueMultiselect>
                        </div>
                    </div>
                    <div class="w-full" v-if="user.role != 'assistant'">
                        <h3 class="flex-1 ">Доступ к рекрутерам</h3>
                        <div class="  justify-center flex items-center w-11/12 ">
                            <!-- <VueMultiselect @update:model-value="user.recruiters" :multiple="true" -->
                            <VueMultiselect @update:model-value="recruiterListUpdate" :multiple="true"
                                selectLabel="добавить рекрутера" deselectLabel="убрать рекрутера"
                                v-model="user.recruiters" track-by="name" :options="props.recruiterList" label="name"
                                :searchable="true" placeholder="поиск рекрутера">
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