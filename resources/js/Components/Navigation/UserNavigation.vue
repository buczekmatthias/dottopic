<template>
    <BaseNavigation :links="navigation">
        <template #navigation>
            <Link
                :href="route('homepage')"
                class="p-2.5 rounded-md border-r border-solid border-r-transparent"
                :class="{
                    'bg-slate-200/15 [&>*]:text-white':
                        isActiveRoute('homepage'),
                }"
            >
                <Icon
                    icon="octicon:home-16"
                    width="24"
                    height="24"
                    class="text-link"
                />
            </Link>
            <Link v-if="currentUser?.isStaff" :href="route('admin.dashboard')">
                <Icon
                    icon="octicon:shield-16"
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
import currentUser from "@/Composables/User";

import { Icon } from "@iconify/vue";

import BaseNavigation from "@/Components/Navigation/BaseNavigation.vue";

const navigation = [
    {
        route: "articles",
        icon: "octicon:file",
    },
    {
        route: "categories",
        icon: "octicon:file-directory-16",
    },
    {
        route: "tags",
        icon: "octicon:tag-16",
    },
    {
        route: "users",
        icon: "octicon:person-16",
    },
];
</script>
