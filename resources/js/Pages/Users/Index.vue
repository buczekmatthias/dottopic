<template>
    <div class="flex flex-col gap-4">
        <div class="flex gap-2">
            <Link :href="route('users.index')">All</Link>
            <Link
                :href="route('users.index', { type: userType })"
                :only="['users']"
                v-for="userType in types"
                :key="userType"
                class="capitalize"
            >
                {{ userType + "s" }}
            </Link>
        </div>
        <Deferred data="users">
            <template #fallback>
                <p>Loading users...</p>
            </template>
            <Link v-for="(url, key) in users.links" :href="url">
                {{ key }}
            </Link>
            <div class="" v-for="user in users.data" :key="user.username">
                {{ user }}
                <Link :href="route('users.show', { user: user.username })">
                    Profile
                </Link>
            </div>
        </Deferred>
    </div>
</template>

<script setup>
import { Link, Deferred } from "@inertiajs/vue3";
import route from "@/Composables/Route";

defineProps({
    users: Object,
    types: Array,
});
</script>
