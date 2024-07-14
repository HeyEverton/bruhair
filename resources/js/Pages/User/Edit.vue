<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { VCardText } from "vuetify/lib/components/index.mjs";
import GeneralButton from "../../Components/GeneralButton.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import { useSweetAlert } from "@/composables/useSweetAlert";
import { Head, useForm } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import { IUser } from "../types/user-customer-employee";
import { ref } from "vue";
import { IProductItem } from "../types/product";
interface Props {
    user: IUser;
}

const props = defineProps<Props>();
const employeeSalesModal = ref<boolean>(false);

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    phone_number: props.user.phone_number,
    birthdate: props.user.birthdate,
    employee_code: props.user.employee_code,
});

const { showAlert } = useSweetAlert();

const headers = [
    {
        title: "Cliente",
        key: "customer.name",
        sortable: true,
    },
    {
        title: "Profissional",
        key: "employee.name",
        sortable: true,
    },
    {
        title: "Total",
        key: "formatted_total",
        sortable: true,
    },
    {
        title: "Data",
        key: "formatted_date",
        sortable: true,
    },
    {
        title: "Ações",
        key: "actions",
        sortable: false,
    },
];

const edit = () => {
    form.put(route("employee.edit", { id: props.user.id }), {
        onSuccess: () => {
            showAlert({
                title: "Sucesso!",
                text: "Funcionário Editado com sucesso",
                icon: "success",
            });
        },
    });
};

const modal = ref(false);
const orderItems = ref<IProductItem[]>([]);
const modalOrderItems = (order: any) => {
    modal.value = true;
    orderItems.value = order.items;
};
</script>

<template>
    <Head title="Editar Funcionário " />

    <AuthenticatedLayout>
        <template #header>
            <div class="d-flex justify-between align-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Editar Funcionário
                </h2>

                <GeneralButton
                    color="primary"
                    icon="fa-arrow-rotate-left"
                    @click="$inertia.get(route('users'))"
                />
            </div>
        </template>
        <div class="w-full md:w-1/2 px-3 mb-1 md:mb-0 mt-4">
            <GeneralButton
                color="primary"
                icon="fa-brazilian-real-sign"
                button-text="Ver Vendas do Funcionário"
                class="mt-2 mr-2"
                @click="employeeSalesModal = true"
            />
        </div>

        <VDialog v-model="employeeSalesModal">
            <VCard>
                <VCardTitle>
                    Vendas do funcionário:
                    <strong>{{ props.user.name }}</strong>
                </VCardTitle>
                <VCardText>
                    <VDataTableServer
                        :items-length="props.user.orders.length"
                        density="comfortable"
                        no-data-text="Nenhuma  venda foi encontrada"
                        :items="props.user.orders"
                        :headers="headers"
                        items-per-page-text="Linhas por página"
                        show-current-page
                    >
                        <template #item.actions="{ item, index }">
                            <div class="gap-2 d-flex">
                                <GeneralButton
                                    color="primary"
                                    icon="fa-eye"
                                    size="35"
                                    @click="modalOrderItems(item)"
                                />
                            </div>
                        </template>

                        <template #bottom> </template>
                    </VDataTableServer>
                </VCardText>
            </VCard>

            <VDialog v-model="modal" max-width="600">
                <VCard>
                    <VCardTitle>
                        Itens da Venda
                    </VCardTitle>
                    <VCardText>
                        <VDataTableServer
                            :items-length="orderItems"
                            density="compact"
                            no-data-text="Nenhum item foi encontrado"
                            :items="orderItems"
                            :headers="[
                                {
                                    title: 'Produto',
                                    key: 'product.name',
                                    sortable: false,
                                },
                                {
                                    title: 'Quantidade',
                                    key: 'quantity',
                                    sortable: false,
                                },
                                {
                                    title: 'Preço Unitário',
                                    key: 'unit_price',
                                    sortable: false,
                                },
                            ]"
                            items-per-page-text="Linhas por página"
                            show-current-page
                        >
                        <template #bottom> </template>
                    </VDataTableServer>
                    </VCardText>
                </VCard>
            </VDialog>
        </VDialog>
        <VCardText>
            <form @submit.prevent="edit">
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full md:w-1/2 px-3 mb-1 md:mb-0">
                        <InputLabel for="name" value="Nome" />

                        <TextInput
                            id="name"
                            type="text"
                            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            v-model="form.name"
                            required
                            placeholder="Insira o nome do funcionário"
                        />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                    <div class="w-full md:w-1/2 px-3">
                        <InputLabel for="email" value="E-mail" />

                        <TextInput
                            id="email"
                            type="email"
                            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                            v-model="form.email"
                            required
                            placeholder="Insira o e-mail do funcionário"
                        />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>
                </div>

                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full md:w-1/2 px-3 mb- md:mb-0">
                        <InputLabel
                            for="birth_date"
                            value="Data de nascimento"
                        />

                        <TextInput
                            id="birth_date"
                            type="date"
                            v-model="form.birthdate"
                            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                            max="2022-12-31"
                        />
                        <InputError
                            class="mt-2"
                            :message="form.errors.birthdate"
                        />
                    </div>

                    <div class="w-full md:w-1/2 px-3">
                        <InputLabel for="phone_number" value="Telefone" />

                        <TextInput
                            id="phone_number"
                            type="text"
                            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            v-model="form.phone_number"
                            v-mask="'(##) #####-####'"
                            placeholder="(##) #####-####"
                        />
                        <InputError
                            class="mt-2"
                            :message="form.errors.phone_number"
                        />
                    </div>
                </div>

                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                        <InputLabel
                            for="employee_code"
                            value="Código do Funcionário"
                        />

                        <TextInput
                            id="employee_code"
                            type="text"
                            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            v-model="form.employee_code"
                            required
                            placeholder="Insira o código do funcionário"
                        />
                        <InputError
                            class="mt-2"
                            :message="form.errors.employee_code"
                        />
                    </div>
                </div>
            </form>
        </VCardText>
        <VCardActions>
            <GeneralButton
                class="ms-4"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
                buttonText="Editar"
                variant="elevated"
                icon="fa-pencil"
                color="primary"
                @click="edit"
            />

            <GeneralButton
                class="ms-4"
                :class="{ 'opacity-25': form.processing }"
                buttonText="Voltar"
                variant="elevated"
                icon="fa-arrow-rotate-left"
                color="secondary"
                @click="$inertia.get(route('users'))"
            />
        </VCardActions>
    </AuthenticatedLayout>
</template>
