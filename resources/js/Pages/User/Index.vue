<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import VueMultiselect from 'vue-multiselect'
import { Link, useForm, usePage } from "@inertiajs/inertia-vue3";
import { Head } from "@inertiajs/inertia-vue3";
import { reactive, ref } from "vue";


const props = defineProps({
    userList: Object,
    recruiterList: Object,
    roleList: Object,
    teamsList: Object
});




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

function recruiterListUpdate (list) {
    updateUserForm.action = 'recruitersList';
    updateUserForm.recruiter_id = [];
    list.forEach(recruiter => {
        updateUserForm.recruiter_id.push(recruiter.id)
    });
    updateUserForm.put(route('users.update', { 'id': curentUserId.value }), { preserveScroll: true });
}

function roleUpdate (role) {

    updateUserForm.action = 'role';
    updateUserForm.role = role;
    updateUserForm.put(route('users.update', { 'id': curentUserId.value }), { preserveScroll: true });
}
function teamUpdate (team) {
    console.log(team);
    updateUserForm.action = 'team';
    updateUserForm.team_id = team.id;
    updateUserForm.put(route('users.update', { 'id': curentUserId.value }), { preserveScroll: true });
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

        <!-- настройки под спойлер, при нажатии спойлера мультивыбор заполняется текущим пользователем (все остальные мультивыборы закрываются) -->

        <div class="md:px-10">
            <h1 class="text-2xl  text-center my-8">Управление доступами пользователей к рекрутерам</h1>

            <!-- Фильтры
            поиск, фильтр статусы, архивные
            -->
            <div class=" my-4  rounded-md w-full gap-2 flex items-start  justify-start flex-wrap">
                <!-- <div class=" md:w-2/6 justify-center flex items-center w-11/12 ">
                    <VueMultiselect @update:model-value="selectedStatus" :multiple="true"
                        selectLabel="добавить в фильтр" deselectLabel="убрать из фильтра" v-model="statuseShortList"
                        track-by="title" :options="statuses" label="title" :searchable="false"
                        placeholder="фильтровать по статусам">
                    </VueMultiselect>
                </div> -->


                <div class="  w-7/12  justify-center flex items-center bg-white rounded-md ">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2  z-10  " fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input @input="e => serched(e.target.value)" type="text" :value="searchUserQuery"
                        class=" h-10  w-full md:w-4/5 focus:ring-0 border-0 "
                        placeholder="Найти пользователя (имя или email)">
                </div>



                <div class="  w-3/12 justify-center flex items-center ">
                    <VueMultiselect @update:model-value="filtered" v-model="filterRoleStr" :multiple="false"
                        selectLabel="фильтровать по" deselectLabel="очистить фильтр" :options="props.roleList"
                        :searchable="false" placeholder="Роли">
                    </VueMultiselect>
                </div>
            </div>



            <div :class="user.id == curentUserId ? 'bg-systems-300 border-2 border-white' : ''"
                class="bg-white my-2 p-3 rounded-md shadow-md   " v-for="(user, i) in filteredUserList" :key="i">
                <div class="flex justify-start cursor-pointer items-center h-12 " @click="curentUserId = user.id">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
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