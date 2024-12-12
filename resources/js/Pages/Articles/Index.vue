<template>
    <div class="content">
        {{ articles.data }}
        <br />
        <br />
        {{ articles.links }}
        <br />
        <br />
        {{ articles.meta }}
    </div>
</template>

<script setup>
defineProps({
    articles: Object,
});
</script>
