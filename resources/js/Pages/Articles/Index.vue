<template>
    <div class="content">
        <Link
            :href="route('articles.create')"
            v-if="currentUser && currentUser.isStaff"
        >
            <Button>Create new tag</Button>
        </Link>
        {{ articles.data }}
        <br />
        <br />
        {{ articles.links }}
        <br />
        <br />
        {{ articles.meta }}
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import route from "@/Composables/Route";
import currentUser from "@/Composables/User";

import Button from "@/Components/Form/Button.vue";

defineProps({
    articles: Object,
});
</script>
