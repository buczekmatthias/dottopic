<template>
    <div class="content flex flex-col gap-4">
        <Link
            :href="route('admin.tags.create')"
            v-if="currentUser && currentUser.isStaff"
        >
            <Button>Create new tag</Button>
        </Link>
        <div
            class="flex flex-col gap-1"
            v-for="tag in tags.data"
            :key="tag.name"
        >
            {{ tag }}
            <Link :href="route('tags.show', { tag: tag.slug })">Show tag</Link>
        </div>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import route from "@/Composables/Route";
import currentUser from "@/Composables/User";

import Button from "@/Components/Form/Button.vue";

defineProps({
    tags: Object,
});
</script>
