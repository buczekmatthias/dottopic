<template>
    <div
        class="bg-container shadow-lg rounded-lg p-3.5 w-full max-w-2xl flex flex-col"
    >
        <div class="flex justify-between mb-2">
            <p class="text-4xl font-bold">Register</p>
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
        <p class="font-light text-slate-300">
            <span>Already a member?</span>
            <Link
                :href="route('security.login')"
                class="text-link font-semibold hover:underline underline-offset-2"
            >
                Sign in
            </Link>
        </p>
        <form
            @submit.prevent="registerForm.post(route('security.register'))"
            class="mt-5 flex flex-col gap-3"
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
                processingText="Joining"
                loaderColors="border-indigo-200 border-t-indigo-400"
                :isProcessing="registerForm.processing"
            >
                Join now
            </Button>
        </form>
    </div>
</template>

<script setup>
import { Link, useForm } from "@inertiajs/vue3";
import route from "@/Composables/Route";

import { Icon } from "@iconify/vue";

import Input from "@/Components/Form/Input.vue";
import Button from "@/Components/Form/Button.vue";

const registerForm = useForm({
    name: "",
    username: "",
    email: "",
    password: "",
});
</script>
