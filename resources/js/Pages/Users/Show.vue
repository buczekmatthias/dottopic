<template>
    <div>
        <template v-if="currentUser">
            <Link
                :href="route('users.edit', { user: user.username })"
                v-if="currentUser.username === user.username"
            >
                <Button> Edit profile </Button>
            </Link>
        </template>
        <div class="">
            <Link
                :href="
                    route('users.show', {
                        user: user.username,
                        tab: tab.toLowerCase(),
                    })
                "
                v-for="tab in ['Articles', 'Comments']"
                :key="tab"
            >
                {{ tab }}
            </Link>
        </div>
        {{ user }}
        <Deferred data="content">
            <template #fallback>
                <p>Loading {{ tab }}...</p>
            </template>

            {{ content }}
        </Deferred>
    </div>
</template>

<script setup>
import { Link, Deferred } from "@inertiajs/vue3";
import route from "@/Composables/Route";
import currentUser from "@/Composables/User";

import Button from "@/Components/Form/Button.vue";

defineProps({
    user: Object,
    content: Object,
    tab: String,
});
</script>
