<template>
    <div>
        <Deferred data="category">
            <Link
                :href="
                    route('admin.categories.edit', { category: category.slug })
                "
                v-if="currentUser && currentUser.isStaff"
            >
                <Button>Update category</Button>
            </Link>
            <template #fallback>
                <p>Loading category...</p>
            </template>

            {{ category.articles }}
        </Deferred>
    </div>
</template>

<script setup>
import { Link, Deferred } from "@inertiajs/vue3";
import currentUser from "@/Composables/User";
import route from "@/Composables/Route";

import Button from "@/Components/Form/Button.vue";

defineProps({
    category: Object,
});
</script>
