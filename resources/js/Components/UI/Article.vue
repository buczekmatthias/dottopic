<template>
    <div
        class="grid grid-cols-1 lg:grid-cols-[1fr_4fr] gap-2 odd:border-y border-solid border-y-input-default py-6"
    >
        <div class="flex flex-col items-start">
            <Link
                :href="
                    route('categories.show', {
                        category: article.category.slug,
                    })
                "
                class="text-link capitalize"
            >
                {{ article.category.name }}
            </Link>
            <p>{{ article.created_at }}</p>
            <template v-if="article.author">
                <p class="mt-auto">
                    By
                    <Link
                        :href="
                            route('users.show', {
                                user: article.author.username,
                            })
                        "
                        class="text-link capitalize"
                    >
                        {{ article.author.name }}
                    </Link>
                </p>
            </template>
        </div>
        <div class="flex flex-col items-start gap-2">
            <h1 class="text-2xl font-bold">{{ article.title }}</h1>
            <p class="font-light text-sm" v-html="article.description"></p>
            <Link
                :href="route('articles.show', { article: article.slug })"
                class="flex items-center gap-1.5 text-link hover:gap-2.5 duration-150"
            >
                <p>Read more</p>
                <Icon
                    icon="octicon:arrow-right-16"
                    height="16"
                    width="16"
                    class="mt-1"
                />
            </Link>
        </div>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import route from "@/Composables/Route";

import { Icon } from "@iconify/vue";

defineProps({
    article: Object,
});
</script>
