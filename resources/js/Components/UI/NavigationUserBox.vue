<template>
    <div class="flex items-center gap-1">
        <template v-if="currentUser">
            <Link :href="route('security.logout')">logout</Link>
        </template>
        <template v-else>
            <Link :href="route('security.login')">login</Link>
        </template>
        <div class="hidden">Menu</div>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import route from "@/Composables/Route";
import currentUser from "@/Composables/User";
</script>
