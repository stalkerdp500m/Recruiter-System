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


const showNaw = ref(false);
</script>

<template>
    <div class="flex justify-items-stretch h-screen">
        <!-- Левый сайтбар -->
        <div class="bg-systems-800 transition-all  z-20 " :class="showNaw ? 'w-64 md:w-12' : 'w-12 md:w-64'">
            <div class="bg-systems-900 h-16 shadow-md text-white flex justify-end overflow-hidden ">
                <div class="text-left flex  p-2 transition-all align-middle">
                    <span class="my-auto  text-white  text-xs md:text-base font-bold  md:pr-5 ">
                        Payout Partners System</span>
                </div>
                <div>
                    <svg @click="showNaw = !showNaw" xmlns=" http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        class="fill-white w-8 h-12 cursor-pointer mr-2">
                        <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"></path>
                    </svg>
                </div>
            </div>
            <div class=" py-20 text-center " :class="showNaw ? '' : ' md:pr-10'">
                <MainMenu />
            </div>
        </div>
        <!-- /Левый сайтбар -->

        <!-- Верхний сайтбар и контент -->
        <div class="w-full overflow-y-scroll ">
            <div class="h-16 bg-gray-300 shadow-xl flex justify-end ">
                <SettingDropdown />
            </div>

            <div class=" px-2 bg-gray-200 min-h-screen">
                <slot />
            </div>
        </div>
        <!-- /Верхний сайтбар и контент -->
    </div>
</template>
