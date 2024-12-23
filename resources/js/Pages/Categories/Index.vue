<template>
    <div class="content flex flex-col gap-4">
        <Link
            :href="route('admin.categories.create')"
            v-if="currentUser && currentUser.isStaff"
        >
            <Button>Create new category</Button>
        </Link>
        <Deferred data="categories">
            <template #fallback>
                <p>Loading categories..</p>
            </template>

            <div
                class="flex flex-col gap-1"
                v-for="category in categories.data"
                :key="category.name"
            >
                {{ category }}
                <Link
                    :href="
                        route('categories.show', { category: category.slug })
                    "
                >
                    Show category
                </Link>
            </div>
        </Deferred>
    </div>
</template>

<script setup>
import { Link, Deferred } from "@inertiajs/vue3";
import route from "@/Composables/Route";
import currentUser from "@/Composables/User";

import Button from "@/Components/Form/Button.vue";

defineProps({
    categories: Object,
});
</script>
