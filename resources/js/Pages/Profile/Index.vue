<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import ReclamationForm from "@/Components/ReclamationForm.vue";
import { ref } from "vue";

const showForm = ref(false);

</script>

<template>

    <Head title="Рекламации" />

    <MainLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Страница пользователя
            </h2>
        </template>



        <div class="py-2 md:w-full  mx-auto">
            <div class="flex h-20 items-center px-10">
                <div @click="showForm = true"
                    class="bg-systems-800 rounded-md text-white shadow-md px-4 py-2  text-center cursor-pointer flex">
                    Создать токен
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-3 " fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>

            </div>
            <div>11|zljrtpxJTx5DL0NalbV9TdrFX0YsTm0QSPmyeZVr</div>
        </div>
    </MainLayout>
</template>