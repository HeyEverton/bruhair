<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {VCardText} from "vuetify/lib/components/index.mjs";
import GeneralButton from "../../Components/GeneralButton.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import {useSweetAlert} from "@/composables/useSweetAlert";
import {Head, useForm} from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import {ref, watch} from "vue";
import MoneyInput from "@/Components/MoneyInput.vue";
import {configInputMoney} from "@/configs/moneyConfig";

const form = useForm({
    name: "",
    avg_price: "",
});

const {showAlert} = useSweetAlert();
const loadingBtn = ref<boolean>(false)

const create = () => {
    loadingBtn.value = true
    form.post(route("products.store"), {
        onSuccess: () => {
            loadingBtn.value = false
            form.reset();
            showAlert({
                title: "Sucesso!",
                text: "Produto Cadastrado com sucesso",
                icon: "success",
            });
        },
    });
};

const reset = () => {
    form.reset();
};

watch(form, newValue => {
    const regex = /[a-zA-Z]/
    if (regex.test(newValue.avg_price)) {
        form.avg_price = ''

        showAlert({
            title: "Ops! Inválido!",
            text: "Apenas números são permitidos.",
            icon: "warning",
        });
    }
})
</script>

<template>
    <Head title="Cadastrar "/>

    <AuthenticatedLayout>
        <template #header>
            <div class="d-flex justify-between align-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Cadastrar Produto ou Serviço
                </h2>

                <GeneralButton
                    color="primary"
                    icon="fa-arrow-rotate-left"
                    @click="$inertia.get(route('products'))"
                />
            </div>
        </template>

        <VCardText>
            <form @submit.prevent="create">
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full md:w-1/2 px-3 mb-1 md:mb-0">
                        <!-- TODO: refactor in employee put the same required thing                         -->
                        <div class="d-flex ">
                            <InputLabel for="name" value="Nome"/>
                            <span class="text-danger ml-1">
                                *
                            </span>
                        </div>

                        <TextInput
                            id="name"
                            type="text"
                            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            v-model="form.name"
                            required
                            placeholder="Insira o nome do produto ou do serviço"
                        />
                        <InputError class="mt-2" :message="form.errors.name"/>
                    </div>

                    <div class="w-full md:w-1/2 px-3">
                        <div class="d-flex ">
                            <InputLabel for="avg_price" value="Preço Médio"/>
                            <span class="text-danger ml-1">
                                *
                            </span>
                        </div>
                        <TextInput
                            id="avg_price"
                            type="text"
                            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            v-model="form.avg_price"
                            required
                            placeholder="Insira o preço do produto"
                            maxlength="6"
                        />
                        <InputError class="mt-2" :message="form.errors.avg_price"/>
                    </div>
                </div>

            </form>
        </VCardText>
        <VCardActions>
            <GeneralButton
                class="ms-4"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
                buttonText="Cadastrar"
                variant="elevated"
                icon="fa-paper-plane"
                color="primary"
                @click="create"
                :loading="loadingBtn"
            />

            <GeneralButton
                class="ms-4"
                :class="{ 'opacity-25': form.processing }"
                buttonText="Limpar"
                variant="elevated"
                icon="fa-ban"
                color="secondary"
                @click="reset"
            />
        </VCardActions>
    </AuthenticatedLayout>
</template>
