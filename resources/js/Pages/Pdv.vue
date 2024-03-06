<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, useForm} from "@inertiajs/vue3";
import Chart from "./Dashboards/Chart.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import {onMounted, ref} from "vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import Select from "@/Components/Select.vue";
import {LengthAwarePaginator} from "@/types";

interface Props {
    products: LengthAwarePaginator;
    customers: never[]
}

const props = defineProps<Props>()

const products = ref(props.products)
const foundCustomer = ref<boolean>(false)


const form = useForm({
    customer_id: "",
    product_id: "",
});

/*onMounted(() => {
    useForm({}).get(route('customers.list'), {
        onSuccess: (response: any) => {
            console.log(response)
        }
    })
})*/
</script>

<template>
    <Head title="Ponto de Venda"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                PDV (Ponto de Venda)
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        Inicie uma Nova venda
                    </div>
                </div>
            </div>
        </div>
        <div class="">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg d-flex">
                    <div class="w-full md:w-1/2 px-3 mb- md:mb-0 flex flex-wrap">
                        <InputLabel
                            for="product_id"
                            value="Cliente"
                        />

                        <select
                            id="product_id"
                            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            v-model="form.product_id"
                        >
                            <option value="">Selecione o Cliente</option>
                            <option v-for="product of customers" :value="product.id">
                                {{ product.name }}
                            </option>
                        </select>
                        <InputError
                            class="mt-2"
                        />
                    </div>

                    <div class="w-full md:w-1/2 px-3">
                        {{ form.product_id }}
                        <InputLabel for="product_id" value="Produto"/>

                        <select
                            id="product_id"
                            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            v-model="form.product_id"
                        >
                            <option value="">Selecione o Produto ou Serviço</option>
                            <option v-for="product of products" :value="product">
                                {{ product.name }} - {{ product.price_formatted }}
                            </option>
                        </select>
                        <InputError
                            class="mt-2"
                        />
                    </div>
                    <div class="w-full md:w-1/2 px-3">
                        <InputLabel for="product_id" value="Descrição"/>
                    </div>
                </div>
            </div>


        </div>

        <div class="flex flex-wrap -mx-3 mb-6">


        </div>


        <!--        <VCard>
                    <VCardText>
                        <h2>Aqui você terá dashboards incríveis para o controle da sua plataforma</h2>
        &lt;!&ndash;                <Chart title="2023" />&ndash;&gt;
                    </VCardText>
                </VCard>-->
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
