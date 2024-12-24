<template>
    <div>
        <Deferred data="tag">
            <template #fallback>
                <p>Loading tag...</p>
            </template>

            <Link
                :href="route('admin.tags.edit', { tag: tag.slug })"
                v-if="currentUser && currentUser.isStaff"
            >
                <Button>Update tag</Button>
            </Link>
            {{ tag.articles }}
            <br />
            <br />
            {{ tag.categories }}
        </Deferred>
    </div>
</template>

<script setup>
import { Link, Deferred } from "@inertiajs/vue3";
import currentUser from "@/Composables/User";
import route from "@/Composables/Route";

import Button from "@/Components/Form/Button.vue";

defineProps({
    tag: Object,
});
</script>
