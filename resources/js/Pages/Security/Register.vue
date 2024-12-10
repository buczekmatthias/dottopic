<template>
    <div class="bg-white rounded-lg p-3 w-full max-w-2xl">
        <p class="text-4xl font-bold">Create account</p>
        <p class="font-light text-slate-500 mt-1">
            And become part of the community
        </p>
        <form
            @submit.prevent="registerForm.post(route('security.register'))"
            class="my-5 flex flex-col gap-3"
        >
            <Input
                label="Name"
                type="name"
                :error="registerForm.errors.name"
                v-model="registerForm.name"
            />
            <Input
                label="Username"
                type="username"
                :error="registerForm.errors.username"
                v-model="registerForm.username"
            />
            <Input
                label="E-mail"
                type="email"
                :error="registerForm.errors.email"
                v-model="registerForm.email"
            />
            <Input
                label="Password"
                type="password"
                :error="registerForm.errors.password"
                v-model="registerForm.password"
            />
            <Button
                progressingText="Joining"
                loaderColors="border-indigo-200 border-t-indigo-400"
                :isProcessing="registerForm.processing"
            >
                Join now
            </Button>
        </form>
        <p>
            <span>Already a member?</span>
            <Link
                :href="route('security.login')"
                class="text-indigo-700 font-semibold hover:underline underline-offset-2"
            >
                Sign in
            </Link>
        </p>
    </div>
</template>

<script setup>
import { Link, useForm } from "@inertiajs/vue3";
import route from "@/Composables/Route";

import Input from "@/Components/Form/Input.vue";
import Button from "@/Components/Form/Button.vue";

const registerForm = useForm({
    name: "",
    username: "",
    email: "",
    password: "",
});
</script>
