<template>
    <div class="content">
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
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import route from "@/Composables/Route";

defineProps({
    user: Object,
});
</script>
