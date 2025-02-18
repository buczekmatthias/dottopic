<template>
    <div class="flex flex-col gap-2">
        <Deferred data="article">
            <template #fallback>
                <DeferredLoader text="Loading article" />
            </template>

            <div
                class="flex gap-2"
                v-if="
                    currentUser &&
                    (currentUser.isStaff ||
                        currentUser.username === article.author.username)
                "
            >
                <Link :href="route('articles.edit', { article: article.slug })">
                    <Button>Edit article</Button>
                </Link>
                <Link
                    method="DELETE"
                    :href="route('articles.destroy', { article: article.slug })"
                >
                    <Button extraClasses="!bg-rose-600">Delete article</Button>
                </Link>
            </div>
            <div class="flex flex-col gap-3 mb-3">
                <div class="flex flex-col gap-3">
                    <h1 class="font-bold text-3xl">{{ article.title }}</h1>
                    <div
                        class="flex max-md:flex-col max-md:gap-1.5 md:divide-x divide-input-default md:[&>*]:px-3"
                    >
                        <div class="flex items-center gap-2 !pl-0">
                            <Icon class="mt-1" icon="octicon:calendar-24" />
                            <p class="text-sm text-slate-300">
                                {{ article.created_at }}
                            </p>
                        </div>
                        <div class="flex items-center gap-2">
                            <Icon class="mt-1" icon="octicon:person-24" />
                            <Link
                                :href="
                                    route('users.show', {
                                        user: article.author.username,
                                    })
                                "
                                class="text-link"
                            >
                                {{ article.author.name }} (@{{
                                    article.author.username
                                }})
                            </Link>
                        </div>
                        <div class="flex items-center gap-2">
                            <Icon
                                class="mt-1"
                                icon="octicon:file-directory-24"
                            />
                            <Link
                                :href="
                                    route('categories.show', {
                                        category: article.category.slug,
                                    })
                                "
                                class="text-link"
                            >
                                {{ article.category.name }}
                            </Link>
                        </div>
                    </div>
                    <div class="flex flex-wrap items-center gap-2">
                        <Icon class="mt-1" icon="octicon:tag-24" />
                        <Link
                            :href="route('tags.show', { tag: tag.slug })"
                            v-for="tag in article.tags"
                            :key="tag.slug"
                            class="text-link"
                        >
                            #{{ tag.name }}
                        </Link>
                    </div>
                    <p v-html="article.description"></p>
                </div>
                <div
                    class="flex flex-col gap-3 border-y border-solid border-y-input-default py-3"
                >
                    <p class="text-2xl">Table of content</p>
                    <ul
                        class="list-disc list-inside flex flex-col items-start gap-2"
                    >
                        <li
                            v-for="item in listOfContent"
                            :key="item.id"
                            @click.prevent="scrollIntoView(item.id)"
                            class="cursor-pointer"
                        >
                            {{ item.header }}
                        </li>
                    </ul>
                </div>
                <div class="flex flex-col gap-4">
                    <template
                        v-for="content in article.content"
                        :key="content.id"
                    >
                        <template v-if="content.type === 'header'">
                            <h1
                                class="font-bold text-3xl mt-4 mb-2 scroll-mt-20"
                                :id="generateIdOfHeader(content.content)"
                            >
                                {{ content.content }}
                            </h1>
                        </template>
                        <template v-else-if="content.type === 'text'">
                            <p v-html="content.content"></p>
                        </template>
                        <template v-else>
                            <img
                                :src="content.content"
                                alt=""
                                v-if="content.fileMime.includes('image')"
                            />
                            <video :src="content.content" v-else></video>
                        </template>
                    </template>
                </div>
            </div>
            <Reactions
                type="article"
                :identifier="article.slug"
                :reactions="article.reactions_count"
                :userReaction="article.userReaction"
                :availableReactions="availableReactions"
            />
            <div class="flex flex-col gap-3 mt-3">
                <p class="text-2xl font-semibold">Comments</p>
                <Deferred data="comments">
                    <template #fallback>
                        <DeferredLoader text="Loading comments" />
                    </template>

                    <CommentForm
                        :article="article.slug"
                        :author="currentUser?.username"
                    />
                    <Pagination
                        :links="comments.links"
                        :pagination="comments.meta"
                    />
                    <Comment
                        v-for="(comment, i) in comments.data"
                        :key="i"
                        :comment="comment"
                    />
                </Deferred>
            </div>
        </Deferred>
    </div>
</template>

<script setup>
import { computed } from "vue";
import { Link, Deferred } from "@inertiajs/vue3";
import route from "@/Composables/Route";
import currentUser from "@/Composables/User";

import { Icon } from "@iconify/vue";

import Button from "@/Components/Form/Button.vue";
import Comment from "@/Components/UI/Comment.vue";
import CommentForm from "@/Components/UI/CommentForm.vue";
import Reactions from "@/Components/UI/Reactions.vue";
import Pagination from "@/Components/Pagination.vue";
import DeferredLoader from "@/Components/DeferredLoader.vue";

const props = defineProps({
    article: Object,
    comments: Object,
    availableReactions: Object,
});

const listOfContent = computed(() => {
    let loc = [];

    const headers = props.article.content.filter((c) => c.type === "header");

    headers.forEach((header) => {
        loc.push({
            header: header.content,
            id: generateIdOfHeader(header.content),
        });
    });

    return loc;
});

const generateIdOfHeader = (header) =>
    header
        .toLowerCase()
        .replace(/[^a-z0-9 ]/g, "")
        .replace(/\s+/g, "-");

const scrollIntoView = (id) => document.getElementById(id).scrollIntoView();
</script>
