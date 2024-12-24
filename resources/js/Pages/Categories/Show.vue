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

            {{ category }}
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
    category: Object,
    articles: Object,
});
</script>
