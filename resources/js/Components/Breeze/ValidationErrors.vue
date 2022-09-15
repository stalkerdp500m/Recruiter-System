<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/inertia-vue3';

const errors = computed(() => usePage().props.value.errors);

const countErrors = computed(() => Object.keys(errors.value).length);
</script>

<template>
    <div v-if="countErrors > 0">
        <div class="font-medium text-red-600">
            {{ countErrors == 1 ? "Нужно исправить небольшую ошибку" : "Упс, есть пару ошибок в форме" }}
        </div>

        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
            <li v-for="(error, key) in         errors" :key="key">{{ error }}</li>
        </ul>
    </div>
</template>
