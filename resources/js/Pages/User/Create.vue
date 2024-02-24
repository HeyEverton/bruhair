<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { VCardText } from "vuetify/lib/components/index.mjs";
import GeneralButton from "../../Components/GeneralButton.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import { useSweetAlert } from "@/composables/useSweetAlert";
import { Head, useForm } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";

const form = useForm({
    name: "",
    email: "",
    phone_number: "",
    birthdate: "",
    employee_code: "",
});

const { showAlert } = useSweetAlert();

const create = () => {
    console.log("creating..");
    form.post(route("employee.store"), {
        onSuccess: () => {
            form.reset();
            showAlert({
                title: "Sucesso!",
                text: "Funcionário Cadastrado com sucesso",
                icon: "success",
            });
        },
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
            <div class="d-flex justify-between align-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Cadastrar Funcionário
                </h2>

                <GeneralButton
                    color="primary"
                    icon="fa-arrow-rotate-left"
                    @click="$inertia.get(route('users'))"
                />
            </div>
        </template>

        <VCardText>
            <form @submit.prevent="create">
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
                buttonText="Cadastrar"
                variant="elevated"
                icon="fa-paper-plane"
                color="primary"
                @click="create"
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
