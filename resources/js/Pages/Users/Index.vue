<template>
    <div class="content flex flex-col gap-4">
        <div class="flex gap-2">
            <Link :href="route('users.index')">All</Link>
            <Link
                :href="route('users.index', { type: userType })"
                v-for="userType in types"
                :key="userType"
                class="capitalize"
            >
                {{ userType + "s" }}
            </Link>
        </div>
        <div class="" v-for="user in users.data" :key="user.username">
            {{ user }}
            <Link :href="route('users.show', { user: user.username })">
                Profile
            </Link>
        </div>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import route from "@/Composables/Route";

defineProps({
    users: Object,
    types: Array,
});
</script>
