<template>
    <div class="content">
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
import currentUser from "@/Composables/User";

import Comment from "@/Components/Comment.vue";
import CommentForm from "@/Components/CommentForm.vue";
import Reactions from "@/Components/Reactions.vue";

const props = defineProps({
    article: Object,
    availableReactions: Object,
});
</script>
