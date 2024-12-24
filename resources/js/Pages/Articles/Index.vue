<template>
    <div>
        <Link
            :href="route('articles.create')"
            v-if="currentUser && currentUser.isStaff"
        >
            <Button>Create new article</Button>
        </Link>
        <Deferred data="articles">
            <template #fallback>
                <p>Loading articles..</p>
            </template>

            <div
                v-for="article in articles.data"
                :key="article.slug"
                class="mb-4"
            >
                {{ article }}
                <br />
                <Link :href="route('articles.show', { article: article.slug })">
                    Show article
                </Link>
            </div>
            <br />
            <br />
            {{ articles.links }}
            <br />
            <br />
            {{ articles.meta }}
        </Deferred>
    </div>
</template>

<script setup>
import { Link, Deferred } from "@inertiajs/vue3";
import route from "@/Composables/Route";
import currentUser from "@/Composables/User";

import Button from "@/Components/Form/Button.vue";

defineProps({
    articles: Object,
});
</script>
