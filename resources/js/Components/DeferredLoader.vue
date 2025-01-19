<template>
    <div class="flex gap-2 items-center">
        <Loader />
        <p>{{ text }}</p>
    </div>
</template>

<script setup>
import Loader from "@/Components/Loader.vue";

defineProps({
    text: String,
});
</script>
