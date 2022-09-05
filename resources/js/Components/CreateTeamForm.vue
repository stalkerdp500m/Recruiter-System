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
    'name': '',
});




const submit = () => {
    newRecruiterForm.post(route("control.teams.store"), {
        onSuccess: () => {
            newRecruiterForm.reset();
            Inertia.visit(route('control.teams.index'), { only: ['recruiterList'], preserveScroll: true })
        }
    });
};

</script>

<template>


    <div v-if="props.showForm" class="  rounded-md p-2 m-4 border">
        <form @submit.prevent="submit" autocomplete="off" class="w-10/12 md:w-1/2 mx-auto">
            <div class="text-center my-4 ">Форма добавления команды</div>

            <div class="mt-4">
                <BreezeLabel for="name" value="Название" class="text-white font-bold " />
                <BreezeInput id="name" type="text" class="mt-1 block w-full" v-model="newRecruiterForm.name" required
                    autofocus />
            </div>
            <div class="flex  justify-center mt-4 ">
                <BreezeButton class="ml-4 font-bold" :class="{ 'opacity-25': newRecruiterForm.processing }"
                    :disabled="newRecruiterForm.processing">
                    Добавить команду
                </BreezeButton>
            </div>
        </form>
        <BreezeValidationErrors class="mb-4 bg-white rounded-md p-4 w-10/12 md:w-1/2 mx-auto my-5" />

    </div>
</template>