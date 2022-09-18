<script setup>
import BreezeButton from "@/Components/Breeze/Button.vue";
import BreezeGuestLayout from "@/Layouts/Guest.vue";
import BreezeInput from "@/Components/Breeze/Input.vue";
import BreezeLabel from "@/Components/Breeze/Label.vue";
import BreezeValidationErrors from "@/Components/Breeze/ValidationErrors.vue";
import { Head, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    email: String,
    token: String,
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: "",
    password_confirmation: "",
});

const submit = () => {
    form.post(route("password.update"), {
        onFinish: () => form.reset("password", "password_confirmation"),
    });
};
</script>

<template>
    <BreezeGuestLayout>

        <Head title="Сброс пароля" />

        <BreezeValidationErrors class="mb-4" />

        <form @submit.prevent="submit">
            <div class="text-center my-4 ">ФОРМА ВОССТАНОВЛЕНИЯ ПАРОЛЯ</div>
            <div v-if="!props.token">
                <BreezeLabel for="email" value="Email" />
                <BreezeInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus
                    autocomplete="username" />
            </div>

            <div class="mt-4">
                <BreezeLabel for="password" value="Новый пароль" />
                <BreezeInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required
                    autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <BreezeLabel for="password_confirmation" value="Повторите новый пароль" />
                <BreezeInput id="password_confirmation" type="password" class="mt-1 block w-full"
                    v-model="form.password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <BreezeButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Сохранить новый пароль
                </BreezeButton>
            </div>
        </form>
    </BreezeGuestLayout>
</template>
