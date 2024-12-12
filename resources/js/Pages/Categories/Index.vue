<template>
    <div class="content">
        {{ categories.data }}
        <br />
        <br />
        {{ categories.links }}
        <br />
        <br />
        {{ categories.meta }}
    </div>
</template>

<script setup>
defineProps({
    categories: Object,
});
</script>
