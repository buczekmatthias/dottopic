<template>
    <div class="flex items-center gap-4 relative group">
        <div class="flex gap-2 items-center">
            <p>{{ currentUser ? currentUser.name : "Guest" }}</p>
            <Icon icon="octicon:chevron-down" class="mt-0.5" />
        </div>
        <div
            class="flex-col absolute z-20 right-0 top-full hidden group-hover:flex bg-container border border-solid border-input-default divide-y divide-input-default rounded-md shadow-md"
        >
            <template v-if="currentUser">
                <Link
                    class="link"
                    :href="route('users.show', { user: currentUser.username })"
                >
                    Profile
                </Link>
                <Link class="link" :href="route('security.logout')"
                    >Logout</Link
                >
            </template>
            <template v-else>
                <Link class="link" :href="route('security.register')"
                    >Register</Link
                >
                <Link class="link" :href="route('security.login')">Login</Link>
            </template>
        </div>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import route from "@/Composables/Route";
import currentUser from "@/Composables/User";

import { Icon } from "@iconify/vue";
</script>

<style scoped lang="postcss">
.link {
    @apply p-2.5;
}
.link:hover {
    @apply bg-slate-200/15;
}
</style>
