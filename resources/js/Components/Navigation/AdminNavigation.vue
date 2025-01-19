<template>
    <BaseNavigation :links="navigation">
        <template #header>
            <Link :href="route('homepage')">
                <Icon
                    icon="octicon:arrow-left-16"
                    width="24"
                    height="24"
                    class="text-link mt-1"
                />
            </Link>
        </template>
        <template #navigation>
            <Link
                :href="route('admin.dashboard')"
                class="p-2.5 rounded-md border-2 border-solid border-transparent"
                :class="{
                    'bg-slate-200/15 [&>*]:text-white':
                        isActiveRoute('admin.dashboard'),
                }"
            >
                <Icon
                    icon="octicon:diamond-16"
                    width="24"
                    height="24"
                    class="text-link"
                />
            </Link>
        </template>
        <slot />
    </BaseNavigation>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import route, { isActiveRoute } from "@/Composables/Route";

import { Icon } from "@iconify/vue";

import BaseNavigation from "@/Components/Navigation/BaseNavigation.vue";

const navigation = [
    {
        route: "admin.articles",
        icon: "octicon:file",
    },
    {
        route: "admin.categories",
        icon: "octicon:file-directory-16",
    },
    {
        route: "admin.tags",
        icon: "octicon:tag-16",
    },
    {
        route: "admin.users",
        icon: "octicon:person-16",
    },
];
</script>
