<template>
    <div class="flex justify-between items-center gap-2">
        <div class="flex gap-1" v-if="reactions.count > 0">
            <div class="">
                <p v-for="r in reactions.display" :key="r">{{ r }}</p>
            </div>
            <p>
                {{ reactions.count }}
            </p>
        </div>
        <p v-else>No reactions</p>
        <template v-if="currentUser">
            <Link
                :href="route('reactions.destroy', { reaction: identifier })"
                method="DELETE"
                :data="{ model: type }"
                v-if="userReaction"
            >
                {{ userReaction }} {{ availableReactions[userReaction] }}
            </Link>
            <div class="flex gap-2" v-else>
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
                    class="text-xl hover:scale-[1.35] duration-150"
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
