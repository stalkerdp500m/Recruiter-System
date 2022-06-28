<script setup>
import { computed, ref } from "vue";
import { Link } from "@inertiajs/inertia-vue3";
// const isUrl = computed((url) => {
//     console.log(url);
//     return url === route().current();
// })

function isUrl (url) {
    return url === route().current();
}

const showLoudMenu = ref(false);
const props = defineProps(["class", "active"]);

</script>

<template>
    <div class="transition-all px-2 ">

        <Link :href="route('dashboard')">
        <div :class="isUrl('dashboard') ? 'opacity-100' : 'opacity-40'"
            class="text-white mt-20 flex flex-row items-center justify-center overflow-x-clip hover:opacity-100 ">
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
            class="text-white mt-10  flex flex-row items-center justify-center overflow-x-clip hover:opacity-100 ">
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
            class="text-white mt-10  flex flex-row items-center justify-center overflow-x-clip hover:opacity-100 ">
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

        <div @click="showLoudMenu = !showLoudMenu"
            class="text-white mt-10  flex flex-row items-center justify-center overflow-x-clip hover:opacity-100 cursor-pointer">
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
                class="text-white mt-10  flex flex-row items-center justify-center overflow-x-clip hover:opacity-100 ">
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


    </div>


</template>
