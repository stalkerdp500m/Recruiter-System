<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import ReclamationForm from "@/Components/ReclamationForm.vue";
import ReclamationList from "@/Components/ReclamationList.vue";
import VueMultiselect from 'vue-multiselect'
import { Link, useForm } from "@inertiajs/inertia-vue3";
import { Head } from "@inertiajs/inertia-vue3";
import { reactive, ref } from "vue";



const props = defineProps({
    periodList: Object,
    recruiterList: Object,
    reclamations: Object,
    statuseList: Object,
    trashed: String
});

console.log(props);


const showForm = ref(false);
const statuseShortList = ref([]);
const statuses = [];

for (const key in props.statuseList) {
    statuses.push({ 'title': key, 'statusId': props.statuseList[key] })
}

const searchPasport = ref('');



function selectedStatus (list) {
    let statuseArr = list.map(status => {
        return status.statusId
    })
    props.reclamations.map((reclamation) => {
        if (statuseArr.length == 0 || statuseArr.indexOf(reclamation.status.id) != -1) {
            reclamation.hidden = false
        } else {
            reclamation.hidden = true
        }
    })
}

function serched () {
    let pasport = searchPasport.value.toUpperCase();
    console.log(pasport);
    if (searchPasport.value.length >= 3) {
        props.reclamations.map((reclamation) => {
            if (reclamation.client.pasport.toUpperCase().indexOf(pasport) != -1) {
                reclamation.hidden = false
            } else {
                reclamation.hidden = true
            }
        })
    } else if (searchPasport.value.length == 0) {
        props.reclamations.map((reclamation) => { reclamation.hidden = false })
    }
}

const isTrashed = useForm({
    trashed: props.trashed
});
function selectTrashed () {
    isTrashed.get('/reclamations')
}

</script>

<template>

    <Head title="Рекламации" />

    <MainLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Рекламации
            </h2>
        </template>



        <div class="py-2 md:w-full  mx-auto">
            <div class="flex h-20 items-center px-10">
                <div @click="showForm = true"
                    class="bg-systems-800 rounded-md text-white shadow-md px-4 py-2  text-center cursor-pointer flex">
                    Добавить рекламацию
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-3 " fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <!-- Фильтры
            поиск, фильтр статусы, архивные
            -->
            <div class=" my-4  rounded-md w-full gap-2  flex items-center md:justify-center justify-evenly flex-wrap">
                <div class=" md:w-2/6 justify-center flex items-center w-11/12 ">
                    <VueMultiselect @update:model-value="selectedStatus" :multiple="true"
                        selectLabel="добавить в фильтр" deselectLabel="убрать из фильтра" v-model="statuseShortList"
                        track-by="title" :options="statuses" label="title" :searchable="false"
                        placeholder="фильтровать по статусам">
                    </VueMultiselect>
                </div>


                <div class=" md:w-2/6 w-6/12  justify-center flex items-center bg-white rounded-md ">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2  z-10  " fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input @input="serched" type="text" v-model="searchPasport"
                        class=" h-10  w-full md:w-4/5 focus:ring-0 border-0 " placeholder="Найти по паспорту">
                </div>


                <div class=" md:w-1/6 w-4/12 justify-center flex items-center ">
                    <select @change="selectTrashed" v-model="isTrashed.trashed"
                        :class="props.trashed == 'only' ? 'bg-slate-400' : 'bg-green-400'"
                        class=" form-select rounded-md shadow-md cursor-pointer " name="" id="">
                        <option class="bg-slate-400 " value="only">В архиве </option>
                        <option class="bg-green-400" value="no">Активные </option>
                    </select>
                </div>
            </div>
            <!-- /Фильтры -->


            <div class="md:px-10">
                <!-- <ReclamationList v-for="recruiter in props.reclamations.recruiters"
                    :reclamations="recruiter.reclamations" /> -->
                <ReclamationList :reclamations="props.reclamations" />
            </div>

            <ReclamationForm :periodList="props.periodList" :recruiterList="props.recruiterList" :showForm="showForm"
                @hide="showForm = false" />
        </div>
    </MainLayout>
</template>
<style src="vue-multiselect/dist/vue-multiselect.css">

</style>