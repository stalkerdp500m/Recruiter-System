<script setup>
import { ref, watch } from "vue";
import { Link, usePage } from "@inertiajs/inertia-vue3";
const masages = ref([usePage().props.value.flash]);

watch(() => usePage().props.value.flash, () => {
    let msgId = masages.value.length
    masages.value.push(usePage().props.value.flash)
    setTimeout(() => {
        masages.value[msgId].newFlash = false;
    }, 4000);
})

function masageDecoration (type) {
    switch (type) {
        case "success":
            return {
                masageClasses: "bg-systems-700/60 text-white ",
                masageIcon: "M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
            }
        case "danger":
            return {
                masageClasses: "bg-red-700/60 text-white",
                masageIcon: "M10 1.944A11.954 11.954 0 012.166 5C2.056 5.649 2 6.319 2 7c0 5.225 3.34 9.67 8 11.317C14.66 16.67 18 12.225 18 7c0-.682-.057-1.35-.166-2.001A11.954 11.954 0 0110 1.944zM11 14a1 1 0 11-2 0 1 1 0 012 0zm0-7a1 1 0 10-2 0v3a1 1 0 102 0V7z"
            }
        default:
            return {
                masageClasses: "",
                masageIcon: ""
            }
    }

}
</script>




<template>
    <transition-group tag="div" class="m-2" enter-from-class="opacity-0 -translate-x-full" enter-active-class=""
        enter-class="opacity-0 duration-1000  -translate-x-full duration-1000"
        enter-to-class="opacity-100 translate-x-0  translate-y-0" leave-active-class="m-2 absolute"
        leave-class="opacity-100  " leave-to-class="opacity-0 translate-x-20 duration-1000 ">
        <div :class="masageDecoration(masage.type).masageClasses" v-for="(masage, i) in masages" :key="i"
            v-show="masage.newFlash"
            class=" flex  backdrop-blur-xl z-50 max-w-md my-2  top-2 px-3 py-2 rounded-md transition-all left-6 shadow duration-1000 items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" :d="masageDecoration(masage.type).masageIcon" />
            </svg>
            <h1 class="text-xl px-4  font-medium">
                {{ masage.massage }}
            </h1>
        </div>
    </transition-group>



</template>

