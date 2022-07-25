<script setup>

import { ref, reactive } from "vue";
import PaymentsTable from "@/Components/PaymentsTable.vue";
import SalariesTable from "@/Components/SalariesTable.vue";

const props = defineProps({
    pasport: String
});

const emit = defineEmits(['reciveClientData']);

const showDetails = ref(false);




const haveResults = ref(false);
const name = ref("");
const payments = ref([]);
const salaries = ref([]);
const countPayments = ref(0);
const maxPaymentDate = ref(0);
const maxWorkDate = ref(0);
const countWorks = ref(0);
const sumHours = ref(0);
const sequencePeriods = ref({});

getClientData();

function getClientData () {
    axios
        .get("/clients", { params: { pasport: props.pasport } })
        .then((response) => {
            if (response.status == "200") {
                if (response.data.searchResults) {
                    haveResults.value = true;
                    emit('reciveClientData', {
                        'name': response.data.searchResults.name,
                        'client_id': response.data.searchResults.id,
                        'pasport': response.data.searchResults.pasport
                    });
                    name.value = response.data.searchResults.name;
                    agregate(response.data.searchResults);
                }
            }
        });
}


function agregate (clientData) {
    if (clientData?.payments) {
        payments.value = clientData.payments;
        clientData.payments.map((paym) => {
            let datePayment = new Date(paym.year, paym.month - 1);
            if (paym.bonus > 0) {
                countPayments.value++;
                if (datePayment > maxPaymentDate.value) {
                    maxPaymentDate.value = datePayment;
                }
            }
        });
    }
    let lastPeriod = { year: 0, month: 0 };
    let countSequence = 1;
    if (clientData?.salaries) {
        salaries.value = clientData.salaries;
        clientData.salaries.map((salary) => {
            let dateSalary = new Date(salary.year, salary.month - 1);
            countWorks.value++;
            sumHours.value += salary.hours;
            if (dateSalary > maxWorkDate.value) {
                maxWorkDate.value = dateSalary;
            }
            if (
                lastPeriod.month +
                12 * lastPeriod.year -
                (salary.month + 12 * salary.year) ==
                countSequence
            ) {
                countSequence++;
                sequencePeriods.value[
                    `${lastPeriod.month}-${lastPeriod.year}`
                ] = {
                    count: countSequence,
                    started: `${salary.month}-${salary.year}`,
                };
            } else {
                countSequence = 1;
                lastPeriod.year = salary.year;
                lastPeriod.month = salary.month;
            }
        });
    }
}

function toLocaleDate (date) {
    if (date instanceof Date) {
        return date.toLocaleDateString("ru-RU", {
            year: "numeric",
            month: "numeric",
        });
    }
    return false;
}

</script>

<template>
    <div class=" bg-systems-300 mt-0 rounded-md">
        <div v-if="!haveResults" class=" text-center p-4 ">
            Данные по этому паспорту отсутсвуют в системе</div>
        <div v-else>
            <div v-if="countPayments || countWorks" class=" text-center p-4 font-semibold uppercase">Данные по <b>{{
                    name
            }}</b>
            </div>
            <div v-else class=" text-center p-4 font-semibold uppercase">часы и выплаты по клиенту не найдены</div>
            <div v-if="countPayments" class=" text-center px-4 font-bold ">
                💸 Выплат {{ countPayments }},
                последняя {{ toLocaleDate(maxPaymentDate) }},
            </div>
            <div v-if="countWorks" class=" text-center px-4 font-bold">
                Работал(а) {{ countWorks }} месяца,
                последний {{ toLocaleDate(maxWorkDate) }}, ⏰ часов всего {{
                        sumHours
                }}</div>
            <div v-if="countWorks" class=" text-center px-4 ">
                <div v-for="(period, kay) in sequencePeriods">
                    Работал(а) {{ period.count }} месяца подряд с {{ period.started }} по {{ kay }}
                </div>
            </div>
        </div>


        <!-- Результаты -->
        <div v-if="payments.length > 0 || salaries.length > 0"
            class="px-4 py-2 m-5 text-center text-lg bg-white  cursor-pointer rounded-md"
            @click="showDetails = !showDetails">
            Подробно <svg v-if="!showDetails" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-2 inline" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
            </svg>
            <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-2 inline" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
            </svg>

        </div>
        <div class="pb-16 md:mx-5 " v-if="showDetails">
            <div class="mx-auto p-2 bg-white  shadow-sm rounded-md my-4">
                <div v-if="payments.length > 0" class=" transition-all h-fit px-2 md:px-10 overflow-y-clip">
                    <div class="text-left  font-bold py-1 cursor-pointer " @click="showPayments = !showPayments">
                        Выплаты </div>
                    <div class=" overflow-x-auto overflow-y-clip py-4">
                        <PaymentsTable hideClientName showRecruiter :payments="payments">
                        </PaymentsTable>
                    </div>
                </div>
                <div v-else class="font-bold text-2xl text-center ">Выплаты отсутсвуют</div>
            </div>
            <div class="mx-auto p-2 bg-white   shadow-sm rounded-md ">
                <div v-if="salaries.length > 0" class=' transition-all h-fit px-2 md:px-10 cursor-pointer'>
                    <div class="text-left  font-bold py-2 " @click="showSalaries = !showSalaries">
                        Wynagrodzenia</div>
                    <div class=" overflow-x-auto overflow-y-clip py-4 ">
                        <SalariesTable hideClientName showRecruiter :salaries="salaries">
                        </SalariesTable>
                    </div>
                </div>
                <div v-else class="font-bold text-2xl text-center ">Wynagrodzenia отсутсвуют</div>
            </div>
        </div>
        <!-- Результаты -->



    </div>
</template>