<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import { Head } from "@inertiajs/inertia-vue3";
const props = defineProps({
    payments: Object,
});

function paymentsSum (payments) {
    let sum = 0;
    let count = 0;
    payments.forEach(paym => {
        if (paym.bonus > 0) {
            sum += paym.bonus;
            count++
        }
    });
    return `всего ${sum} PLN за ${count} клиентов`;
}
//console.log(props.payments);
</script>

<template>

    <Head title="Dashboard" />

    <MainLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Выплаты
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div v-for="recruiter in props.payments.recruiters" :key="payments.id"
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg my-5">
                    <div @click="recruiter.show = !recruiter.show"
                        class="p-6 mb-5 text-lg font-bold bg-white border-b border-systems-200 overflow-hidden cursor-pointer">
                        <span> {{ recruiter.name }}</span> <span> {{
                                paymentsSum(recruiter.payments)
                        }}
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-2 inline" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg> </span>
                    </div>
                    <div :class="recruiter.show ? 'flex' : 'hidden'" class='overflow-x-auto  transition-all'>
                        <table
                            class='mx-auto max-w-4xl w-full whitespace-nowrap rounded-lg bg-white divide-y divide-systems-300'>
                            <thead class="bg-systems-900">
                                <tr class="text-white text-left">
                                    <th class="font-semibold text-sm uppercase px-6 py-4"> Клиент </th>
                                    <th class="font-semibold text-sm uppercase px-6 py-4"> Проект </th>
                                    <th class="font-semibold text-sm uppercase px-6 py-4 text-center"> Статус </th>
                                    <th class="font-semibold text-sm uppercase px-6 py-4 text-center"> Сумма </th>
                                    <th class="font-semibold text-sm uppercase px-6 py-4"> </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-systems-200">
                                <tr v-for="payment in recruiter.payments" :key="payment.id">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-3">
                                            <div>
                                                <p> {{ payment?.client?.name }}</p>
                                                <p class="text-systems-500 text-sm font-semibold tracking-wide">
                                                    {{ payment?.client?.pasport }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="">{{ payment?.project }}</p>
                                        <p class="text-gray-500 text-sm font-semibold tracking-wide">
                                            <span class="before:content-['💸__']"> {{ payment?.category }} </span>
                                            <span class="before:content-['⏰__'] px-3"> {{ payment?.hours }} </span>
                                        </p>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span :class="payment?.bonus > 0 ? 'bg-green-600' : 'bg-gray-600'"
                                            class="text-white text-sm py-1   font-semibold px-2 rounded-full">
                                            {{ payment?.status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center"> {{ payment?.bonus }} PLN </td>
                                    <td class="px-6 py-4 text-center"> <a href="#"
                                            class="text-systems-800 hover:underline">Edit</a>
                                    </td>
                                </tr>
                                <tr v-if="recruiter.payments.length === 0">
                                    <td class="px-6 py-4 border-t" colspan="4">Нет выплат в этом месяце</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </MainLayout>
</template>