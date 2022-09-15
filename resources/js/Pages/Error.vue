<script setup>
import Guest from "@/Layouts/Guest.vue";
import { Head } from "@inertiajs/inertia-vue3";
import { Link, usePage } from "@inertiajs/inertia-vue3";

const props = defineProps({
    status: Number,
});

function title () {
    return {
        503: '503: Сервис не доступен',
        500: '500: Ошибка на сервере',
        404: '404: Страница не найдена',
        403: '403: Доступ запрещен',
    }[props.status]
}

function description () {
    return {
        503: 'Извините, мы проводим техническое обслуживание. Пожалуйста, зайдите в ближайшее время.',
        500: 'Ой, что-то пошло не так, скоро все исправим.',
        404: 'К сожалению, страница, которую вы ищете, не найдена.',
        403: 'Извините, вам запрещен доступ к этой странице.',
    }[props.status]
}

</script>

<template>

    <Head title="Выплаты" />

    <Guest>


        <!-- Фильтры -->
        <div class="  text-black text-center my-10">
            <h1 class="text-2xl">{{title()}}</h1>
            <h3 class="text-xl my-2">{{description ()}}</h3>
            <Link :href="route('dashboard')">
            <div
                class="bg-systems-800 rounded-md text-white shadow-md px-4 py-2  text-center cursor-pointer mx-auto mt-8 w-fit">
                <p class=""> Вернутся на главную</p>
            </div>
            </Link>
        </div>
    </Guest>
</template>