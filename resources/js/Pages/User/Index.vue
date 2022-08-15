<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import VueMultiselect from 'vue-multiselect'
import { Link, useForm, usePage } from "@inertiajs/inertia-vue3";
import { Head } from "@inertiajs/inertia-vue3";
import { reactive, ref } from "vue";


const props = defineProps({
    userList: Object,
    recruiterList: Object
});


const updateUserForm = useForm({
    'recruiter_id': []
});
const curentUserId = ref(null);


function formUpdate (list) {
    // usePage().props.value.flash.newFlash = false
    updateUserForm.recruiter_id = [];
    list.forEach(recruiter => {
        updateUserForm.recruiter_id.push(recruiter.id)
    });
    updateUserForm.put(route('users.update', { 'id': curentUserId.value }), { preserveScroll: true });
}



console.log(props.userList);

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
            <div class="bg-white my-2 p-3 rounded-md shadow-md " v-for="(user, i) in userList" :key="i">
                <div class="flex justify-between cursor-pointer " @click="curentUserId = user.id">
                    {{ user.name }}
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6v" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div v-if="user.id == curentUserId"
                    class=" my-4  rounded-md w-full gap-2  flex items-center md:justify-center justify-evenly flex-wrap">
                    <div class="  justify-center flex items-center w-11/12 ">
                        <!-- <VueMultiselect @update:model-value="user.recruiters" :multiple="true" -->
                        <VueMultiselect @update:model-value="formUpdate" :multiple="true"
                            selectLabel="добавить рекрутера" deselectLabel="убрать рекрутера" v-model="user.recruiters"
                            track-by="name" :options="props.recruiterList" label="name" :searchable="true"
                            placeholder="доступ к рекрутерам">
                        </VueMultiselect>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>
<style src="vue-multiselect/dist/vue-multiselect.css">
</style>