<template>
    <div
        class="bg-container shadow-lg rounded-lg p-3.5 w-full max-w-2xl flex flex-col"
    >
        <div class="flex justify-between mb-2">
            <p class="text-4xl font-bold">Login</p>
            <Link
                :href="route('homepage')"
                class="flex items-center gap-1.5 duration-150 border border-solid border-slate-200 rounded-full px-3 text-sm"
            >
                <p>Back to app</p>
                <Icon
                    icon="octicon:arrow-right-16"
                    height="16"
                    width="16"
                    class="mt-1"
                />
            </Link>
        </div>
        <p class="font-light">
            <span class="text-slate-300">New here?</span>
            <Link
                :href="route('security.register')"
                class="text-link font-semibold hover:underline underline-offset-2"
            >
                Join now
            </Link>
        </p>
        <form
            @submit.prevent="loginForm.post(route('security.login'))"
            class="mt-5 flex flex-col gap-3"
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
    </div>
</template>

<script setup>
import { Link, useForm } from "@inertiajs/vue3";
import route from "@/Composables/Route";

import Input from "@/Components/Form/Input.vue";
import Button from "@/Components/Form/Button.vue";
import Checkbox from "@/Components/Form/Checkbox.vue";
import { Icon } from "@iconify/vue";

const loginForm = useForm({
    email: "",
    password: "",
    remember_me: false,
});
</script>
