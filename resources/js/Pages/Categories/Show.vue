<template>
    <div class="flex flex-col gap-4">
        <Deferred data="category">
            <Link
                :href="
                    route('admin.categories.edit', { category: category.slug })
                "
                v-if="currentUser && currentUser.isStaff"
                class="self-start"
            >
                <Button>Update category</Button>
            </Link>
            <template #fallback>
                <DeferredLoader text="Loading category" />
            </template>

            <p class="text-3xl font-semibold">{{ category.name }}</p>
        </Deferred>
        <Deferred data="articles">
            <template #fallback>
                <DeferredLoader text="Loading articles" />
            </template>

            <div class="flex flex-col">
                <Article
                    v-for="article in articles.data"
                    :key="article.slug"
                    :article="article"
                />
            </div>
            <Pagination :links="articles.links" :pagination="articles.meta" />
        </Deferred>
    </div>
</template>

<script setup>
import { Link, Deferred } from "@inertiajs/vue3";
import currentUser from "@/Composables/User";
import route from "@/Composables/Route";

import Button from "@/Components/Form/Button.vue";
import Article from "@/Components/UI/Article.vue";
import Pagination from "@/Components/Pagination.vue";
import DeferredLoader from "@/Components/DeferredLoader.vue";

defineProps({
    category: Object,
    articles: Object,
});
</script>
