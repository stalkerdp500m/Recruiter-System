<script setup>
import BreezeDropdown from "@/Components/Breeze/Dropdown.vue";
import { Link } from "@inertiajs/inertia-vue3";
</script>

<template>
    <div class="flex items-center ml-6 px-5 transition-all">
        <div class="ml-3 relative">
            <BreezeDropdown align="left" width="48">
                <template #trigger>
                    <div class="group flex items-center cursor-pointer select-none">
                        <div
                            class="mr-1 text-black font-bold group-hover:text-indigo-700 focus:text-indigo-600 whitespace-nowrap">
                            <span>{{  $page.props.auth.user.name  }}</span>
                        </div>
                        <!-- <icon
                                                class="w-5 h-5 fill-gray-700 group-hover:fill-indigo-600 focus:fill-indigo-600"
                                                name="cheveron-down"
                                            /> -->
                    </div>
                </template>
                <template #content>
                    <div class="mt-2 py-2 text-sm   rounded shadow-xl cursor-pointer">
                        <Link :href="route('profile')" class="block px-6 py-2 hover:text-white hover:bg-systems-700 ">
                        Мой
                        профиль
                        </Link>
                        <Link class="block px-6 py-2 hover:text-white hover:bg-systems-700 " href="/users">Управлять
                        пользователями</Link>
                        <Link class="block px-6 py-2 w-full text-left hover:text-white hover:bg-systems-700 "
                            :href="route('logout')" method="post" as="button">Выйти</Link>
                    </div>
                </template>
            </BreezeDropdown>
        </div>
    </div>
</template>
