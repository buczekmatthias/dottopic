<template>
    <div class="flex items-center gap-4">
        <template v-if="currentUser">
            <Link
                :href="route('users.show', { user: currentUser.username })"
                class="flex gap-1 text-link"
            >
                <span>{{ currentUser.name }}</span>
                <span class="font-light text-slate-300">
                    (@{{ currentUser.username }})
                </span>
            </Link>
            <Link :href="route('security.logout')">Logout</Link>
        </template>
        <template v-else>
            <Link :href="route('security.register')">Register</Link>
            <Link :href="route('security.login')">Login</Link>
        </template>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import route from "@/Composables/Route";
import currentUser from "@/Composables/User";
</script>
