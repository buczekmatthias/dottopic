<template #default="{ breadCrumbs }">
    <div class="content">
        {{ latest_articles }}
    </div>
</template>

<script setup>
defineProps({
    latest_articles: Object,
});

const breadCrumbs = ["homepage"];
</script>
