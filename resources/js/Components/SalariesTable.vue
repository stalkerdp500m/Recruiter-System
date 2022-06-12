<script setup>

const props = defineProps({
    salaries: Array,
    showRecruiter: Boolean,
    showBonus: Boolean
});

</script>



<template>

    <table class='w-full whitespace-nowrap rounded-lg bg-white  divide-systems-900'>
        <tr v-if="salaries.length === 0">
            <td class="px-6 py-6  font-bold text-lg text-systems-700/70" colspan="4">Wynagrodzenia отсутсвуют
            </td>
        </tr>
        <thead v-else class="bg-systems-900 divide-systems-800 divide-x  border border-systems-900">
            <tr class="text-white text-center">
                <th class="font-semibold text-sm uppercase px-6 py-4 text-left"> Период </th>
                <th class="font-semibold text-sm uppercase px-6 py-4 text-left"> Клиент </th>
                <th class="font-semibold text-sm uppercase px-6 py-4 text-left"> Проект </th>
                <th class="font-semibold text-sm uppercase px-6 py-4 text-center"> Часы </th>
                <!-- <th class="font-semibold text-sm uppercase px-6 py-4"> </th> -->
            </tr>
        </thead>
        <tbody class="divide-systems-800 border border-systems-900 ">
            <tr v-for="salary in props.salaries" :key="salary.id">
                <td class="px-6 py-4">
                    <div class="flex items-center space-x-3">
                        <div>
                            <p> {{ salary?.month }}-{{ salary?.year }}</p>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center space-x-3">
                        <div>
                            <p> {{ salary?.client?.name }}</p>
                            <p class="text-systems-800/70  text-sm font-bold tracking-wide">
                                {{ salary?.client?.pasport }}</p>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <p class="">{{ salary?.project }}</p>
                    <p class="text-gray-500 text-sm font-semibold tracking-wide">
                    </p>
                </td>
                <td class="px-6 py-4 text-center">
                    <span :class="salary?.hours > 80 ? 'bg-systems-600' : 'bg-gray-600'"
                        class="text-white text-sm py-1   font-semibold px-2 rounded-full">
                        {{ salary?.hours }}
                    </span>
                </td>
                <td v-if="props.showBonus" class="px-6 py-4 text-center"> {{ salary?.bonus }} PLN </td>
                <!-- <td class="px-6 py-4 text-center"> <a href="#"
                                    class="text-systems-800 hover:underline">Edit</a>
                            </td> -->
            </tr>

        </tbody>
    </table>

</template>