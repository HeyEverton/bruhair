<script lang="ts" setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { VCardText, VDataTableServer } from "vuetify/lib/components/index.mjs";
import GeneralButton from "../../Components/GeneralButton.vue";
import { computed, onMounted } from "vue";
import { LengthAwarePaginator } from "../../types";
import TextInput from "@/Components/TextInput.vue";
import Select from "@/Components/Select.vue";
import { Tooltip, initTE } from "tw-elements";

interface Props {
    users: LengthAwarePaginator;
}

const props = defineProps<Props>();

const headers = [
    {
        title: "Nome",
        key: "name",
        sortable: true,
    },
    {
        title: "E-mail",
        key: "email",
        sortable: true,
    },
    {
        title: "Data de nascimento",
        key: "birth_date_formatted",
        sortable: true,
    },
    {
        title: "Telefone",
        key: "phone_number",
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

const users = computed(() => {
    return props.users.data;
});

onMounted(() => {
    initTE({ Tooltip });
});
</script>
<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Usuários
            </h2>
        </template>

        <VCard>
            <!-- <VCardItem> -->
            <!-- </VCardItem> -->
            <VCardText>
                <VRow>
                    <VCol cols="12" md="3">
                        <Select :items="[{ value: 'teste', name: 'teste' }]" />
                        <!-- <TextInput
                            id="email"
                            class="rounded-md border"
                            required
                        /> -->
                    </VCol>
                </VRow>
                <VDataTableServer
                    :items-length="users.length"
                    density="comfortable"
                    no-data-text="Nenhum usuário foi encontrado"
                    :items="users"
                    :headers="headers"
                    items-per-page-text="Linhas por página"
                    show-current-page
                    :items-per-page-options="itemsPerPageOptions"
                >
                    <template #item.actions="{ item }">
                        <GeneralButton button-text="Excluir" icon="fa-trash" />
                    </template>
                </VDataTableServer>
            </VCardText>
        </VCard>
    </AuthenticatedLayout>
</template>
