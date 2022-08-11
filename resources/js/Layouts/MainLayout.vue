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
            <div class="h-16 bg-systems-400 shadow-sm flex justify-end sticky top-0 z-50">
                <!-- <div class="flex flex-row items-baseline w-full ">
                    <div class=" w-2/3 m-2  justify-start ">
                        <FlashMessages />
                    </div>
                    <div class=" w-1/3  flex justify-end">
                        <SettingDropdown />
                    </div>
                </div> -->
                <SettingDropdown />
                <transition enter-from-class="opacity-0 -translate-x-full" enter-active-class="transform-gpu"
                    enter-class="opacity-0 -translate-x-full duration-1000" enter-to-class="opacity-100 translate-x-0"
                    leave-active-class="absolute transform-gpu" leave-class="opacity-100 translate-x-0"
                    leave-to-class="opacity-0 translate-x-full">
                    <FlashMessages v-if="$page.props.flash.newFlash" />
                </transition>
            </div>
            <div class="px-2 transition-all flex-none">
                <slot />
            </div>
        </div>

    </div>
</template>
