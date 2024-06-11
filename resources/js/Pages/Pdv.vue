<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import { ref } from "vue";
import Select from "@/Components/Select.vue";
import { IUser } from "./types/user-customer-employee";
import { IProduct } from "./types/product";
import GeneralButton from "../Components/GeneralButton.vue";
import { useSweetAlert } from "@/composables/useSweetAlert";

interface Props {
    products: IProduct[];
    customers: IUser[];
    employees: IUser[];
}

const props = defineProps<Props>();

const products = ref<IProduct[]>(props.products);
const employees = ref<IUser[]>(props.employees);
const loadingOrder = ref<boolean>(false);

const form = useForm({
    customer_id: "",
    product_id: "",
    description: "",
    total: "",
    payment_type: "",
    employee_id: "",
});

const { showAlert } = useSweetAlert();
const changeTotal = (event: any) => {
    form.total = event.price_formatted;
};

const create = () => {
    // loadingOrder.value = true;
    // @ts-expect-error ...
    form.product_id = form.product_id?.id;
    form.post(route("pdv.store"), {
        onSuccess: () => {
            loadingOrder.value = false;
            showAlert({
                title: "Sucesso!",
                text: "Venda realizada com sucesso",
                icon: "success",
            });
            form.reset();
        },
        onError: (error) => {
            const messages = Object.values(error);
            messages.forEach((message) => {
                showAlert({
                    title: "Ops! Algumas falhas em validações foram encontradas",
                    text: message,
                    icon: "error",
                });
            });
            loadingOrder.value = false;
        },
    });
};
</script>

<template>
    <Head title="Ponto de Venda" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                PDV (Ponto de Venda)
            </h2>
        </template>

        <form @submit.prevent="create" class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg d-flex"
                >
                    <div
                        class="flex flex-wrap w-full px-3 md:w-1/2 mb- md:mb-0"
                    >
                        <InputLabel for="product_id" value="Cliente" />

                        <select
                            id="product_id"
                            class="block w-full px-4 py-3 mb-3 leading-tight text-gray-700 bg-gray-200 border border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-gray-500"
                            v-model="form.customer_id"
                        >
                            <option value="">Selecione o Cliente</option>
                            <option
                                v-for="customer of customers"
                                :value="customer.id"
                            >
                                {{ customer.name }}
                            </option>
                        </select>
                        <InputError
                            class="mt-2"
                            :message="form.errors.customer_id"
                        />
                    </div>

                    <div class="w-full px-3 md:w-1/2">
                        <InputLabel for="employee_id" value="Funcionário" />

                        <select
                            v-model="form.employee_id"
                            id="employee_id"
                            class="block w-full px-4 py-3 mb-3 leading-tight text-gray-700 bg-gray-200 border border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-gray-500"
                        >
                            <option value="">Selecione o Funcionário</option>
                            <option
                                v-for="employee of employees"
                                :value="employee.id"
                            >
                                {{ employee?.name }}
                            </option>
                        </select>
                        <InputError
                            class="mt-2"
                            :message="form.errors.employee_id"
                        />
                    </div>

                    <div class="w-full px-3 md:w-1/2">
                        <InputLabel for="product_id" value="Produto" />

                        <select
                            id="product_id"
                            class="block w-full px-4 py-3 mb-3 leading-tight text-gray-700 bg-gray-200 border border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-gray-500"
                            v-model="form.product_id"
                            @update:model-value="changeTotal"
                        >
                            <option value="">
                                Selecione o Produto ou Serviço
                            </option>
                            <option
                                v-for="product of products"
                                :value="product"
                            >
                                {{ product?.name }} -
                                {{ product?.price_formatted }}
                            </option>
                        </select>
                        <InputError
                            class="mt-2"
                            :message="form.errors.product_id"
                        />
                    </div>
                </div>

                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg d-flex"
                >
                    <div class="w-full px-3 md:w-1/2">
                        <InputLabel
                            for="payment_type"
                            value="Forma de Pagamento"
                        />
                        <select
                            id="payment_type"
                            class="block w-full px-4 py-3 mb-3 leading-tight text-gray-700 bg-gray-200 border border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-gray-500"
                            v-model="form.payment_type"
                        >
                            <option value="">
                                Selecione a Forma de Pagamento
                            </option>
                            <option value="1">Cartão de Crédito</option>
                            <option value="2">Cartão de Débito</option>
                            <option value="3">PIX</option>
                            <option value="4">Dinheiro</option>
                        </select>
                        <InputError
                            class="mt-2"
                            :message="form.errors.payment_type"
                        />
                    </div>

                    <div class="w-full px-3 md:w-1/2">
                        <InputLabel for="total" value="Total" />
                        <TextInput
                            id="total"
                            type="text"
                            class="block w-full px-4 py-3 mb-3 leading-tight text-gray-700 bg-gray-200 border border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-gray-500"
                            v-model="form.total"
                            required
                        />
                        <InputError class="mt-2" :message="form.errors.total" />
                    </div>
                </div>

                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg d-flex"
                >
                    <div class="w-full px-3 md:w-full">
                        <InputLabel for="description" value="Descrição" />
                        <textarea
                            v-model="form.description"
                            id="description"
                            rows="4"
                            class="block w-full px-4 py-3 mb-3 leading-tight text-gray-700 bg-gray-200 border border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-gray-500"
                        />
                        <InputError
                            class="mt-2"
                            :message="form.errors.description"
                        />
                    </div>
                </div>
            </div>
        </form>

        <div class="ml-15">
            <GeneralButton
                class="ms-4"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
                buttonText="Nova Venda"
                variant="elevated"
                icon="fa-brazilian-real-sign"
                color="primary"
                @click="create"
                :loading="loadingOrder"
            />
        </div>
    </AuthenticatedLayout>
</template>
