<script setup>
import { ref } from "vue";
import BreezeApplicationLogo from "@/Components/ApplicationLogo.vue";
import BreezeDropdown from "@/Components/Dropdown.vue";
import MainMenu from "@/Components/MainMenu.vue";
import BreezeDropdownLink from "@/Components/DropdownLink.vue";
import BreezeNavLink from "@/Components/NavLink.vue";
import BreezeResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import { Link } from "@inertiajs/inertia-vue3";

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div class="flex justify-items-stretch h-screen">
        <!-- Левый сайтбар -->
        <div
            :class="showingNavigationDropdown ? 'w-72 md:w-12' : 'w-12 md:w-72'"
            class="bg-indigo-700 transition-all overflow-x-clip z-20"
        >
            <div
                class="bg-indigo-900 h-16 shadow-md flex justify-end overflow-hidden"
            >
                <div
                    class="text-left text-white text-sm md:text-base font-bold flex items-center p-2 transition-all"
                >
                    <span> Payout Partners System</span>
                </div>
                <div>
                    <svg
                        @click="
                            showingNavigationDropdown =
                                !showingNavigationDropdown
                        "
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                        class="fill-white w-8 h-12 cursor-pointer mr-2"
                    >
                        <path
                            d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"
                        ></path>
                    </svg>
                </div>
            </div>
            <div class="h-full w-full bg-indigo-700 shadow-xl text-center">
                меню
            </div>
        </div>
        <!-- /Левый сайтбар -->

        <!-- Верхний сайтбар и контент -->
        <div class="w-full h-full">
            <div class="h-16 bg-gray-300 shadow-xl flex justify-end">
                <!-- Settings Dropdown -->
                <div class="flex items-center ml-6 px-5">
                    <div class="ml-3 relative">
                        <BreezeDropdown align="right" width="48">
                            <template #trigger>
                                <div
                                    class="group flex items-center cursor-pointer select-none"
                                >
                                    <div
                                        class="mr-1 text-black font-bold group-hover:text-indigo-700 focus:text-indigo-600 whitespace-nowrap"
                                    >
                                        <span>{{
                                            $page.props.auth.user.name
                                        }}</span>
                                    </div>
                                    <!-- <icon
                                                class="w-5 h-5 fill-gray-700 group-hover:fill-indigo-600 focus:fill-indigo-600"
                                                name="cheveron-down"
                                            /> -->
                                </div>
                            </template>
                            <template #content>
                                <div
                                    class="mt-2 py-2 text-sm bg-white rounded shadow-xl"
                                >
                                    <Link
                                        class="block px-6 py-2 hover:text-white hover:bg-indigo-500"
                                        >Мой профиль</Link
                                    >
                                    <Link
                                        class="block px-6 py-2 hover:text-white hover:bg-indigo-500"
                                        href="/users"
                                        >Управлять пользователями</Link
                                    >
                                    <Link
                                        class="block px-6 py-2 w-full text-left hover:text-white hover:bg-indigo-500"
                                        :href="route('logout')"
                                        method="post"
                                        as="button"
                                        >Выйти</Link
                                    >
                                </div>
                            </template>
                        </BreezeDropdown>
                    </div>
                    <!-- /Settings Dropdown -->
                </div>
                <!-- /Settings Dropdown -->
            </div>

            <div class="h-full w-full bg-gray-200 p-2">
                <slot />
            </div>
        </div>
        <!-- /Верхний сайтбар и контент -->
    </div>
</template>
