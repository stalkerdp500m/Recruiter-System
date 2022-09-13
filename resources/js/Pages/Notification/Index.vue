<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import PaymentsTable from "@/Components/PaymentsTable.vue";
import { Head, useForm } from "@inertiajs/inertia-vue3";
import { Inertia } from '@inertiajs/inertia'
import { ref } from "vue";
const props = defineProps({
    notifications: Object,
});

function lockaleDate (date) {
    const dateOptions = { year: 'numeric', month: 'numeric' };
    return new Date(date).toLocaleString('ru-RU')
}

function markAsRead (notyfy, action = false) {
    useForm({ 'action': action }).put(route('notifications.read', { 'id': notyfy.id }), {
        preserveScroll: true
    })

}

</script>

<template>

    <Head title="Выплаты" />

    <MainLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Уведомления
            </h2>
        </template>


        <div class="py-2 md:w-full md:px-4 pt-10  mx-auto">
            <div v-if="props.notifications.length==0" class=" bg-white  my-10 py-10 rounded-md  px-5 ">
                <h1 class="text-2xl text-center">
                    нет новых уведомлениий
                </h1>
            </div>
            <div v-for="notify,i in props.notifications" :kay="i"
                class="flex flex-wrap  bg-white  my-5 p-2 rounded-md  px-5 md:justify-between">
                <div class="items-center md:w-11/12 w-10/12 flex flex-wrap">

                    <div class="md:w-20 md:text-center   ">
                        <h1 class="text-sm ">{{lockaleDate(notify.created_at)}}</h1>
                    </div>

                    <div class="md:w-8/12  flex flex-col mb-3 ml-5 md:mb-0 pl-2 border-l border-systems-700">
                        <h1 class="text-xl bold">{{notify.data?.title}}</h1>
                        <div>{{notify.data?.body}}</div>
                    </div>
                    <div class=" cursor-pointer  ">
                        <div @click="markAsRead(notify,notify.data?.action)"
                            class="bg-systems-600 rounded-md text-white shadow-md px-4 py-1  text-center cursor-pointer flex w-fit ">
                            <p class="mr-2">перейти</p>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-5 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div @click="markAsRead(notify)"
                    class="items-start flex h-fit  -translate-y-5 md:translate-x-8 translate-x-10 bg-red-400/90 p-1  text-sm rounded-full cursor-pointer  ">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>




    </MainLayout>
</template>