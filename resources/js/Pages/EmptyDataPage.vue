<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
</script>

<template>

    <Head title="Выплаты" />

    <MainLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Нет данных
            </h2>
        </template>

        <!-- Фильтры -->
        <div class=" text-3xl text-white text-center my-10">
            отсутвуют данные по выплатам,<br> попросите администратора их загрузить
        </div>
    </MainLayout>
</template>