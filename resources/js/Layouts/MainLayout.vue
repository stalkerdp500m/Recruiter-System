<script setup>
import { ref } from "vue";
import BreezeApplicationLogo from "@/Components/Breeze/ApplicationLogo.vue";
import BreezeDropdown from "@/Components/Breeze/Dropdown.vue";
import SettingDropdown from "@/Components/SettingDropdown.vue";
import BreezeDropdownLink from "@/Components/Breeze/DropdownLink.vue";
import BreezeNavLink from "@/Components/Breeze/NavLink.vue";
import BreezeResponsiveNavLink from "@/Components/Breeze/ResponsiveNavLink.vue";
import { Link } from "@inertiajs/inertia-vue3";
import MainMenu from "@/Components/MainMenu.vue";
import FlashMessages from "@/Components/FlashMessages.vue";
import NotificationBage from "@/Components/NotificationBage.vue";
import { Inertia } from '@inertiajs/inertia';



const showNaw = ref(false);
const showSubMenu = ref(false);
const showLoud = ref(false)

Inertia.on('start', (event) => {
    showLoud.value = true;
})
Inertia.on('finish', (event) => {
    showLoud.value = false;
})

</script>

<template>

    <div class="flex  h-full bg-systems-500 min-h-screen  md:max-w-fit md:min-w-full ">


        <div class="shrink bg-systems-800 transition-all z-50 "
            :class="showSubMenu ? 'w-44 md:w-64' : showNaw ? 'w-44 md:w-12' : 'w-12 md:w-64'">
            <div class="sticky top-0">
                <div class=" bg-systems-900 text-white h-16 flex  items-center justify-between ">
                    <div class="mx-auto overflow-clip md:truncate md:text-lg leading-tight text-clip tracking-tight">
                        Recruiter System</div>
                    <div class="pr-2  "> <svg @click="showNaw = !showNaw" xmlns=" http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20" class="fill-white w-8 h-12 cursor-pointer mr-2">
                            <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"></path>
                        </svg></div>
                </div>

                <MainMenu @clickSubMenu="showSubMenu = !showSubMenu" />
            </div>
        </div>
        <div class="flex-auto w-4/12">
            <div class="h-16 bg-systems-400 shadow-sm flex justify-between sticky top-0 z-50">
                <FlashMessages v-if="$page.props.flash" />
                <div class="flex items-center gap-4 md:mr-20 mr-5">
                    <div>
                        <SettingDropdown />
                    </div>
                    <div>
                        <NotificationBage />
                    </div>
                    <Link class="bg-systems-700 rounded-full p-2 text-white absolute" :href="route('return-admin')"
                        v-if="$page.props.auth.returnAdmin">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6 ">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                    </svg>
                    </Link>
                </div>
            </div>
            <!-- лоадер -->
            <div v-if="showLoud"
                class="fixed  w-screen  h-screen top-0 right-0  z-40 overflow-hidden bg-systems-700/80  flex flex-col items-center justify-center">
                <div class="loader ease-linear rounded-full border-4 border-t-4 border-gray-200 h-20 w-20 mb-4 ">
                </div>
                <h2 class="text-center text-white text-xl font-semibold"></h2>
            </div>
            <!-- /лоадер -->
            <div :class="{'blur-sm':showLoud}" class="px-2 transition-all flex-none  ">
                <slot />
            </div>
        </div>

    </div>
</template>
<style>
.loader {
    border-top-color: #3498db;
    -webkit-animation: spinner 1.5s linear infinite;
    animation: spinner 1.5s linear infinite;
}

@-webkit-keyframes spinner {
    0% {
        -webkit-transform: rotate(0deg);
    }

    100% {
        -webkit-transform: rotate(360deg);
    }
}

@keyframes spinner {
    0% {
        transform: rotate(0deg);
    }

    100% {
        transform: rotate(360deg);
    }
}
</style>
