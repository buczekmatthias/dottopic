<template>
    <div>
        <template v-if="currentUser">
            <Link
                :href="route('users.edit', { user: user.username })"
                v-if="currentUser.username === user.username"
            >
                <Button> Edit profile </Button>
            </Link>
        </template>
        <div class="">
            <Link
                :href="
                    route('users.show', {
                        user: user.username,
                        tab: tab.toLowerCase(),
                    })
                "
                v-for="tab in ['Articles', 'Comments']"
                :key="tab"
            >
                {{ tab }}
            </Link>
        </div>
        {{ user }}
        <Deferred data="content">
            <template #fallback>
                <p>Loading {{ tab }}...</p>
            </template>

            <template v-if="tab === 'articles'">
                <Article
                    v-for="article in content.data"
                    :key="article.slug"
                    :article="article"
                />
            </template>
            <template v-else>
                <div>
                    {{ content }}
                </div>
            </template>
            <Pagination :links="content.links" :pagination="content.meta" />
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

defineProps({
    user: Object,
    content: Object,
    tab: String,
});
</script>
