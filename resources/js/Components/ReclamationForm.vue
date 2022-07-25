<script setup>
import { useForm } from "@inertiajs/inertia-vue3";
import { ref, reactive } from "vue";
import { Inertia } from '@inertiajs/inertia';
import SummaryClient from "@/Components/SummaryClient.vue";
// import { defineEmits } from 'vue'


const props = defineProps({
    showForm: Boolean,
    periodList: Object,
    recruiterList: Object,
});
const emit = defineEmits(['hide']);



const beforeSearch = ref(false);
const pasportSearh = ref('');

const reclamationForm = useForm({
    'pasport': '',
    'project': '',
    'client_id': '',
    'client_name': '',
    'recruiter_id': '',
    'period': '',
    'comment': ''
});


if (props.recruiterList.recruiters.length == 1) {
    reclamationForm.recruiter_id = props.recruiterList.recruiters[0].id;
}


function serchClient () {
    pasportSearh.value = reclamationForm.pasport;
    beforeSearch.value = true;
}

function sendReclamation () {
    reclamationForm.post('./reclamations', {
        onSuccess: () => {
            clear();
        }
    });
}

function clientDataAutocomplete (data) {
    console.log('data', data);
    if (data.pasport == reclamationForm.pasport) {
        reclamationForm.client_name = data.name
        reclamationForm.client_id = data.client_id
    }
}

function clear () {
    reclamationForm.reset();
    beforeSearch.value = false;
    emit('hide');
}


</script>

<template>


    <div v-if="props.showForm" class="fixed z-50 inset-0 overflow-y-auto">


        <div class="flex items-end sm:items-center justify-center min-h-full p-4 text-center sm:p-0">
            <div @click="$emit('hide')" class="fixed inset-0 bg-systems-500/80 transition-opacity "></div>
            <div
                class="relative  my-auto  bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-lg sm:w-full">
                <div class="bg-white">
                    <!-- Кнопка закрыть -->
                    <div class="flex justify-end  "><svg @click="$emit('hide')" xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6 cursor-pointer absolute right-1 top-1 " fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg></div>
                    <!-- /Кнопка закрыть -->


                    <!-- Результаты поиска -->
                    <div v-if="beforeSearch" class=" bg-systems-300  p-2">
                        <SummaryClient @reciveClientData="clientDataAutocomplete" :pasport="pasportSearh" />
                    </div>



                    <!-- Поиск клиента -->
                    <div v-if="!beforeSearch" class=" p-4 text-center rounded-md">
                        <div> Введите паспорт клиента</div>
                        <form @submit.prevent="serchClient" class=" flex justify-center py-5 gap-2 flex-wrap">
                            <input type="text" v-model="reclamationForm.pasport" class="rounded-md w-2/5 "
                                placeholder="Паспорт клиента">
                            <button :disabled="reclamationForm.pasport.length < 6" type="submit"
                                class="rounded-md px-3 disabled:bg-gray-500/60  py-2 bg-systems-700  cursor-pointer text-white flex flex-row items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1  " fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                Искать
                            </button>
                        </form>
                    </div>
                    <!-- /Поиск клиента -->



                    <!-- форма рекламации -->
                    <div v-if="beforeSearch" class=" p-4  rounded-md text-center">
                        <div class=" text-xl"> Форма рекламации</div>
                        <form @submit.prevent="sendReclamation" class=" flex justify-evenly py-5 gap-2 flex-wrap">
                            <div class="flex  justify-evenly flex-wrap md:flex-nowrap w-full">
                                <div class="md:w-1/3 w-full">
                                    <p class="text-center">Паспорт</p>
                                    <input disabled required type="text" v-model="reclamationForm.pasport"
                                        class="rounded-md md:w-3/4" placeholder="Паспорт клиента">
                                </div>

                                <div class="">
                                    <p class="text-center">Фамилия/Имя</p>
                                    <input required type="text" v-model="reclamationForm.client_name"
                                        class="rounded-md " placeholder="Фамилия/Имя клиента">
                                </div>
                                <div class="md:w-2/5 w-full">
                                    <p class="text-center">Фактура</p>
                                    <select required id="period" v-model="reclamationForm.period"
                                        @change="selectedRange"
                                        class=" form-select cursor-pointer focus:ring-0  bg-transparent rounded-md md:w-3/4">
                                        <option v-for="month in props.periodList">{{ month.period }}</option>
                                    </select>
                                </div>
                            </div>


                            <div class="flex justify-evenly flex-wrap md:flex-nowrap w-full my-4">

                                <div class="w-1/2">
                                    <p class="text-center">Рекрутер</p>
                                    <!-- <div v-for="recruiter in props.recruiterList">{{ recruiter }}</div> -->
                                    <select required class="rounded-md w-full " v-model="reclamationForm.recruiter_id">
                                        <option v-for="recruiter in props.recruiterList.recruiters"
                                            :value="recruiter.id">{{ recruiter.name }}
                                        </option>
                                    </select>
                                    <!-- <input type="text" v-model="reclamationForm.recruiter_id" class="rounded-md  "
                                    placeholder="Рекрутер"> -->

                                </div>
                                <div class="">
                                    <p class="text-center">Проект</p>
                                    <input type="text" required v-model="reclamationForm.project" class="rounded-md  "
                                        placeholder="Проект">
                                </div>
                            </div>
                            <div class="w-11/12">
                                <p class="text-center">Коментарий</p>
                                <textarea required v-model="reclamationForm.comment" class="rounded-md w-full "
                                    placeholder="коментарий"> </textarea>
                            </div>

                            <div class="flex gap-6">
                                <div @click="clear"
                                    class="rounded-md px-3 disabled:bg-gray-500/60  py-2 bg-red-700  cursor-pointer text-white flex flex-row items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1  " fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Отмена
                                </div>


                                <button type="submit" :disabled="reclamationForm.processing"
                                    class="rounded-md px-3 disabled:bg-gray-500/60  py-2 bg-green-600 cursor-pointer text-white flex flex-row items-center">
                                    <svg v-if="!reclamationForm.processing" xmlns="http://www.w3.org/2000/svg"
                                        class="h-4 w-4 mr-1  " fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                    </svg>
                                    <svg v-else class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    {{ reclamationForm.processing ? `Сохраняю` : `Отправить` }}
                                </button>
                            </div>
                            <div v-if="Object.keys($page.props.errors).length"
                                class=" text-center text-white p-3 mt-4 bg-red-600 mx-auto rounded-md">
                                <div>Ошибки формы</div>
                                <ul>
                                    <li v-for="error in $page.props.errors">{{ error }}</li>
                                </ul>
                            </div>

                        </form>
                    </div>
                    <!-- /форма рекламации-->
                </div>
            </div>

        </div>
    </div>
</template>