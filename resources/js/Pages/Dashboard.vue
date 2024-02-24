<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import Chart from "./Dashboards/Chart.vue";
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        Aqui você poderá ver o levantamento dos seus dados!
                    </div>
                </div>
            </div>
        </div>

        <VCard>
            <VCardText>
                <h2>Aqui você terá dashboards incríveis para o controle da sua plataforma</h2>
<!--                <Chart title="2023" />-->
            </VCardText>
        </VCard>
        <!--
            <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                </div>
            </div>
        </div>
        -->
    </AuthenticatedLayout>
</template>
