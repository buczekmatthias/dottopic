<template>
    <div
        class="grid grid-rows-[auto_1fr] grid-cols-[60px_1fr] lg:grid-cols-[100px_1fr]"
    >
        <div
            class="col-span-full bg-white p-2 h-14 flex items-center justify-between sticky top-0"
        >
            <p class="text-2xl font-semibold">
                <span class="text-indigo-700">dot</span>Topic
            </p>
            <NavigationUserBox />
        </div>
        <div
            class="bg-white h-[calc(100vh-3.5rem)] flex flex-col items-center justify-center gap-4 sticky top-14 py-3 lg:py-5"
        >
            <Link
                :href="route(link.route)"
                v-for="link in navigation"
                :key="link.route"
                class="p-2.5 lg:py-3 lg:px-6 rounded-md"
                :class="{
                    'bg-indigo-700 [&>*]:text-white': isActiveRoute(link.route),
                }"
            >
                <Icon
                    :icon="link.icon"
                    width="24"
                    height="24"
                    class="text-indigo-600"
                />
            </Link>
        </div>
        <div class="p-2.5 lg:p-5 flex flex-col gap-3">
            <Breadcrumbs />
            <slot />
        </div>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import route, { isActiveRoute } from "@/Composables/Route";

import { Icon } from "@iconify/vue";

import NavigationUserBox from "@/Components/UI/NavigationUserBox.vue";
import Breadcrumbs from "@/Components/UI/Breadcrumbs.vue";

const navigation = [
    {
        route: "homepage",
        icon: "octicon:home-16",
    },
    {
        route: "articles.index",
        icon: "octicon:file",
    },
    {
        route: "categories.index",
        icon: "octicon:file-directory-16",
    },
    {
        route: "tags.index",
        icon: "octicon:tag-16",
    },
    {
        route: "users.index",
        icon: "octicon:person-16",
    },
];
</script>
