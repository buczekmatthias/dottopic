<template>
    <div class="content">{{ page.props.routes }}</div>
</template>

<script setup>
import { usePage } from "@inertiajs/vue3";
const page = usePage();
</script>
