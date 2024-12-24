<template>
    <div
        class="flex justify-between items-center"
        v-if="
            pagination.current_page > 0 &&
            pagination.current_page <= pagination.last_page
        "
    >
        <p>
            {{ pagination.from }} to {{ pagination.to }} of
            {{ pagination.total }}
        </p>
        <div class="flex gap-2" v-if="pagination.last_page !== 1">
            <Link
                :href="links.first"
                class="link"
                :class="{
                    'disabled-link': pagination.current_page === 1,
                }"
            >
                <Icon icon="octicon:move-to-start-24" height="16" width="16" />
            </Link>
            <Link
                :href="links.prev"
                class="link"
                :class="{
                    'disabled-link': pagination.current_page === 1,
                }"
            >
                <Icon icon="octicon:arrow-left-24" height="16" width="16" />
            </Link>
            <Link
                :href="links.next"
                class="link"
                :class="{
                    'disabled-link':
                        pagination.current_page === pagination.last_page,
                }"
            >
                <Icon icon="octicon:arrow-right-24" height="16" width="16" />
            </Link>
            <Link
                :href="links.last"
                class="link"
                :class="{
                    'disabled-link':
                        pagination.current_page === pagination.last_page,
                }"
            >
                <Icon icon="octicon:move-to-end-24" height="16" width="16" />
            </Link>
        </div>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";

import { Icon } from "@iconify/vue";

defineProps({
    links: Object,
    pagination: Object,
});
</script>

<style scoped lang="postcss">
.link {
    @apply p-2 border border-solid border-slate-50 rounded-md;
}
.disabled-link {
    @apply text-slate-400 border-slate-400 pointer-events-none;
}
</style>
