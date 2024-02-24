<script setup lang="ts">
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";


const form = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
    phone_number: "",
    birthdate: "",
});

const submit = () => {
    form.post(route("register"), {
        onFinish: () => {
            form.reset("password", "password_confirmation");
        },
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Cadastre-se" />

        <form class="w-full max-w-lg" @submit.prevent="submit">
            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full md:w-1/2 px-3 mb-1 md:mb-0">
                    <InputLabel for="name" value="Nome" />

                    <TextInput
                        id="name"
                        type="name"
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        v-model="form.name"
                        required
                        autocomplete="name"
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
                    />
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>
            </div>

            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full md:w-1/2 px-3 mb- md:mb-0">
                    <InputLabel for="birth_date" value="Data de nascimento" />

                    <TextInput
                        id="birth_date"
                        type="date"
                        v-model="form.birthdate"
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                        max="2022-12-31"
                    />
                    <InputError class="mt-2" :message="form.errors.birthdate" />
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
                    <InputLabel for="password" value="Senha" />

                    <TextInput
                        id="password"
                        type="password"
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        v-model="form.password"
                        required
                        autocomplete="password"
                        placeholder="******************"
                    />
                    <InputError class="mt-2" :message="form.errors.password" />
                </div>
            </div>

            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full px-3">
                    <InputLabel
                        for="password_confirmation"
                        value="Confirme sua senha"
                    />

                    <TextInput
                        id="password_confirmation"
                        type="password"
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        v-model="form.password_confirmation"
                        required
                        autocomplete="new-password"
                    />

                    <InputError
                        class="mt-2"
                        :message="form.errors.password_confirmation"
                    />
                </div>
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link
                    :href="route('login')"
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Já tem conta? Faça login
                </Link>

                <PrimaryButton
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Criar conta
                </PrimaryButton>
            </div>
        </form>

        <!-- <form @submit.prevent="submit">
            <div>
                <InputLabel for="name" value="Nome" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-4">
                <InputLabel for="email" value="E-mail" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Senha" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel for="password_confirmation" value="Confirme sua senha" />

                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link
                    :href="route('login')"
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Já tem conta? Faça login
                </Link>

                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Criar conta
                </PrimaryButton>
            </div>
        </form> -->
    </GuestLayout>
</template>
