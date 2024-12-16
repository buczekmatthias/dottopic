<template>
    <div>
        {{ comment }}
        <template v-if="editComment">
            <form
                @submit.prevent="
                    editCommentForm.patch(
                        route('comments.update', { comment: comment.slug }),
                        {
                            onSuccess: () => {
                                editCommentForm.reset();
                                editComment = false;
                            },
                        }
                    )
                "
            >
                <Textarea
                    v-model="editCommentForm.content"
                    :error="editCommentForm.errors.content"
                />
                <p
                    @click="
                        editComment = false;
                        editCommentForm.reset();
                    "
                >
                    Cancel
                </p>
                <button>Save</button>
            </form>
        </template>
        <p
            @click="editComment = true"
            v-if="
                currentUser &&
                currentUser.username === comment.author.username &&
                !editComment
            "
        >
            Edit comment
        </p>
        <Link
            v-if="
                currentUser &&
                (currentUser.isStaff ||
                    currentUser.username === comment.author.username)
            "
            :href="route('comments.destroy', { comment: comment.slug })"
            method="DELETE"
        >
            Delete comment
        </Link>
        <br />
        <br />
    </div>
</template>

<script setup>
import { ref } from "vue";
import { useForm, Link } from "@inertiajs/vue3";
import currentUser from "@/Composables/User";
import route from "@/Composables/Route";

import Textarea from "@/Components/Form/Textarea.vue";

defineProps({
    comment: Object,
});

const editComment = ref(false);

const editCommentForm = useForm({
    content: "",
});
</script>
