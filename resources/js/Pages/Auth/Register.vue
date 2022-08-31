<script setup>
import BreezeButton from "@/Components/Breeze/Button.vue";
import BreezeGuestLayout from "@/Layouts/Guest.vue";
import BreezeInput from "@/Components/Breeze/Input.vue";
import BreezeLabel from "@/Components/Breeze/Label.vue";
import BreezeValidationErrors from "@/Components/Breeze/ValidationErrors.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    teams: Object,
});


const form = useForm({
    name: "",
    email: "",
    team: false,
    password: "",
    password_confirmation: "",
    terms: false,
});

const submit = () => {
    console.log(form);
    form.post(route("register"), {
        onFinish: () => form.reset("password", "password_confirmation"),
    });
};
</script>

<template>
    <BreezeGuestLayout>

        <Head title="Register" />

        <BreezeValidationErrors class="mb-4" />

        <form @submit.prevent="submit">
            <div class="text-center my-4 ">ФОРМА РЕГИСТРАЦИИ</div>
            <div>
                <BreezeLabel for="name" value="Имя" />
                <BreezeInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus
                    autocomplete="name" />
            </div>

            <div class="mt-4">
                <BreezeLabel for="email" value="Email" />
                <BreezeInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required
                    autocomplete="username" />
            </div>
            <div class="mt-4">
                <BreezeLabel for="team" value="Команда" />
                <select id="team" v-model="form.team"
                    class=" border-gray-300 focus:border-indigo-300  focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm  form-select   cursor-pointer focus:ring-0 mt-1 block w-full">
                    <option :value="team.id" v-for="team in props.teams">{{  team.name  }}</option>
                    <option :value="null">Нет нужной</option>
                </select>
            </div>

            <div class="mt-4">
                <BreezeLabel for="password" value="Пароль" />
                <BreezeInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required
                    autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <BreezeLabel for="password_confirmation" value="Повторите пароль" />
                <BreezeInput id="password_confirmation" type="password" class="mt-1 block w-full"
                    v-model="form.password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="flex items-center justify-between mt-4">
                <Link :href="route('login')" class="underline text-sm text-gray-600 hover:text-gray-900">
                Уже зарегистрированы ?
                </Link>

                <BreezeButton class="ml-4 font-bold" :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing">
                    Регистрация
                </BreezeButton>
            </div>
        </form>
    </BreezeGuestLayout>
</template>
