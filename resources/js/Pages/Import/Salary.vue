<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import PaymentsTable from "@/Components/PaymentsTable.vue";
import { Head, useForm } from "@inertiajs/inertia-vue3";
import { ref } from "vue";


const host = window.location.hostname;
const token = ref(false);



function getToken () {
    axios
        .get(route("create-token"), { params: { token_name: 'salary' } })
        .then((response) => {
            if (response.status == "200") {
                if (response.data.token) {
                    token.value = response.data?.token.slice(2);
                }
            }
        });
}


const form = useForm({
    month: new Date().getMonth(),
    year: new Date().getFullYear(),
    file: null
})

function getExampl () {
    form.post('./payments')
}
function storeData () {
    processData.value = true;
    form.post('./payments/store')
}

const processData = ref(false);

let exemplData = {};

function createExempl (rawData) {
    exemplData = rawData.map(paym => {
        return {
            'month': props.month,
            'year': props.year,
            'client': {
                'pasport': paym?.prac_identyfikator,
                'name': paym?.prac_nazwiskoimie
            },
            'recruiter': {
                'name': paym?.prac_rekruternazwiskoimie
            },
            'project': paym?.proj_nazwa,
            'hours': paym?.godziny_uop_enova,
            'bonus': paym?.premrek_kwotapremii_brutto,
            'category': paym?.projrek_kategoriaprojektudopremii,
            'status': paym?.status_wyplaty,

        }
    })
    return exemplData
}





</script>

<template>

    <Head title="Загрузить отработки" />

    <MainLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Загрузить Отработки
            </h2>
        </template>
        <div class="py-16">
            <h1 class="text-center font-bold">Для загрузки информации об отработках клиентов воспользуйтесь API</h1>
            <p class="text-center font-bold">Необходимо отправить POST запрос с данными на: "{{host}}/api/salary" и
                методом авторизации Bearer Token</p>
            <div @click="getToken" v-if="!token"
                class="bg-systems-800 rounded-md text-white shadow-md px-4 py-2 w-1/3 mx-auto text-center cursor-pointer my-4">
                получить токен
            </div>
            <div v-else class="mx-auto  my-2 w-fit p-4 text-center">
                <div class="bg-white">
                    <h2 class="text-xl py-2"> {{token}}</h2>
                </div>
                <h2 class="font-bold my-2">Пожалуйста сохраните токен, при повторном посещении страницы он не будет
                    показан, и нужно будет создавть новый
                </h2>
            </div>
            <div class="bg-white my-4 p-3 rounded-md">
                <p class="font-bold py-3 text-center">Пример запроса на JavaScript - Fetch</p>
                <pre class=" overflow-auto ">
let myHeaders = new Headers();
myHeaders.append("Content-Type", "application/json");
myHeaders.append("Authorization", "Bearer {ваш токен}");
let raw = JSON.stringify({
  "data": [
    {
      "salary": "сумма (double)",
      "year": "год выплаты (namber)",
      "month": "месц выплаты (namber)",
      "client_name": "имя и фамилия клиента (string)",
      "client_pasport": "номер паспорта клиента (string)",
      "project": "навзвание проекта (string)",
      "hours": "количество часов (double)",
      "rate": "ставка (double)"
    },
   ...
  ]
});

let requestOptions = {
  method: 'POST',
  headers: myHeaders,
  body: raw,
  redirect: 'follow'
};

fetch("{{host}}/api/salary", requestOptions)
  .then(response => response.text())
  .then(result => console.log(result))
  .catch(error => console.log('error', error));
            </pre>
            </div>
        </div>
    </MainLayout>
</template>