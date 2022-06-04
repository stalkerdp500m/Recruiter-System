<template>
    <div class="overflow-x-scroll">
        <table class=" table-auto w-full border-collapse border border-systems-400">
            <tr class="text-left font-bold">
                <th class="pb-4 pt-6 px-6">Рекрутер</th>
                <th class="pb-4 pt-6 px-6">Клиент</th>
                <th class="pb-4 pt-6 px-6">Паспорт</th>
                <th class="pb-4 pt-6 px-6">Проект</th>
                <th class="pb-4 pt-6 px-6">Часы</th>
                <th class="pb-4 pt-6 px-6">Категория</th>
                <th class="pb-4 pt-6 px-6">Статус</th>
                <th class="pb-4 pt-6 px-6">Фактура</th>
                <th class="pb-4 pt-6 px-6">Сумма</th>
            </tr>
            <tr v-for="payment in recruiter.payments" :key="payment.id" class="hover:bg-systems-500/40  ">
                <td class="border-t  ">
                    <div class="items-center px-6 py-4 focus:text-systems-500 overflow-clip w-10  ">
                        {{ recruiter.name }}
                    </div>
                </td>
                <td class="border-t">
                    <div class=" items-center px-6 py-4 focus:text-systems-500 truncate  w-10 hover:w-24">
                        {{ payment?.client?.name }}
                    </div>
                </td>
                <td class="border-t">
                    <div class=" items-center px-6 py-4 focus:text-systems-500 truncate  hover:text-clip">
                        {{ payment?.client?.name }}
                    </div>
                </td>
                <td class="border-t">
                    <div class=" items-center px-6 py-4 focus:text-systems-500 truncate  hover:text-clip">
                        {{ payment?.client?.name }}
                    </div>
                </td>
                <td class="border-t">
                    <div class=" items-center px-6 py-4 focus:text-systems-500 truncate  hover:text-clip">
                        {{ payment?.client?.name }}
                    </div>
                </td>
                <td class="border-t">
                    <div class=" items-center px-6 py-4 focus:text-systems-500 truncate  hover:text-clip">
                        {{ payment?.client?.name }}
                    </div>
                </td>
                <td class="border-t">
                    <div class=" items-center px-6 py-4 focus:text-systems-500 truncate  hover:text-clip">
                        {{ payment?.client?.name }}
                    </div>
                </td>
                <td class="border-t">
                    <div class=" items-center px-6 py-4 focus:text-systems-500 truncate  hover:text-clip">
                        {{ payment?.client?.name }}
                    </div>
                </td>
                <td class="border-t">
                    <div class=" items-center px-6 py-4 focus:text-systems-500 truncate  hover:text-clip">
                        {{ payment?.client?.name }}
                    </div>
                </td>
            </tr>
            <tr v-if="recruiter.payments.length === 0">
                <td class="px-6 py-4 border-t" colspan="4">No contacts found.</td>
            </tr>
        </table>
    </div>

</template>





<template>
    <div class='overflow-x-auto w-full'>
        <table
            class='mx-auto max-w-4xl w-full whitespace-nowrap rounded-lg bg-white divide-y divide-gray-300 overflow-hidden'>
            <thead class="bg-gray-900">
                <tr class="text-white text-left">
                    <th class="font-semibold text-sm uppercase px-6 py-4"> Клиент </th>
                    <th class="font-semibold text-sm uppercase px-6 py-4"> Проект </th>
                    <th class="font-semibold text-sm uppercase px-6 py-4 text-center"> Статус </th>
                    <th class="font-semibold text-sm uppercase px-6 py-4 text-center"> Сумма </th>
                    <th class="font-semibold text-sm uppercase px-6 py-4"> </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <tr v-for="payment in recruiter.payments" :key="payment.id">
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-3">
                            <div>
                                <p> {{payment?.client?.name}}</p>
                                <p class="text-gray-500 text-sm font-semibold tracking-wide"> {{payment?.client?.pasport}}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <p class="">{{payment?.project}}</p>
                        <p class="text-gray-500 text-sm font-semibold tracking-wide">{{payment?.category}} </p>
                    </td>
                    <td class="px-6 py-4 text-center"> <span
                            class="text-white text-sm w-1/3 pb-1 bg-green-600 font-semibold px-2 rounded-full"> {{payment?.status}}
                        </span> </td>
                    <td class="px-6 py-4 text-center"> {{payment?.bonus}} PLN </td>
                    <td class="px-6 py-4 text-center"> <a href="#" class="text-purple-800 hover:underline">Edit</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>