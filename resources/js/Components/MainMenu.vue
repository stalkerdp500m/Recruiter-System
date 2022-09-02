<script setup>
import { computed, ref } from "vue";
import { Link, usePage } from "@inertiajs/inertia-vue3";
import BreezeDropdown from "@/Components/Breeze/Dropdown.vue";


function isUrl (url, catalog = false) {

    if (catalog) {
        return route().current().split('.')[0] == url;
    }
    return url === route().current();
}

const showLoudMenu = ref(false);



const props = defineProps(["class", "active"]);
const userRole = usePage().props.value.auth.user.role


</script>

<template>
    <div class="transition-all pl-1  flex flex-col gap-8">

        <Link :href="route('dashboard')">
        <div :class="isUrl('dashboard') ? 'opacity-100' : 'opacity-40'"
            class="text-white mt-20 flex flex-row items-center  overflow-x-clip hover:opacity-100 ">
            <div class="px-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 " fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                </svg>
            </div>
            <div class="overflow-clip md:truncate md:text-xl leading-tight text-clip">Аналитика
            </div>
        </div>
        </Link>
        <Link :href="route('payments.index')">
        <div :class="isUrl('payments.index') ? 'opacity-100' : 'opacity-40'"
            class="text-white  flex flex-row items-center justify-start overflow-x-clip hover:opacity-100 ">
            <div class="px-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 " fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <div class="overflow-clip md:truncate md:text-xl leading-tight   text-clip">Выплаты
            </div>
        </div>
        </Link>
        <Link :href="route('clients.index')">
        <div :class="isUrl('clients.index') ? 'opacity-100' : 'opacity-40'"
            class="text-white flex flex-row items-center justify-start overflow-x-clip hover:opacity-100 ">
            <div class="px-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 " fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <div class="overflow-clip md:truncate md:text-xl leading-tight   text-clip">Клиенты
            </div>
        </div>
        </Link>
        <Link :href="route('reclamations.index')">
        <div :class="isUrl('reclamations.index') ? 'opacity-100' : 'opacity-40'"
            class="text-white flex flex-row items-center justify-start overflow-x-clip hover:opacity-100 ">
            <div class="px-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 " fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
            </div>
            <div class="overflow-clip md:truncate md:text-xl leading-tight   text-clip">Рекламации
            </div>
        </div>
        </Link>

        <div @click="showLoudMenu = !showLoudMenu" v-if="userRole === 'admin'"
            :class="showLoudMenu ? 'opacity-100' : 'opacity-40'"
            class="text-white flex flex-row items-center justify-start overflow-x-clip hover:opacity-100 cursor-pointer">
            <div class="px-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 " fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
            </div>
            <div class="overflow-clip md:truncate md:text-xl leading-tight   text-clip">
                <p> Загрузить</p>
            </div>
        </div>

        <div class=" pl-4" v-if="showLoudMenu">
            <Link :href="route('imports.payments.index')">
            <div :class="isUrl('imports.payments.index') ? 'opacity-100' : 'opacity-40'"
                class="text-white flex flex-row items-center justify-start overflow-x-clip hover:opacity-100 ">
                <div class="px-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 " fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="overflow-clip md:truncate md:tex-tmd leading-tight   text-clip">
                    <p> Выплаты</p>
                </div>
            </div>
            </Link>
        </div>


        <!-- Пользователи -->

        <BreezeDropdown align="bottom" width="54" v-if="userRole === 'admin'" @click="$emit('clickSubMenu')">
            <template #trigger>
                <div :class="isUrl('users', true) ? 'opacity-100' : 'opacity-40'"
                    class="text-white flex flex-row items-center justify-start overflow-x-clip cursor-pointer hover:opacity-100 ">
                    <div class="px-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 " fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        </svg>
                    </div>
                    <div class="overflow-clip md:truncate md:text-xl leading-tight   text-clip">Управление
                    </div>
                </div>
            </template>
            <template #content>
                <div class=" py-2 text-sm   rounded shadow-xl cursor-pointer  ">
                    <Link :href="route('users.index')" class="block px-6 py-2 hover:text-white hover:bg-systems-700 ">
                    Управлять пользователями
                    </Link>
                    <Link :href="route('profile')" class="block px-6 py-2 hover:text-white hover:bg-systems-700 ">
                    Управлять рекрутерами
                    </Link>
                    <Link :href="route('profile')" class="block px-6 py-2 hover:text-white hover:bg-systems-700 ">
                    Управлять командами
                    </Link>
                    <Link :href="route('users.create')" class="block px-6 py-2 hover:text-white hover:bg-systems-700 ">
                    Добавить пользователя
                    </Link>

                </div>
            </template>
        </BreezeDropdown>


        <!-- /Пользователи -->









        <!-- <Link v-if="userRole === 'admin'" :href="route('users.index')">
        <div :class="isUrl('users.index') ? 'opacity-100' : 'opacity-40'"
            class="text-white flex flex-row items-center justify-start overflow-x-clip hover:opacity-100 ">
            <div class="px-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 " fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <div class="overflow-clip md:truncate md:text-xl leading-tight   text-clip">Пользователи
            </div>
        </div>
        </Link> -->


    </div>


</template>
