<template>
    <div class="bg-white rounded-lg p-3 w-full max-w-2xl">
        <p class="text-4xl font-bold">Login</p>
        <p class="font-light text-slate-500 mt-1">
            To enjoy all basic features
        </p>
        <!-- TODO: Remove in ready app -->
        <Link
            :href="route('security.login')"
            method="POST"
            :data="{ email: 'hazy@test.com', password: 'test' }"
            >Login as dev</Link
        >
        <form
            @submit.prevent="loginForm.post(route('security.login'))"
            class="my-5 flex flex-col gap-3"
        >
            <Input
                label="E-mail"
                type="email"
                :error="loginForm.errors.email"
                v-model="loginForm.email"
            />
            <Input
                label="Password"
                type="password"
                :error="loginForm.errors.password"
                v-model="loginForm.password"
            />
            <Checkbox label="Stay logged in" v-model="loginForm.remember_me" />
            <Button
                processingText="Signing in"
                loaderColors="border-indigo-200 border-t-indigo-400"
                :isProcessing="loginForm.processing"
            >
                Sign in
            </Button>
        </form>
        <p>
            <span>New here?</span>
            <Link
                :href="route('security.register')"
                class="text-indigo-700 font-semibold hover:underline underline-offset-2"
            >
                Join now
            </Link>
        </p>
    </div>
</template>

<script setup>
import { Link, useForm } from "@inertiajs/vue3";
import route from "@/Composables/Route";

import Input from "@/Components/Form/Input.vue";
import Button from "@/Components/Form/Button.vue";
import Checkbox from "@/Components/Form/Checkbox.vue";

const loginForm = useForm({
    email: "",
    password: "",
    remember_me: false,
});
</script>
