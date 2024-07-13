<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import { ref, watch } from "vue";
import Select from "@/Components/Select.vue";
import { IUser } from "./types/user-customer-employee";
import { IProduct, IProductItem } from "./types/product";
import GeneralButton from "../Components/GeneralButton.vue";
import { useSweetAlert } from "@/composables/useSweetAlert";
import FontAwesomeIcon from "@/Components/FontAwesomeIcon.vue";

interface Props {
    products: IProduct[];
    customers: IUser[];
    employees: IUser[];
}

const props = defineProps<Props>();

const products = ref<IProduct[]>(props.products);
const employees = ref<IUser[]>(props.employees);
const loadingOrder = ref<boolean>(false);

const paymentTypes = [
    {
        title: "Cartão de Crédito",
        value: 1,
    },
    {
        title: "Cartão de Débito",
        value: 2,
    },
    {
        title: "PIX",
        value: 3,
    },
    {
        title: "Dinheiro",
        value: 4,
    },
];

const form = useForm({
    customer_id: "",
    selected_product: {} as IProduct,
    description: "",
    total: "",
    payment_type: "",
    employee_id: "",
    items: [] as IProductItem[],
});

const { showAlert } = useSweetAlert();

const create = () => {
    // loadingOrder.value = true;
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

const addProduct = () => {
    if (form.selected_product) {
        form.items.push({
            product_id: form.selected_product.id,
            name: form.selected_product.name,
            formatted_price: form.selected_product.price_formatted,
            quantity: 1,
            avg_price: form.selected_product.avg_price,
        });
        form.selected_product = {};
        updateTotal();
    }
};

const removeProduct = (index: number) => {
    form.items.splice(index, 1);
    updateTotal();
};
const updateTotal = () => {
    let total = form.items.reduce((sum, item) => {
        return sum + item.avg_price * item.quantity;
    }, 0);
    form.total = `R$ ${total.toFixed(2)}`;
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
            <div
                class="mx-auto max-w-7xl sm:px-6 lg:px-8 bg-white shadow-sm sm:rounded-lg"
            >
                <!-- Cliente e Funcionário -->
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg d-flex py-3"
                >
                    <div
                        class="flex flex-wrap w-full px-3 md:w-1/2 mb- md:mb-0"
                    >
                        <InputLabel for="customer_id" value="Cliente" />
                        <select
                            id="customer_id"
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
                    <div
                        class="flex flex-wrap w-full px-3 md:w-1/2 mb- md:mb-0"
                    >
                        <InputLabel for="employee_id" value="Funcionário" />
                        <select
                            id="employee_id"
                            class="block w-full px-4 py-3 mb-3 leading-tight text-gray-700 bg-gray-200 border border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-gray-500"
                            v-model="form.employee_id"
                        >
                            <option value="">Selecione o Funcionário</option>
                            <option
                                v-for="employee of employees"
                                :value="employee.id"
                            >
                                {{ employee.name }}
                            </option>
                        </select>
                        <InputError
                            class="mt-2"
                            :message="form.errors.employee_id"
                        />
                    </div>
                </div>

                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg d-flex py-3"
                >
                    <div class="w-full px-3 md:w-5/6">
                        <InputLabel for="selected_product" value="Produto" />
                        <select
                            id="selected_product"
                            class="block w-full px-4 py-3 mb-3 leading-tight text-gray-700 bg-gray-200 border border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-gray-500"
                            v-model="form.selected_product"
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
                        <!-- <InputError
                            class="mt-2"
                            :message="form.errors.product_id"
                        /> -->
                    </div>
                    <div class="w-full px-3 md:w-1/6 align-center mt-6">
                        <GeneralButton
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                            buttonText="Adicionar"
                            variant="elevated"
                            icon="fa-plus"
                            color="primary"
                            @click="addProduct"
                        />
                    </div>
                </div>

                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg d-flex py-3"
                >
                    <div
                        class="w-full px-3"
                        style="max-height: 200px; overflow-y: auto"
                    >
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray- border text-dark">
                                <tr>
                                    <th class="px-4 py-2" for->Produto</th>
                                    <th class="px-4 py-2">Preço</th>
                                    <th class="px-4 py-2">Quantidade</th>
                                    <th class="px-4 py-2">Total</th>
                                    <th class="px-4 py-2">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(product, index) in form.items"
                                    :key="index"
                                >
                                    <td class="border px-4 py-2">
                                        {{ product.name }}
                                    </td>
                                    <td class="border px-4 py-2">
                                        {{ product.formatted_price }}
                                    </td>
                                    <td class="border px-4 py-2">
                                        <VBtn
                                            icon
                                            color="primary"
                                            size="25"
                                            rounded=""
                                            class="mr-2"
                                            :disabled="product.quantity <= 1"
                                            @click="
                                                () => {
                                                    if (product.quantity > 1) {
                                                        product.quantity--;
                                                        updateTotal();
                                                    }
                                                }
                                            "
                                        >
                                            <FontAwesomeIcon icon="fa-minus" />
                                        </VBtn>
                                        {{ product.quantity }}
                                        <VBtn
                                            icon
                                            color="primary"
                                            size="25"
                                            rounded=""
                                            @click="
                                                () => {
                                                    product.quantity++;
                                                    updateTotal();
                                                }
                                            "
                                            class="ml-2"
                                        >
                                            <FontAwesomeIcon icon="fa-plus" />
                                        </VBtn>
                                    </td>
                                    <td class="border px-4 py-2">
                                        {{
                                            product.avg_price * product.quantity
                                        }}
                                    </td>
                                    <td class="border px-4 py-2">
                                        <button
                                            class="text-red-500"
                                            @click="removeProduct(index)"
                                        >
                                            Remover
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg d-flex py-3"
                >
                    <div
                        class="flex flex-wrap w-full px-3 md:w-1/2 mb- md:mb-0"
                    >
                        <InputLabel
                            for="payment_method"
                            value="Forma de Pagamento"
                        />
                        <select
                            id="payment_method"
                            class="block w-full px-4 py-3 mb-3 leading-tight text-gray-700 bg-gray-200 border border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-gray-500"
                            v-model="form.payment_type"
                        >
                            <option value="">
                                Selecione a Forma de Pagamento
                            </option>
                            <option
                                v-for="method in paymentTypes"
                                :value="method.value"
                            >
                                {{ method.title }}
                            </option>
                        </select>
                        <InputError
                            class="mt-2"
                            :message="form.errors.payment_type"
                        />
                    </div>
                    <div
                        class="flex flex-wrap w-full px-3 md:w-1/2 mb- md:mb-0"
                    >
                        <InputLabel for="total" value="Total" />
                        <input
                            type="text"
                            id="total"
                            class="block w-full px-4 py-3 mb-3 leading-tight text-gray-700 bg-gray-200 border border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-gray-500"
                            v-model="form.total"
                            readonly
                        />
                    </div>
                </div>

                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg d-flex py-3"
                >
                    <div class="w-full px-3">
                        <InputLabel for="description" value="Descrição" />
                        <textarea
                            id="description"
                            class="block w-full px-4 py-3 mb-3 leading-tight text-gray-700 bg-gray-200 border border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-gray-500"
                            v-model="form.description"
                        ></textarea>
                        <InputError
                            class="mt-2"
                            :message="form.errors.description"
                        />
                    </div>
                </div>
            </div>
        </form>

        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <GeneralButton
                class="ms-4"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
                buttonText="Finalizar Venda"
                variant="elevated"
                icon="fa-brazilian-real-sign"
                color="primary"
                @click="create"
                :loading="loadingOrder"
            />
        </div>
    </AuthenticatedLayout>
</template>
