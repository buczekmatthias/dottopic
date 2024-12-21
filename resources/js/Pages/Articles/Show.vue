<template>
    <div class="content">
        <Link
            :href="route('articles.edit', { article: article.slug })"
            v-if="currentUser && currentUser.isStaff"
        >
            <Button>Edit article</Button>
        </Link>
        {{ article }}
        <br />
        <br />
        <br />
        <img :src="article.content[2].content" alt="" />
        <br />
        <Reactions
            type="article"
            :identifier="article.slug"
            :reactions="article.reactions"
            :userReaction="article.userReaction"
            :availableReactions="availableReactions"
        />
        <br />
        <CommentForm
            :article="article.slug"
            :author="currentUser.username"
            v-if="currentUser"
        />
        <Comment
            v-for="(comment, i) in article.comments.data"
            :key="i"
            :comment="comment"
        />
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import route from "@/Composables/Route";
import currentUser from "@/Composables/User";

import Button from "@/Components/Form/Button.vue";
import Comment from "@/Components/Comment.vue";
import CommentForm from "@/Components/CommentForm.vue";
import Reactions from "@/Components/Reactions.vue";

const props = defineProps({
    article: Object,
    availableReactions: Object,
});
</script>
