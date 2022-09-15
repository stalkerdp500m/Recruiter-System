<script setup>
import { useForm, usePage } from "@inertiajs/inertia-vue3";
import { ref, reactive } from "vue";
import { Inertia } from '@inertiajs/inertia';
import BreezeInput from "@/Components/Breeze/Input.vue";
import BreezeLabel from "@/Components/Breeze/Label.vue";
import BreezeButton from "@/Components/Breeze/Button.vue";
import BreezeValidationErrors from "@/Components/Breeze/ValidationErrors.vue";


const props = defineProps({
    showForm: Boolean,
    teamsList: Object,
});


const beforeSearch = ref(false);
const pasportSearh = ref('');

const newRecruiterForm = useForm({
    'email': '',
    'name': '',
    'team': ''
});


const emailErrors = ref(undefined);

function chekEmail () {
    axios
        .post(route('control.recruiters.checkEmail'), { email: newRecruiterForm.email })
        .then((response) => {
            if (response.status == "200") {
                if (response.data.email) {
                    emailErrors.value = response.data.email;
                }
                else emailErrors.value = false;
            }
        });

}

const submit = () => {
    newRecruiterForm.post(route("control.recruiters.store"), {
        onSuccess: () => {
            newRecruiterForm.reset();
            Inertia.visit(route('control.recruiters.index'), { only: ['recruiterList'],preserveScroll: true })
        }
    });
};

</script>

<template>


    <div v-if="props.showForm" class="  rounded-md p-2 m-4 border">
        <form @submit.prevent="submit" autocomplete="off" class="w-10/12 md:w-1/2 mx-auto">
            <div class="text-center my-4 ">Форма добавления рекрутера</div>

            <div class="mt-4">
                <BreezeLabel for="name" value="Название" class="text-white font-bold " />
                <BreezeInput id="name" type="text" class="mt-1 block w-full" v-model="newRecruiterForm.name" required
                    autofocus />
            </div>

            <div class="mt-4">
                <BreezeLabel for="recruiter_email" value="Email" class="text-white font-bold " />
                <div class=" flex flex-row ">
                    <BreezeInput @blur="chekEmail" id="recruiter_email" type="email" class="mt-1 w-full "
                        v-model="newRecruiterForm.email" required />
                    <div class="pt-2 px-2 mt-1 -ml-3  bg-white rounded-r-md ">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                            :class="emailErrors ? 'text-red-600' : 'text-green-600'" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path v-if="emailErrors" stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                            <path v-else-if="emailErrors != undefined" stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="text-red-500 bg-white rounded-md p-1 my-2 text-center font-bold"
                    v-for="error in emailErrors">
                    {{ error }}</div>
            </div>

            <div class="mt-4">
                <BreezeLabel for="team" value="Команда" class="text-white font-bold " />
                <select id="team" v-model="newRecruiterForm.team"
                    class=" border-gray-300 focus:border-indigo-300  focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm  form-select   cursor-pointer focus:ring-0 mt-1 block w-full">
                    <option :value="team.id" v-for="team in props.teamsList">{{ team.name }}</option>
                    <option :value="null">Нет нужной</option>
                </select>
            </div>


            <div class="flex  justify-center mt-4 ">
                <BreezeButton class="ml-4 font-bold" :class="{ 'opacity-25': newRecruiterForm.processing }"
                    :disabled="newRecruiterForm.processing">
                    Добавить Рекрутера
                </BreezeButton>
            </div>
        </form>
        <BreezeValidationErrors class="mb-4 bg-white rounded-md p-4 w-10/12 md:w-1/2 mx-auto my-5" />

    </div>
</template>