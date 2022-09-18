<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import ReclamationForm from "@/Components/ReclamationForm.vue";
import { Head, useForm } from "@inertiajs/inertia-vue3";
import { ref } from "vue";

const props = defineProps({
    userData: Object,
});
//console.log(props);

const showForm = ref(false);

</script>

<template>

    <Head title="Профиль" />

    <MainLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Страница пользователя
            </h2>
        </template>



        <div class="py-2 md:w-full  mx-auto my-10  ">
            <div class="bg-white p-3 rounded-md">
                <h1 class=" text-lg my-2">Профиль пользователя - {{props.userData.name}}</h1>
                <h1 class=" text-lg my-2">Почта - {{props.userData.email}}</h1>
                <h1 class=" text-lg my-2">Команда - {{props.userData.team?.name}}</h1>
                <div v-if="props.userData.role=='user'">
                    <h2 class="text-center my-2 text-2xl">У вас есть доступ к рекрутерам</h2>
                    <div class="bg-white my-2 p-1 rounded-md shadow-md   "
                        v-for="(recruiter, i) in props.userData.recruiters" :key="i">
                        <div class="flex justify-start items-center  ">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="h-5 w-5 mx-2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                            </svg>
                            <h3 class="text-xl font-bold">{{ recruiter.name }} </h3>
                        </div>
                    </div>
                </div>
                <div v-if="props.userData.role=='accountant'">
                    <h2 class="text-center my-2 text-2xl">У вас есть доступ ко всем рекрутерам системы</h2>
                </div>
                <div v-if="props.userData.role=='assistant'">
                    <h2 class="text-center my-2 text-2xl">У вас есть доступ ко всем рекрутерам команды
                        {{props.userData.team?.name}}</h2>
                </div>
            </div>
        </div>
    </MainLayout>
</template>