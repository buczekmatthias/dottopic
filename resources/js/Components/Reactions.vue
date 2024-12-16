<template>
    <div>
        <template v-if="currentUser">
            <Link
                :href="route('reactions.destroy', { reaction: identifier })"
                method="DELETE"
                :data="{ model: type }"
                v-if="userReaction"
            >
                {{ userReaction }} {{ availableReactions[userReaction] }}
            </Link>
            <div v-else>
                <Link
                    :href="route('reactions.store')"
                    method="POST"
                    :data="{
                        model: type,
                        reaction: reaction,
                        slug: identifier,
                    }"
                    v-for="reaction in Object.keys(availableReactions)"
                    :key="reaction"
                >
                    {{ reaction }}
                </Link>
            </div>
        </template>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import currentUser from "@/Composables/User";
import route from "@/Composables/Route";

defineProps({
    type: String,
    identifier: String,
    reactions: Object,
    userReaction: String,
    availableReactions: Object,
});
</script>
