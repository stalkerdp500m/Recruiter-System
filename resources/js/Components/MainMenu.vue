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
    <div class="transition-all pl-1  flex flex-col gap-8 mt-20">

        <Link :href="route('dashboard')" v-if="userRole != 'accountant'">
        <div :class="isUrl('dashboard') ? 'opacity-100' : 'opacity-40'"
            class="text-white flex flex-row items-center  overflow-x-clip hover:opacity-100 ">
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
        <!-- Загрузки -->
        <BreezeDropdown align="bottom" width="54" v-if="userRole === 'admin'" @click="$emit('clickSubMenu')">
            <template #trigger>
                <div :class="isUrl('imports', true) ? 'opacity-100' : 'opacity-40'"
                    class="text-white flex flex-row items-center justify-start overflow-x-clip cursor-pointer hover:opacity-100 ">
                    <div class="px-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 " fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                    </div>
                    <div class="overflow-clip md:truncate md:text-xl leading-tight   text-clip">Загрузить
                    </div>
                </div>
            </template>
            <template #content>
                <div class=" py-2 text-sm  rounded shadow-xl cursor-pointer  ">
                    <Link :href="route('imports.payments.index')"
                        class=" px-6 py-2 hover:text-white hover:bg-systems-700 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 " fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h1 class="mx-2">Выплаты</h1>
                    </Link>
                </div>
                <div class=" py-2 text-sm  rounded shadow-xl cursor-pointer  ">
                    <Link :href="route('imports.salary.index')"
                        class=" px-6 py-2 hover:text-white hover:bg-systems-700 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                    </svg>
                    <h1 class="mx-2">Отработки</h1>
                    </Link>
                </div>
            </template>
        </BreezeDropdown>
        <!-- /Загрузки -->


        <!-- Пользователи -->

        <BreezeDropdown align="bottom" width="54" v-if="userRole === 'admin'" @click="$emit('clickSubMenu')">
            <template #trigger>
                <div :class="isUrl('control', true) ? 'opacity-100' : 'opacity-40'"
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
                    <Link :href="route('control.users.index')"
                        class="flex px-6 py-2 hover:text-white hover:bg-systems-700 ">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="h-5 w-5 mx-2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Пользователи
                    </Link>

                    <Link :href="route('control.recruiters.index')"
                        class="flex px-6 py-2 hover:text-white hover:bg-systems-700 ">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="h-5 w-5 mx-2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                    </svg>
                    Рекрутеры
                    </Link>

                    <Link :href="route('control.teams.index')"
                        class="flex px-6 py-2 hover:text-white hover:bg-systems-700 ">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="h-5 w-5 mx-2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                    </svg>
                    Команды
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
