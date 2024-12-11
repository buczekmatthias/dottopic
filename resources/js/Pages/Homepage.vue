<template>
    <div class="content">
        {{ page.props.routes }}
        <br />
        <br />
        {{ page.props.latest_articles }}
    </div>
</template>

<script setup>
import { usePage } from "@inertiajs/vue3";
const page = usePage();
</script>
