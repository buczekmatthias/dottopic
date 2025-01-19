<template>
    <div class="flex flex-col gap-4">
        <Deferred data="users">
            <template #fallback>
                <DeferredLoader text="Loading users" />
            </template>

            <div class="flex gap-2">
                <Link
                    :href="route('users.index')"
                    class="border-b-2 border-solid"
                    :class="
                        tab === ''
                            ? 'border-b-teal-500'
                            : 'border-b-transparent'
                    "
                >
                    All
                </Link>
                <Link
                    :href="route('users.index', { type: userType })"
                    :only="['users', 'tab']"
                    v-for="userType in types"
                    :key="userType"
                    class="capitalize border-b-2 border-solid"
                    :class="
                        tab === userType
                            ? 'border-b-teal-500'
                            : 'border-b-transparent'
                    "
                >
                    {{ userType + "s" }}
                </Link>
            </div>

            <div class="flex flex-col gap-4">
                <div
                    class="flex flex-col gap-2 border border-input-default border-solid rounded-md p-3"
                    v-for="user in users.data"
                    :key="user.username"
                >
                    <div class="flex gap-2 items-center">
                        <UserImage
                            :image="user.image"
                            :initials="user.initials"
                        />
                        <Link
                            :href="route('users.show', { user: user.username })"
                            class="flex flex-col"
                        >
                            <span>{{ user.name }}</span>
                            <span class="text-slate-400 text-sm">
                                @{{ user.username }}
                            </span>
                        </Link>
                        <UserRole :role="user.role" class="ml-auto" />
                    </div>
                    <div class="text-slate-400 text-sm flex gap-4">
                        <div class="flex gap-2 items-center">
                            <Icon
                                icon="octicon:file"
                                width="12"
                                height="12"
                                class="mt-1"
                            />
                            <p>{{ user.articles_count }} article(s)</p>
                        </div>
                        <div class="flex gap-2 items-center">
                            <Icon
                                icon="octicon:comment"
                                width="12"
                                height="12"
                                class="mt-1"
                            />
                            <p>{{ user.comments_count }} comment(s)</p>
                        </div>
                    </div>
                    <p class="text-slate-400 text-sm">
                        Joined {{ user.created_at }}
                    </p>
                </div>
            </div>
            <Pagination :links="users.links" :pagination="users.meta" />
        </Deferred>
    </div>
</template>

<script setup>
import { Link, Deferred } from "@inertiajs/vue3";
import route from "@/Composables/Route";

import { Icon } from "@iconify/vue";

import UserImage from "@/Components/UI/UserImage.vue";
import UserRole from "@/Components/UI/UserRole.vue";
import Pagination from "@/Components/Pagination.vue";
import DeferredLoader from "@/Components/DeferredLoader.vue";

defineProps({
    users: Object,
    types: Array,
    tab: String,
});
</script>
