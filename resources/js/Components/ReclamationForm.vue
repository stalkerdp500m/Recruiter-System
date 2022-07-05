<script setup>
import { useForm } from "@inertiajs/inertia-vue3";
import { ref, reactive } from "vue";
import { Inertia } from '@inertiajs/inertia';
// import { defineEmits } from 'vue'


const props = defineProps({
    showForm: Boolean,
});
const beforeSearch = ref(true);
const searchResults = ref('');




function serchClient () {
    console.log(reclamationForm.value);
    axios.post("/clients", reclamationForm.value).then((response) => {
        if (response.status == "200") {
            searchResults.value = response.data.searchResults
        }
    })
    // beforeSearch.value = true;
}


function agregateResult (result) {
    // разбирает результаты поиска и отдает строку По клиенту Х выплат, последняя мм-гггг, Y часов в таблице вынагроджений (работал Z раз) Последний раз мм-ггг
    let maxWorkMonth = 0;
    let maxWorkYear = 0;
    let maxPaymentMonth = 0;
    let maxPaymentYear = 0;
    let countPayments = 0;
    let sumHours = 0;
    let countWorks = 0;

    console.log(result);

}

const reclamationForm = ref({
    'pasport': '',
    'recruiter': '',
    'project': ''
})





// const searchPasport = reactive({
//     'pasport': props.searchPasport.pasport ? props.searchPasport.pasport : '',
// });


// const client = {
//     'name': props.searchResults?.name,
//     'pasport': props.searchResults?.pasport
// }







</script>

<template>

    <div v-if="props.showForm" class="fixed z-10 inset-0 overflow-y-auto">

        <div class="flex items-end sm:items-center justify-center min-h-full p-4 text-center sm:p-0">
            <div class="fixed inset-0 bg-systems-500/80 transition-opacity"></div>
            <div
                class="relative  my-auto  bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-lg sm:w-full">
                <div class="bg-white">
                    <!-- Кнопка закрыть -->
                    <div class="flex justify-end p-2 "><svg @click="$emit('hide')" xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6 cursor-pointer absolute right-3 " fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg></div>
                    <!-- /Кнопка закрыть -->
                    <!-- Поиск клиента -->
                    <div class=" p-4 text-center rounded-md">
                        Введите паспорт клиента
                        <form @submit.prevent="serchClient" class=" flex justify-center py-5 gap-2 flex-wrap">
                            <input @input="beforeSearch = false" type="text" v-model="reclamationForm.pasport"
                                class="rounded-md w-2/5 " placeholder="Паспорт клиента">
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

                    <!-- Результаты поиска -->

                    <div v-if="searchResults" class=" bg-systems-300 ">
                        <div v-if="searchResults.payments">
                            <div>{{ agregateResult(searchResults) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>