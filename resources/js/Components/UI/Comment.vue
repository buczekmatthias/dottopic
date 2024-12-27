<template>
    <div
        class="flex flex-col gap-2 border border-solid border-input-default rounded-md p-2"
    >
        <div class="flex items-center justify-between">
            <p>
                <Link
                    :href="
                        route('users.show', { user: comment.author.username })
                    "
                    class="text-link font-semibold"
                >
                    {{ comment.author.name }}
                </Link>
                wrote:
            </p>
            <p class="font-light text-slate-300 text-sm">
                {{ comment.created_at }}
            </p>
        </div>
        <p>{{ comment.content }}</p>
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
                class="flex flex-wrap gap-3"
            >
                <Textarea
                    v-model="editCommentForm.content"
                    :error="editCommentForm.errors.content"
                    class="w-full"
                    helpText="Provide new content of comment or cancel to discard"
                />
                <button
                    type="button"
                    @click="
                        editComment = false;
                        editCommentForm.reset();
                    "
                >
                    Cancel
                </button>
                <button>Save</button>
            </form>
        </template>
        <div class="grid grid-cols-[8fr_1fr] gap-4">
            <!-- TODO: Possible redesign for reactions / article comments in general -->
            <Reactions
                type="comment"
                :identifier="comment.slug"
                :reactions="comment.reactions_count"
                :userReaction="comment.userReaction"
                :availableReactions="usePage().props.availableReactions"
            />
            <div
                class="flex items-center justify-end gap-3"
                v-if="
                    currentUser &&
                    (currentUser.isStaff ||
                        currentUser.username === comment.author.username)
                "
            >
                <p
                    class="cursor-pointer"
                    @click="editComment = true"
                    v-if="
                        currentUser &&
                        currentUser.username === comment.author.username &&
                        !editComment
                    "
                >
                    Edit
                </p>
                <Link
                    v-if="
                        currentUser &&
                        (currentUser.isStaff ||
                            currentUser.username === comment.author.username)
                    "
                    :href="route('comments.destroy', { comment: comment.slug })"
                    method="DELETE"
                    class="text-rose-500"
                >
                    Delete
                </Link>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { useForm, Link, usePage } from "@inertiajs/vue3";
import currentUser from "@/Composables/User";
import route from "@/Composables/Route";

import Textarea from "@/Components/Form/Textarea.vue";
import Reactions from "@/Components/UI/Reactions.vue";

defineProps({
    comment: Object,
});

const editComment = ref(false);

const showReactionsBox = ref(false);

const editCommentForm = useForm({
    content: "",
});
</script>
