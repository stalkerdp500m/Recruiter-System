<script setup>
import BreezeButton from '@/Components/Breeze/Button.vue';
import BreezeCheckbox from '@/Components/Breeze/Checkbox.vue';
import BreezeGuestLayout from '@/Layouts/Guest.vue';
import BreezeInput from '@/Components/Breeze/Input.vue';
import BreezeLabel from '@/Components/Breeze/Label.vue';
import BreezeValidationErrors from '@/Components/Breeze/ValidationErrors.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: true
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <BreezeGuestLayout>

        <Head title="Log in" />

        <BreezeValidationErrors class="mb-4" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit" autocomplete="on">
            <div class="text-center my-4 ">ФОРМА ВХОДА</div>
            <div>
                <BreezeLabel for="email" value="Email" />
                <BreezeInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus
                    autocomplete="username" />
            </div>

            <div class="mt-4">
                <BreezeLabel for="password" value="Пароль" />
                <BreezeInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required
                    autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label class="flex items-center">
                    <BreezeCheckbox name="remember" v-model:checked="form.remember" />
                    <span class="ml-2 text-sm text-gray-600">Запомнить меня</span>
                </label>
            </div>

            <div class="flex items-center justify-between mt-4 ">
                <div>
                    <Link v-if="canResetPassword" :href="route('password.request')"
                        class="underline text-left text-sm text-gray-600 hover:text-gray-900">
                    Забыли пароль?
                    </Link>
                </div>
                <div>
                    <BreezeButton class="mr-4 bg-green-700" :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing">
                        Вход
                    </BreezeButton>
                    <Link v-if="canResetPassword" :href="route('register')"
                        class=" bg-systems-400 text-sm px-2 py-1 text-black font-bold  rounded-md hover:text-gray-900">
                    Регистрация
                    </Link>

                </div>
            </div>
        </form>
    </BreezeGuestLayout>
</template>
