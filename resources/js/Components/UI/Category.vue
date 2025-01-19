<template>
    <p class="text-2xl mr-auto">{{ category.name }}</p>
    <div
        class="flex gap-1 items-center text-sm text-slate-400"
        v-if="category.articles_count"
    >
        <Icon icon="octicon:file" height="16" width="16" />
        <p>{{ category.articles_count }} article(s)</p>
    </div>
    <Link
        :href="
            route('categories.show', {
                category: category.slug,
            })
        "
        class="flex items-center gap-1.5 text-link hover:gap-2.5 duration-150"
    >
        Show category
        <Icon
            icon="octicon:arrow-right-16"
            height="16"
            width="16"
            class="mt-1"
        />
    </Link>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import route from "@/Composables/Route";

import { Icon } from "@iconify/vue";

defineProps({
    category: Object,
});
</script>
