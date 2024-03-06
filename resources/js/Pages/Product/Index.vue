<script lang="ts" setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";
import {VCardText, VDataTableServer} from "vuetify/lib/components/index.mjs";
import GeneralButton from "../../Components/GeneralButton.vue";
import {computed, onMounted, ref, watch} from "vue";
import {LengthAwarePaginator} from "../../types";
import TextInput from "@/Components/TextInput.vue";
import Select from "@/Components/Select.vue";
import {Tooltip, initTE} from "tw-elements";
import InputLabel from "@/Components/InputLabel.vue";
import {useSweetAlert} from "@/composables/useSweetAlert";
import {useForm} from "@inertiajs/vue3";

const {showAlert} = useSweetAlert();

interface Props {
    products: LengthAwarePaginator;
}

const props = defineProps<Props>();

const headers = [
    {
        title: "Nome",
        key: "name",
        sortable: true,
    },
    {
        title: "Preço Médio",
        key: "price_formatted",
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

const products = ref(props.products.data);


const searchField = ref("");
const loadingId = ref("");

const deleteEmployee = (emplyoeeId: string, index: number) => {
    const options = {
        title: "Você tem certeza?",
        text: "Você não conseguirá recuperar este Produto",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Sim, excluir",
        cancelButtonText: "Não, cancelar",
        preConfirm: () => confirmDelete(emplyoeeId, index),
    };

    showAlert(options);
};

const confirmDelete = (id: string, index: number) => {
    loadingId.value = id;
    products.value.splice(index, 1);
    useForm({}).delete(route("products.destroy", {id: id}), {
        onSuccess: () => {
            showAlert({
                title: "Sucesso!",
                text: "Produto excluído com sucesso",
                icon: "success",
            });
            loadingId.value = "";
        },
        onError: (error) => {
            showAlert({
                title: "Sucesso!",
                text: "Produto excluído com sucesso",
                icon: "success",
            });
        },
    });
};

const search = (value: string) => {
    if (value === "") {
        products.value = props.products.data;
    } else {
        products.value = props.products.data.filter((product) => {
            return product.name.toLowerCase().includes(value.toLowerCase())
        });
    }
};

watch(searchField, (newValue) => {
    search(newValue);
});
</script>
<template>
    <Head title="Produtos"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Produtos
            </h2>
        </template>

        <VCard>
            <VCardText>
                <VRow class="align-center">
                    <VCol cols="12" md="3">
                        <InputLabel
                            for="field"
                            value="Insira o valor para pesquisar"
                        />

                        <TextInput
                            id="field"
                            type="text"
                            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                            v-model="searchField"
                            placeholder="Pesquise por nome"
                            @input="search"
                        />
                    </VCol>

                    <VCol offset-md="6">
                        <GeneralButton
                            color="primary"
                            icon="fa-plus"
                            button-text="Novo Produto"
                            @click="$inertia.get(route('products.create'))"
                        />
                    </VCol>
                </VRow>
                <VDataTableServer
                    :items-length="products.length"
                    density="comfortable"
                    no-data-text="Nenhum produto foi encontrado"
                    :items="products"
                    :headers="headers"
                    items-per-page-text="Linhas por página"
                    show-current-page
                    :items-per-page-options="itemsPerPageOptions"
                >
                    <template #item.actions="{ item, index }">
                        <div class="d-flex gap-2">
                            <GeneralButton
                                color="primary"
                                icon="fa-pencil"
                                size="35"
                                @click="$inertia.get(route('products.edit', item.id))"
                            />
                            <GeneralButton
                                color="red"
                                icon="fa-trash"
                                size="35"
                                @click="deleteEmployee(item.id, index)"
                                :loading="loadingId === item.id"
                            />
                        </div>
                    </template>

                    <template #bottom></template>
                </VDataTableServer>
            </VCardText>
        </VCard>
    </AuthenticatedLayout>
</template>
