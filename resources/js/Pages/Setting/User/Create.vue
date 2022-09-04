<script setup>
import BreezeButton from "@/Components/Breeze/Button.vue";
import { ref } from "vue";
import MainLayout from "@/Layouts/MainLayout.vue";
import VueMultiselect from 'vue-multiselect'
import BreezeInput from "@/Components/Breeze/Input.vue";
import BreezeLabel from "@/Components/Breeze/Label.vue";
import BreezeValidationErrors from "@/Components/Breeze/ValidationErrors.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    teamsList: Object,
    roleList: Object,
    recruiterList: Object,
});

const form = useForm({
    name: "",
    email: "",
    role: "user",
    recruiters: "",
    team: false,
    password: "",
    // dontConfirmMail: true
});

function pasGenerate () {
    const CharacterSet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'
    let password = CharacterSet.charAt(new Date().getSeconds());
    for (let i = 0; i < 7; i++) {
        password += CharacterSet.charAt(Math.floor(Math.random() * CharacterSet.length));
    }
    form.password = password;
}

const emailErrors = ref(undefined);

function chekEmail () {
    axios
        .post(route('users.checkEmail'), { email: form.email })
        .then((response) => {
            console.log(response.data);
            if (response.status == "200") {
                if (response.data.email) {
                    emailErrors.value = response.data.email;
                }
                else emailErrors.value = false;
            }
        });
    console.log(form.email);
}

const submit = () => {
    // console.log(form);
    form.post(route("users.store"), {
        onFinish: () => form.reset('name', 'email'),
    });
};
</script>

    <template>

    <Head title="Добавить пользователя" />

    <MainLayout>

        <form @submit.prevent="submit" autocomplete="off" class="w-10/12 md:w-1/2 mx-auto">
            <div class="text-center my-4 ">Добавить пользователя</div>

            <div class="mt-4  ">
                <BreezeLabel for="new_email" value="Email" />
                <div class=" flex flex-row ">
                    <BreezeInput @blur="chekEmail" id="new_email" type="email" class="mt-1  w-full" v-model="form.email"
                        required autofocus />
                    <div class="pt-2 px-2 mt-1 -ml-3  bg-white rounded-r-md ">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                            :class="emailErrors ? 'text-red-600' : 'text-green-600'" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <!-- absolute left-3/4 -->
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
                <BreezeLabel for="name" value="Имя" />
                <BreezeInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required />
            </div>

            <div class="mt-4 flex md:flex-nowrap flex-wrap gap-1 justify-between">
                <div class="w-full md:w-1/3">
                    <BreezeLabel for="team" value="Роль" />
                    <select id="team" v-model="form.role"
                        class=" border-gray-300 focus:border-indigo-300  focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm  form-select   cursor-pointer focus:ring-0 mt-1 block w-full">
                        <option :value="role" v-for="role in props.roleList">{{ role }}</option>
                    </select>
                </div>

                <div class="w-full md:w-2/3">
                    <BreezeLabel for="team" value="Команда" />
                    <select id="team" v-model="form.team"
                        class=" border-gray-300 focus:border-indigo-300  focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm  form-select   cursor-pointer focus:ring-0 mt-1 block w-full">
                        <option :value="team.id" v-for="team in props.teamsList">{{ team.name }}</option>
                        <option :value="null">Нет нужной</option>
                    </select>
                </div>
            </div>
            <div class="mt-4">
                <BreezeLabel for="new_password" value="Пароль" />
                <div class="flex   gap-1 justify-between items-center">
                    <div class="w-3/4">
                        <BreezeInput id="new_password" type="text" class="mt-1 block w-full" v-model="form.password"
                            required autocomplete="new-password" />
                    </div>
                    <div class="w-1/6">

                        <div class="rounded-md bg-white  shadow-md  py-2  cursor-pointer flex " @click="pasGenerate">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-6 w-6 mx-auto text-center text-systems-700 " fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 12c0-1.232-.046-2.453-.138-3.662a4.006 4.006 0 00-3.7-3.7 48.678 48.678 0 00-7.324 0 4.006 4.006 0 00-3.7 3.7c-.017.22-.032.441-.046.662M19.5 12l3-3m-3 3l-3-3m-12 3c0 1.232.046 2.453.138 3.662a4.006 4.006 0 003.7 3.7 48.656 48.656 0 007.324 0 4.006 4.006 0 003.7-3.7c.017-.22.032-.441.046-.662M4.5 12l3 3m-3-3l-3 3" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-4" v-if="form.role != 'assistant'">
                <BreezeLabel for=" new_password" value="Доступ к рекрутерам" />
                <VueMultiselect :multiple="true" selectLabel="добавить рекрутера" deselectLabel="убрать рекрутера"
                    v-model="form.recruiters" track-by="name" :options="props.recruiterList" label="name"
                    :searchable="true" placeholder="поиск рекрутера">
                </VueMultiselect>
            </div>



            <div class="flex  justify-center mt-4 ">
                <!-- <input v-model="form.dontConfirmMail"
                    class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer"
                    type="checkbox" value="" id="dontConfirmMail">
                <label class="form-check-label inline-block text-gray-800" for="dontConfirmMail">
                    Без подтверждения почты
                </label> -->
                <BreezeButton class="ml-4 font-bold" :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing">
                    Добавить пользователя
                </BreezeButton>
            </div>
        </form>
        <BreezeValidationErrors class="mb-4 bg-white rounded-md p-4 w-10/12 md:w-1/2 mx-auto my-5" />
    </MainLayout>
</template>

<style src="vue-multiselect/dist/vue-multiselect.css">
</style>