<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { VCardText } from "vuetify/lib/components/index.mjs";
import GeneralButton from "../../Components/GeneralButton.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import { useSweetAlert } from "@/composables/useSweetAlert";
import { Head, useForm } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import { ref } from "vue";

const form = useForm({
    name: "",
    email: "",
    phone_number: "",
    birthdate: "",
});

const { showAlert } = useSweetAlert();
const loadingBtn = ref<boolean>(false)

const create = () => {
    loadingBtn.value = true
    form.post(route("customer.store"), {
        onSuccess: () => {
            loadingBtn.value = false
            form.reset();
            showAlert({
                title: "Sucesso!",
                text: "Cliente Cadastrado com sucesso",
                icon: "success",
            });
        },
        onError: () => {
            loadingBtn.value = false
            showAlert({
                title: "Erro!",
                text: "Algo deu errado",
                icon: "error",
            });

        }
    });
};

const reset = () => {
    form.reset();
};
</script>

<template>

    <Head title="Cadastrar " />

    <AuthenticatedLayout>
        <template #header>
            <div class="justify-between d-flex align-center">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Cadastrar Cliente
                </h2>

                <GeneralButton color="primary" icon="fa-arrow-rotate-left" @click="$inertia.get(route('customers'))" />
            </div>
        </template>

        <VCardText>
            <form @submit.prevent="create">
                <div class="flex flex-wrap mb-6 -mx-3">
                    <div class="w-full px-3 mb-1 md:w-1/2 md:mb-0">
                        <!-- TODO: refactor in employee put the same required thing                         -->
                        <div class="d-flex ">
                            <InputLabel for="name" value="Nome" />
                            <span class="ml-1 text-danger">
                                *
                            </span>
                        </div>

                        <TextInput id="name" type="text"
                            class="block w-full px-4 py-3 mb-3 leading-tight text-gray-700 bg-gray-200 border border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-gray-500"
                            v-model="form.name" required placeholder="Insira o nome do cliente" />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                    <div class="w-full px-3 md:w-1/2">
                        <InputLabel for="email" value="E-mail" />

                        <TextInput id="email" type="email"
                            class="block w-full px-4 py-3 mb-3 leading-tight text-gray-700 bg-gray-200 border border-red-500 rounded appearance-none focus:outline-none focus:bg-white"
                            v-model="form.email" required placeholder="Insira o e-mail do cliente" />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>
                </div>

                <div class="flex flex-wrap mb-6 -mx-3">
                    <div class="w-full px-3 md:w-1/2 mb- md:mb-0">
                        <InputLabel for="birth_date" value="Data de nascimento" />

                        <TextInput id="birth_date" type="date" v-model="form.birthdate"
                            class="block w-full px-4 py-3 mb-3 leading-tight text-gray-700 bg-gray-200 border border-red-500 rounded appearance-none focus:outline-none focus:bg-white"
                            max="2022-12-31" />
                        <InputError class="mt-2" :message="form.errors.birthdate" />
                    </div>

                    <div class="w-full px-3 md:w-1/2">
                        <InputLabel for="phone_number" value="Telefone" />

                        <TextInput id="phone_number" type="text"
                            class="block w-full px-4 py-3 mb-3 leading-tight text-gray-700 bg-gray-200 border border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-gray-500"
                            v-model="form.phone_number" v-mask="'(##) #####-####'" placeholder="(##) #####-####" />
                        <InputError class="mt-2" :message="form.errors.phone_number" />
                    </div>
                </div>
            </form>
        </VCardText>
        <VCardActions>
            <GeneralButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                buttonText="Cadastrar" variant="elevated" icon="fa-paper-plane" color="primary" @click="create"
                :loading="loadingBtn" />

            <GeneralButton class="ms-4" :class="{ 'opacity-25': form.processing }" buttonText="Limpar"
                variant="elevated" icon="fa-ban" color="secondary" @click="reset" />
        </VCardActions>
    </AuthenticatedLayout>
</template>
