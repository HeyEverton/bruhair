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
}

const props = defineProps<Props>();

const products = ref<IProduct[]>(props.products);
const loadingOrder = ref<boolean>(false);

const form = useForm({
    customer_id: "",
    product_id: "",
    description: "",
    total: "",
    payment_type: "",
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
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                PDV (Ponto de Venda)
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">Inicie uma Nova venda</div>
                </div>
            </div>
        </div>
        <form @submit.prevent="create">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg d-flex"
                >
                    <div
                        class="w-full md:w-1/2 px-3 mb- md:mb-0 flex flex-wrap"
                    >
                        <InputLabel for="product_id" value="Cliente" />

                        <select
                            id="product_id"
                            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            v-model="form.customer_id"
                        >
                            <option value="">Selecione o Cliente</option>
                            <option
                                v-for="product of customers"
                                :value="product.id"
                            >
                                {{ product.name }}
                            </option>
                        </select>
                        <InputError
                            class="mt-2"
                            :message="form.errors.customer_id"
                        />
                    </div>

                    <div class="w-full md:w-1/2 px-3">
                        <InputLabel for="product_id" value="Produto" />

                        <select
                            id="product_id"
                            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
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
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg d-flex"
                >
                    <div class="w-full md:w-1/2 px-3">
                        <InputLabel
                            for="payment_type"
                            value="Forma de Pagamento"
                        />
                        <select
                            id="payment_type"
                            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
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

                    <div class="w-full md:w-1/2 px-3">
                        <InputLabel for="total" value="Total" />
                        <TextInput
                            id="total"
                            type="text"
                            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            v-model="form.total"
                            required
                        />
                        <InputError class="mt-2" :message="form.errors.total" />
                    </div>
                </div>

                <div
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg d-flex"
                >
                    <div class="w-full md:w-full px-3">
                        <InputLabel for="description" value="Descrição" />
                        <textarea
                            v-model="form.description"
                            id="description"
                            rows="4"
                            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        />
                        <InputError
                            class="mt-2"
                            :message="form.errors.description"
                        />
                    </div>
                </div>
            </div>
        </form>

        <div
            class="bg-white overflow-hidden shadow-sm sm:rounded-lg d-flex mt-5 w-full"
        >
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
