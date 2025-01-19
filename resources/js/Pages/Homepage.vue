<template>
    <div class="grid grid-cols-1 xl:grid-cols-[1fr_auto] gap-3 xl:gap-6">
        <Deferred data="latest_articles">
            <template #fallback>
                <DeferredLoader text="Loading latest articles" />
            </template>

            <div class="flex flex-col">
                <p class="font-semibold w-full text-2xl lg:text-3xl">
                    Latest articles
                </p>
                <Article
                    v-for="article in latest_articles"
                    :article="article"
                    :key="article.slug"
                />
            </div>
        </Deferred>
        <Deferred data="popular_categories">
            <template #fallback>
                <DeferredLoader text="Loading latest categories" />
            </template>

            <div class="flex flex-wrap xl:flex-col gap-3">
                <p class="font-semibold w-full text-2xl lg:text-3xl mb-4">
                    Popular categories
                </p>
                <Link
                    v-for="category in popular_categories"
                    :key="category.slug"
                    :href="
                        route('categories.show', { category: category.slug })
                    "
                    class="flex gap-1.5 xl:justify-between border border-solid border-slate-300 rounded-md px-2 py-1 duration-150 hover:bg-slate-300/15"
                >
                    <span class="capitalize">{{ category.name }}</span>
                    <span class="text-sm text-slate-400">
                        {{ category.articles_count }} article(s)
                    </span>
                </Link>
            </div>
        </Deferred>
    </div>
</template>

<script setup>
import { Deferred, Link } from "@inertiajs/vue3";
import route from "@/Composables/Route";

import Article from "@/Components/UI/Article.vue";
import DeferredLoader from "@/Components/DeferredLoader.vue";

defineProps({
    latest_articles: Object,
    popular_categories: Object,
});
</script>
