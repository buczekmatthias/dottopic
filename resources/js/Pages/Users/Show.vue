<template>
    <div class="flex flex-col gap-4">
        <div class="flex flex-col items-center gap-3">
            <UserImage
                :image="user.image"
                :initials="user.initials"
                size="h-48 w-48"
            />
            <UserRole :role="user.role" />
            <p class="flex flex-col gap-1 items-center">
                <span class="text-2xl">{{ user.name }}</span>
                <span class="text-slate-400 text-sm">
                    @{{ user.username }}
                </span>
            </p>
            <template v-if="currentUser">
                <Link
                    :href="route('users.edit', { user: user.username })"
                    v-if="currentUser.username === user.username"
                >
                    <Button>Edit profile</Button>
                </Link>
            </template>
            <p class="font-light italic" v-if="user.bio">{{ user.bio }}</p>
            <p class="text-sm text-slate-400">Joined {{ user.created_at }}</p>
        </div>
        <div
            class="flex gap-2 border-t border-solid border-t-input-default pt-3 px-1"
        >
            <Link
                :href="
                    route('users.show', {
                        user: user.username,
                        tab: t,
                    })
                "
                class="capitalize border-b-2 border-solid"
                :class="
                    t === tab ? 'border-b-teal-500' : 'border-b-transparent'
                "
                v-for="t in ['articles', 'comments']"
                :key="t"
            >
                {{ t }}
            </Link>
        </div>
        <Deferred data="content">
            <template #fallback>
                <p>Loading {{ tab }}...</p>
            </template>

            <div class="flex flex-col" :class="{ 'gap-4': tab === 'comments' }">
                <template v-if="tab === 'articles'">
                    <Article
                        v-for="article in content.data"
                        :key="article.slug"
                        :article="article"
                    />
                </template>
                <template v-else>
                    <UserComment
                        v-for="comment in content.data"
                        :key="comment.slug"
                        :comment="comment"
                        :username="user.username"
                    />
                </template>
            </div>
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
import UserImage from "@/Components/UI/UserImage.vue";
import UserRole from "@/Components/UI/UserRole.vue";
import UserComment from "@/Components/UI/UserComment.vue";
import Pagination from "@/Components/Pagination.vue";

defineProps({
    user: Object,
    content: Object,
    tab: String,
});
</script>
