<script setup>
import { computed } from "vue";
import BreezeButton from "@/Components/Breeze/Button.vue";
import BreezeGuestLayout from "@/Layouts/Guest.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    status: String,
});

const form = useForm();

const submit = () => {
    form.post(route("verification.send"));
};

const verificationLinkSent = computed(
    () => props.status === "verification-link-sent"
);
</script>

<template>
    <BreezeGuestLayout>

        <Head title="Email Verification" />

        <div class="mb-4 text-sm text-gray-600">
            Спасибо за регистрацию! Прежде чем начать, пожалуйста подтвердите
            адрес электронной почты, нажав на ссылку, которую мы только что отправили вам по электронной почте.
        </div>

        <div class="mb-4 font-medium text-sm text-green-600" v-if="verificationLinkSent">
            Новая ссылка отправлена на ваш Email
        </div>

        <form @submit.prevent="submit">
            <div class="mt-4 flex items-center justify-between">
                <BreezeButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Отправить повторно
                </BreezeButton>

                <Link :href="route('logout')" method="post" as="button"
                    class="underline text-sm text-gray-600 hover:text-gray-900">Выйти</Link>
            </div>
        </form>
    </BreezeGuestLayout>
</template>
