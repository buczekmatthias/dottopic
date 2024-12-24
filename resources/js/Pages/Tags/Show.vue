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

            {{ tag }}
        </Deferred>
        <Deferred data="articles">
            <template #fallback>
                <p>Loading articles...</p>
            </template>

            <Article
                v-for="article in articles.data"
                :key="article.slug"
                :article="article"
            />
            <Pagination :links="articles.links" :pagination="articles.meta" />
        </Deferred>
        <Deferred data="categories">
            <template #fallback>
                <p>Loading categories...</p>
            </template>

            {{ categories }}
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

defineProps({
    tag: Object,
    articles: Object,
    categories: Object,
});
</script>
