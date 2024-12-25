<template>
    <div class="flex flex-col gap-2">
        <Deferred data="article">
            <template #fallback>
                <p>Loading article...</p>
            </template>

            <Link
                :href="route('articles.edit', { article: article.slug })"
                v-if="currentUser && currentUser.isStaff"
            >
                <Button>Edit article</Button>
            </Link>
            <div class="flex flex-col gap-3">
                <div class="flex flex-col gap-4">
                    <h1 class="font-bold text-2xl">{{ article.title }}</h1>
                    <p class="text-sm">{{ article.created_at }}</p>
                    <p>
                        Posted by
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
                        in
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
                    </p>
                    <div class="flex flex-wrap gap-2">
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
                <ul
                    class="list-disc list-inside flex flex-col items-start gap-2 border-y border-solid border-y-input-default py-3"
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
            <Deferred data="comments">
                <template #fallback>
                    <p>Loading comments...</p>
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
        </Deferred>
    </div>
</template>

<script setup>
import { computed } from "vue";
import { Link, Deferred } from "@inertiajs/vue3";
import route from "@/Composables/Route";
import currentUser from "@/Composables/User";

import Button from "@/Components/Form/Button.vue";
import Comment from "@/Components/UI/Comment.vue";
import CommentForm from "@/Components/UI/CommentForm.vue";
import Reactions from "@/Components/UI/Reactions.vue";
import Pagination from "@/Components/Pagination.vue";

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
