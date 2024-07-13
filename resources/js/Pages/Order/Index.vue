<script lang="ts" setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { VCardText, VDataTableServer } from "vuetify/lib/components/index.mjs";
import GeneralButton from "../../Components/GeneralButton.vue";
import { computed, onMounted, ref, watch } from "vue";
import { LengthAwarePaginator } from "../../types";
import TextInput from "@/Components/TextInput.vue";
import Select from "@/Components/Select.vue";
import { Tooltip, initTE } from "tw-elements";
import InputLabel from "@/Components/InputLabel.vue";
import { useSweetAlert } from "@/composables/useSweetAlert";
import { useForm } from "@inertiajs/vue3";
import { IProduct, IProductItem } from "../types/product";

const { showAlert } = useSweetAlert();

interface Props {
    orders: LengthAwarePaginator;
}

const props = defineProps<Props>();
const date = ref("");

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

const itemsPerPageOptions = [
    {
        title: "10",
        value: 10,
    },
    {
        title: "15",
        value: 15,
    },
    {
        title: "20",
        value: 20,
    },
    {
        title: "30",
        value: 30,
    },
    {
        title: "Todos",
        value: -1,
    },
];

const users = ref(props.orders.data);

onMounted(() => {
    initTE({ Tooltip });
});

const searchField = ref("");
const loadingId = ref("");


const search = (value: string) => {
    if (value === "") {
        users.value = props.users.data;
    } else {
        users.value = props.users.data.filter((user) => {
            return (
                user.name.toLowerCase().includes(value.toLowerCase()) ||
                user.email.toLowerCase().includes(value.toLowerCase())
            );
        });
    }
};

watch(searchField, (newValue) => {
    search(newValue);
});

const searchOrders = () => {
    useForm({}).get(route("search.orders", { date: date.value }));
};

const modal = ref(false);
const orderItems = ref<IProductItem[]>([]);
const modalOrderItems = (order: any) => {
    console.log(order);
    modal.value = true;
    orderItems.value = order.items;
};
</script>
<template>
    <Head title="Vendas" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Vendas
            </h2>
        </template>

        <VCard>
            <VCardText>
                <VRow class="align-center">
                    <VCol cols="12" md="3">
                        <InputLabel
                            for="field"
                            value="Selecione a data das vendas"
                        />

                        <select
                            id="date"
                            @change="searchOrders"
                            v-model="date"
                            class="block w-full px-4 py-3 mb-3 leading-tight text-gray-700 bg-gray-200 border border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-gray-500"
                        >
                            <option value="">Selecione a Data</option>
                            <option value="day">Do Dia</option>
                            <option value="week">Da Semana</option>
                            <option value="month">Do mês</option>
                            <option value="all">Todas as Vendas</option>
                        </select>
                    </VCol>

                    <VCol offset-md="6">
                        <GeneralButton
                            color="primary"
                            icon="fa-plus"
                            button-text="Nova Venda"
                            @click="$inertia.get(route('pdv'))"
                        />
                    </VCol>
                </VRow>
                <VDataTableServer
                    :items-length="users.length"
                    density="comfortable"
                    no-data-text="Nenhuma  venda foi encontrada"
                    :items="users"
                    :headers="headers"
                    items-per-page-text="Linhas por página"
                    show-current-page
                    :items-per-page-options="itemsPerPageOptions"
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
        <VDialog v-model="modal" max-width="800px">
            <VCard>
                <VCardText>
                    <VDataTableServer
                        :items-length="users.length"
                        density="comfortable"
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
                        :items-per-page-options="itemsPerPageOptions"
                    />
                </VCardText>
            </VCard>
        </VDialog>
    </AuthenticatedLayout>
</template>
