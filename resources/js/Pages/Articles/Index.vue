<template>
    <div class="flex flex-col gap-3">
        <Link
            :href="route('articles.create')"
            class="md:self-start"
            v-if="currentUser && currentUser.isStaff"
        >
            <Button extraClasses="w-full">Create new article</Button>
        </Link>
        <Deferred data="articles">
            <template #fallback>
                <DeferredLoader text="Loading articles" />
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
import route from "@/Composables/Route";
import currentUser from "@/Composables/User";

import Button from "@/Components/Form/Button.vue";
import Article from "@/Components/UI/Article.vue";
import Pagination from "@/Components/Pagination.vue";
import DeferredLoader from "@/Components/DeferredLoader.vue";

defineProps({
    articles: Object,
});
</script>
