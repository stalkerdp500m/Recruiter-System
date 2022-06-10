<script setup>

const props = defineProps({
    payments: Array,
    showRecruiter: Boolean,
    showBonus: Boolean
});

</script>



<template>

    <table class='w-full whitespace-nowrap rounded-lg bg-white divide-y divide-systems-300'>
        <tr v-if="payments.length === 0">
            <td class="px-6 py-6  font-bold text-lg text-systems-700/70" colspan="4">Выплаты отсутсвуют
            </td>
        </tr>
        <thead v-else class="bg-systems-900">
            <tr class="text-white text-center">
                <th class="font-semibold text-sm uppercase px-6 py-4 text-left"> Фактура </th>
                <th v-if="props.showRecruiter" class="font-semibold text-sm uppercase px-6 py-4 text-left"> Рерутер
                </th>
                <th class="font-semibold text-sm uppercase px-6 py-4 text-left"> Клиент </th>
                <th class="font-semibold text-sm uppercase px-6 py-4 text-left"> Проект </th>
                <th class="font-semibold text-sm uppercase px-6 py-4 text-center"> Статус </th>
                <th v-if="props.showBonus" class="font-semibold text-sm uppercase px-6 py-4 text-center"> Сумма </th>
                <!-- <th class="font-semibold text-sm uppercase px-6 py-4"> </th> -->
            </tr>
        </thead>
        <tbody class="divide-y divide-systems-200">
            <tr v-for="payment in props.payments" :key="payment.id">
                <td class="px-6 py-4">
                    <div class="flex items-center space-x-3">
                        <div>
                            <p> {{ payment?.month }}-{{ payment?.year }}</p>
                        </div>
                    </div>
                </td>
                <td v-if="props.showRecruiter" class="py-4 break-words">
                    <div class="flex items-center space-x-3">
                        <div>
                            <p> {{ payment?.recruiter.name }}</p>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center space-x-3">
                        <div>
                            <p> {{ payment?.client?.name }}</p>
                            <p class="text-systems-800/70  text-sm font-bold tracking-wide">
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
                <td v-if="props.showBonus" class=" py-4 text-center"> {{ payment?.bonus }} PLN </td>
                <!-- <td class="px-6 py-4 text-center"> <a href="#"
                                    class="text-systems-800 hover:underline">Edit</a>
                            </td> -->
            </tr>

        </tbody>
    </table>

</template>