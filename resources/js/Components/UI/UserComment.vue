<template>
    <div
        class="flex flex-col items-start gap-4 border border-solid border-input-default rounded-md p-2"
    >
        <p>{{ comment.content }}</p>
        <Link
            :href="
                route('articles.show', {
                    article: comment.article,
                })
            "
            class="flex items-center gap-1.5 text-link hover:gap-2.5 duration-150"
        >
            Show article
            <Icon
                icon="octicon:arrow-right-16"
                height="16"
                width="16"
                class="mt-1"
            />
        </Link>
        <div class="flex gap-2 items-center justify-between w-full">
            <p class="text-sm text-slate-400">{{ comment.created_at }}</p>
            <template v-if="currentUser">
                <Link
                    :href="route('comments.destroy', { comment: comment.slug })"
                    v-if="
                        currentUser.isStaff || currentUser.username === username
                    "
                    class="text-rose-500"
                    method="DELETE"
                >
                    Delete comment
                </Link>
            </template>
        </div>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import route from "@/Composables/Route";
import currentUser from "@/Composables/User";

import { Icon } from "@iconify/vue";

defineProps({
    comment: Object,
    username: String,
});
</script>
