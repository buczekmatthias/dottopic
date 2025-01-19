<template>
    <div
        class="min-h-screen grid grid-rows-[auto_1fr_auto] md:grid-rows-[auto_1fr] grid-cols-1 md:grid-cols-[60px_1fr]"
    >
        <div
            class="col-span-full p-2 h-14 flex gap-3 items-center sticky top-0 z-20 bg-container border-b border-solid border-b-input-default"
        >
            <slot name="header" />
            <p class="text-2xl font-semibold mr-auto">
                <span class="text-link">dot</span>Topic
            </p>
            <NavigationUserBox />
        </div>
        <div
            class="md:h-[calc(100vh-3.5rem)] max-md:row-start-3 flex md:flex-col items-center justify-center gap-4 sticky max-md:bottom-0 md:top-14 z-20 bg-container border-solid max-md:border-t md:border-r border-input-default p-1 md:py-3"
        >
            <slot name="navigation" />
            <Link
                :href="route(link.route + '.index')"
                v-for="link in links"
                :key="link.route"
                class="p-2.5 rounded-md border-2 border-solid border-transparent"
                :class="{
                    'bg-slate-200/15 [&>*]:text-white': isActiveRoute(
                        link.route + '.index'
                    ),
                    '!border-checkbox':
                        !isActiveRoute(link.route + '.index') &&
                        isCurrentRouteInGroup(link.route),
                }"
            >
                <Icon
                    :icon="link.icon"
                    width="24"
                    height="24"
                    class="text-link"
                />
            </Link>
        </div>
        <div class="p-2.5 lg:p-5 flex flex-col gap-6 w-full max-w-7xl mx-auto">
            <Breadcrumbs />
            <slot />
        </div>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import route, {
    isActiveRoute,
    isCurrentRouteInGroup,
} from "@/Composables/Route";

import { Icon } from "@iconify/vue";

import Breadcrumbs from "@/Components/UI/Breadcrumbs.vue";
import NavigationUserBox from "@/Components/UI/NavigationUserBox.vue";

defineProps({
    links: Array,
});
</script>
