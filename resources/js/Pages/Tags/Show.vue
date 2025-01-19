<template>
    <div class="flex flex-col gap-4">
        <Deferred data="tag">
            <template #fallback>
                <DeferredLoader text="Loading tag" />
            </template>

            <Link
                :href="route('admin.tags.edit', { tag: tag.slug })"
                v-if="currentUser && currentUser.isStaff"
                class="self-start"
            >
                <Button>Update tag</Button>
            </Link>

            <p class="text-3xl font-semibold">{{ tag.name }}</p>
        </Deferred>
        <Deferred data="articles">
            <template #fallback>
                <DeferredLoader text="Loading articles" />
            </template>

            <div class="flex flex-col">
                <p class="text-2xl font-semibold my-3">Articles</p>
                <Article
                    v-for="article in articles.data"
                    :key="article.slug"
                    :article="article"
                />
            </div>
            <Pagination :links="articles.links" :pagination="articles.meta" />
        </Deferred>
        <Deferred data="categories">
            <template #fallback>
                <DeferredLoader text="Loading categories" />
            </template>

            <div class="flex flex-col">
                <p class="text-2xl font-semibold my-3">Categories</p>
                <div
                    class="flex flex-col gap-3 items-start odd:border-y border-solid border-y-input-default py-4"
                    v-for="category in categories.data"
                    :key="category.name"
                >
                    <Category :category="category" />
                </div>
            </div>
            <Pagination
                :links="categories.links"
                :pagination="categories.meta"
            />
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
import Category from "@/Components/UI/Category.vue";
import DeferredLoader from "@/Components/DeferredLoader.vue";

defineProps({
    tag: Object,
    articles: Object,
    categories: Object,
});
</script>
