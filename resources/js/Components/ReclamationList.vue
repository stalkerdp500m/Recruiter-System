<script setup>
import { useForm } from "@inertiajs/inertia-vue3";
import { ref, reactive } from "vue";
import { Inertia } from '@inertiajs/inertia';
// import { defineEmits } from 'vue'


const props = defineProps({
    reclamations: Object
});


</script>

<template>
    <div>

        <div class=" flex flex-col">
            <div class="p-2 my-2 shadow-sm rounded-md bg-white" v-for="reclamation in props.reclamations">{{ reclamation
            }}
            </div>
        </div>

    </div>
</template>