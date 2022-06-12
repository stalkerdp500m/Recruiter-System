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
    <div class="flex  h-full bg-systems-500 min-h-screen  md:max-w-fit md:min-w-full ">
        <!-- <div class="flex flex-row h-full bg-systems-50 min-h-screen md:max-w-full w-sm "> -->

        <div class="shrink bg-systems-800 transition-all " :class="showNaw ? 'w-44 md:w-12' : 'w-12 md:w-64'">
            <div class="sticky top-0">
                <div class=" bg-systems-900 text-white h-16 flex  items-center justify-between ">
                    <div class="mx-1 overflow-clip md:truncate md:text-lg leading-tight text-clip tracking-tight">
                        Payout Partners System</div>
                    <div class="pr-2  "> <svg @click="showNaw = !showNaw" xmlns=" http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20" class="fill-white w-8 h-12 cursor-pointer mr-2">
                            <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"></path>
                        </svg></div>
                </div>

                <MainMenu />
            </div>
        </div>
        <div class="flex-auto w-4/12">
            <div class="h-16 bg-systems-400 shadow-sm flex justify-end sticky top-0 ">
                <SettingDropdown />
            </div>
            <div class="px-2 transition-all flex-none">
                <slot />
            </div>
        </div>

    </div>
</template>
