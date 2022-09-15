<script setup>
import BreezeApplicationLogo from "@/Components/Breeze/ApplicationLogo.vue";
import { Link } from "@inertiajs/inertia-vue3";
</script>

<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-systems-600">
        <div>
            <Link href="/">
            <BreezeApplicationLogo class="w-full h-20 fill-current " />
            <h1 class="text-center text-2xl mx-2 font-bold">Система управления выплатами и рекрутациями</h1>
            </Link>
        </div>

        <div
            class="w-11/12 max-w-md mt-6 px-2 md:px-6 py-4 bg-white shadow-md overflow-hidden rounded-md sm:rounded-lg">
            <slot />
        </div>
    </div>
</template>
