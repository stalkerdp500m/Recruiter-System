<script setup>
import { onMounted, ref } from "vue";
import { Link, usePage } from "@inertiajs/inertia-vue3";
const masageClasses = ref("");
const masageIcon = ref("");
// const props = defineProps({
//     massages: Object
// });

// watch(usePage().props.value, () => {
//     usePage().props.value.flash.newFlash = false;
//     //   usePage().props.value.flash.newFlash = true;
//     console.log(usePage().props.value.flash);
// })

onMounted(() => {

    console.log(usePage().props.value.flash.newFlash);

    switch (usePage().props.value.flash.type) {
        case "success":
            masageClasses.value = "bg-systems-700/60 text-white ";
            masageIcon.value = "M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z";
            break;
        case "danger":
            masageClasses.value = "bg-red-700/60 text-white";
            masageIcon.value = "M10 1.944A11.954 11.954 0 012.166 5C2.056 5.649 2 6.319 2 7c0 5.225 3.34 9.67 8 11.317C14.66 16.67 18 12.225 18 7c0-.682-.057-1.35-.166-2.001A11.954 11.954 0 0110 1.944zM11 14a1 1 0 11-2 0 1 1 0 012 0zm0-7a1 1 0 10-2 0v3a1 1 0 102 0V7z";
            break;

        default:
            break;
    }
    setTimeout(() => {

        usePage().props.value.flash.newFlash = false
    }, 4000);
})

</script>




<template>

    <!-- <div @click="usePage().props.value.flash.newFlash = false"
            class=" w-screen h-screen absolute z-50 bg-systems-700/20">
        </div> -->



    <!-- :class="hidde?' truncate opacity-50 scale-0 left-10 ':'scale-125 left-6'" -->
    <div :class="masageClasses"
        class=" flex  backdrop-blur-xl z-50 max-w-md absolute  top-2 px-3 py-2 rounded-md left-6 shadow duration-1000 items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
            stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" :d="masageIcon" />
        </svg>
        <h1 class="text-xl px-4  font-medium">

            {{ $page.props.flash.massage }}
        </h1>
    </div>



</template>

