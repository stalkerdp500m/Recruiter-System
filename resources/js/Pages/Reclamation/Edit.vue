<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import { Link, useForm, usePage } from "@inertiajs/inertia-vue3";
import { Head } from "@inertiajs/inertia-vue3";
import SummaryClient from "@/Components/SummaryClient.vue";
import { ref } from "vue";



const props = defineProps({
    reclamation: Object,
    statuseList: Object,
});
const userName = usePage().props.value.auth.user.name
const userRole = usePage().props.value.auth.user.role


//console.log(props.reclamation);
const updateReclamationForm = useForm({
    'comments': props.reclamation.comments,
    'status_id': props.reclamation.status.id,
    'answer': props.reclamation.answer
});

function canAnswer (role) {
    return role == "accountant";
}

const newComment = ref('');


const statusColors = {
    1: { 'label': 'bg-systems-300', 'bg': 'bg-systems-100' },
    2: { 'label': 'bg-yellow-300', 'bg': 'bg-yellow-100' },
    3: { 'label': 'bg-green-300', 'bg': 'bg-green-100' },
    4: { 'label': 'bg-red-300', 'bg': 'bg-red-100' }
}

function toLocaleDate (date) {
    return new Date(date).toLocaleDateString('ru-RU', { year: '2-digit', month: 'numeric', day: 'numeric', hour: 'numeric', minute: 'numeric' });
}

function updateReclamation () {
    if (newComment.value) {
        updateReclamationForm.transform(form => {
            form.comments.push({
                "sendedAt": new Date,
                "message": newComment.value,
                "user": userName,
                "role": userRole
            })
            return form

        })
    }
    updateReclamationForm.put(route('reclamations.update', { 'id': props.reclamation.id }), { preserveScroll: true });
    newComment.value = '';
}
</script>

<template>

    <Head title="Рекламации" />

    <MainLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Рекламация
            </h2>
        </template>



        <div class="py-2 md:w-full  mx-auto">



            <!-- данные по рекламации -->

            <div class=" bg-white flex flex-col gap-4 p-3 rounded-md my-4"
                :class="reclamation.deleted_at ? 'contrast-50' : ''">
                <!-- /данные по рекламации -->
                <div class=" bg-systems-300 mt-0 rounded-md p-2">
                    <SummaryClient :pasport="props.reclamation?.client.pasport" />
                </div>
                <div v-if="reclamation.deleted_at" class=" text-center p-4 font-semibold uppercase">Рекламация в архиве
                </div>
                <div v-else class=" text-center p-4 font-semibold uppercase">Данные по рекламации
                </div>
                <div class="w-fit ">
                    <p><span class=" font-bold "> Статус: </span>
                        <span v-if="!canAnswer(userRole)" class="px-2 py-1 rounded-sm"
                            :class="statusColors[props.reclamation.status.id].label"> {{ props.reclamation.status.title
                            }}</span>
                        <span v-else :class="statusColors[updateReclamationForm.status_id].label"
                            class="px-2 py-1 rounded-sm">
                            <select @change="updateReclamation" v-model="updateReclamationForm.status_id" id="status"
                                name="status"
                                class=" form-select   cursor-pointer focus:ring-0 ring-0 border-0  bg-transparent "
                                aria-label="year">
                                <option v-for="status in props.statuseList" :value="status.id">{{ status.title }}
                                </option>
                            </select>
                        </span>

                    </p>
                </div>
                <div>
                    <p> <span class=" font-bold "> Отправлена: </span> {{
                    props.reclamation.user.name
                    }} - {{ toLocaleDate(props.reclamation.created_at) }}</p>
                </div>
                <div>
                    <p> <span class=" font-bold "> Рекрутер: </span> {{ props.reclamation.recruiter.name }}</p>
                </div>
                <div>
                    <p> <span class=" font-bold "> Клиент: </span> {{ props.reclamation.client.name }}, {{
                    props.reclamation.client.pasport
                    }}</p>
                </div>
                <div>
                    <p><span class=" font-bold ">Проект и период оплаты: </span> {{ props.reclamation.project }}, {{
                    props.reclamation.period
                    }}</p>
                </div>
                <div>
                    <p class="my-2"> <span class=" font-bold "> Ответ: </span> <span
                            class="mx-2 bg-systems-300 px-2 rounded-md " v-if="props.reclamation.answerer">предоставлен
                            {{props.reclamation.answerer.name}}</span></p>
                    <p v-if="!canAnswer(userRole)"
                        class="p-2 my-2 border border-systems-900 rounded-t-md rounded-r-md bg-systems-200"> {{
                        props.reclamation.answer ? props.reclamation.answer : 'Еще не предоставлен'
                        }}</p>

                    <p v-else>
                    <form @submit.prevent="updateReclamation"
                        class=" flex justify-start items-center  gap-2 flex-wrap w-full">
                        <textarea required class="rounded-md w-8/12 " placeholder="Ответить на рекламацию"
                            v-model="updateReclamationForm.answer"></textarea>
                        <button type="submit" :disabled="updateReclamationForm.processing"
                            class="rounded-md px-3 disabled:bg-gray-500/60 h-10  bg-green-600 cursor-pointer text-white  items-center">
                            {{ updateReclamationForm.processing ? `Сохраняю` : props.reclamation.answer ? `Обновить
                            ответ` :
                            `Отправить`
                            }}
                        </button>
                    </form>

                    </p>
                </div>
                <div>
                    <p class=" font-bold ">Комментарии</p>
                    <p class="p-2 my-2 border border-systems-600 " v-for="comment, i in props.reclamation.comments"
                        :key="i"
                        :class="canAnswer(comment.role) ? 'bg-systems-300 text-right rounded-t-md rounded-l-md' : 'rounded-t-md rounded-r-md'">
                        {{
                        comment.message
                        }} <br> <span class=" text-xs "><b>{{ comment.user }}</b> {{ toLocaleDate(comment.sendedAt) }}
                        </span></p>
                    <form @submit.prevent="updateReclamation"
                        class=" flex justify-evenly items-center py-2 gap-2 flex-wrap w-full">
                        <textarea required class="rounded-md w-8/12 " placeholder="Добавить комментарий"
                            v-model="newComment"></textarea>
                        <button type="submit" :disabled="updateReclamationForm.processing"
                            class="rounded-md px-3 disabled:bg-gray-500/60 h-10  bg-green-600 cursor-pointer text-white  items-center">
                            {{ updateReclamationForm.processing ? `Сохраняю` : `Отправить` }}
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </MainLayout>
</template>
