<template>
    <form
        @submit.prevent="
            newCommentForm.post(route('comments.store'), {
                onSuccess: () => newCommentForm.reset(),
            })
        "
    >
        <Textarea
            :error="newCommentForm.errors.content"
            v-model="newCommentForm.content"
        />
        <Button
            :isProcessing="newCommentForm.processing"
            processingText="Posting"
        >
            Post comment
        </Button>
    </form>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
import route from "@/Composables/Route";

import Textarea from "@/Components/Form/Textarea.vue";
import Button from "@/Components/Form/Button.vue";

const props = defineProps({
    article: String,
    author: String,
});

const newCommentForm = useForm({
    content: "",
    author: props.author,
    article: props.article,
});
</script>
