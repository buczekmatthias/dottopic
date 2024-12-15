<template>
    <div class="content">
        {{ article }}
        <br />
        <br />
        <CommentForm
            :article="article.slug"
            :author="currentUser.username"
            v-if="currentUser"
        />
        <Comment
            v-for="(comment, i) in article.comments"
            :key="i"
            :comment="comment"
        />
    </div>
</template>

<script setup>
import currentUser from "@/Composables/User";

import Comment from "@/Components/Comment.vue";
import CommentForm from "@/Components/CommentForm.vue";

defineProps({
    article: Object,
});
</script>
