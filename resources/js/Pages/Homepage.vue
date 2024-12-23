<template>
    <div class="content">
        {{ usePage().props.routes }}
        <Deferred data="latest_articles">
            <template #fallback>
                <p>Loading latest articles...</p>
            </template>

            <div v-for="article in latest_articles">{{ article }}</div>
        </Deferred>
    </div>
</template>

<script setup>
import { Deferred, usePage } from "@inertiajs/vue3";

defineProps({
    latest_articles: Object,
});
</script>
