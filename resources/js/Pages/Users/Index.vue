<template>
    <div class="flex flex-col gap-4">
        <Deferred data="users">
            <template #fallback>
                <DeferredLoader text="Loading users" />
            </template>

            <div class="flex gap-2">
                <Link
                    :href="route('users.index', getQuery(['type']))"
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
                    :href="
                        route('users.index', {
                            type: userType,
                            ...getQuery(['type']),
                        })
                    "
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
            <form
                @submit.prevent="
                    searchForm.get(route('users.index', getQuery()))
                "
                class="grid grid-cols-[1fr_auto_auto] items-start gap-1"
            >
                <Input
                    v-model="searchForm.search"
                    type="search"
                    :error="null"
                    helpText="Search by name or username"
                />
                <Link
                    :href="route('users.index', getQuery(['search']))"
                    v-if="search"
                >
                    <Button
                        extraClasses="-mt-[0.075rem] !bg-red-600 hover:!bg-red-500"
                        type="button"
                    >
                        <Icon icon="octicon:x-16" />
                    </Button>
                </Link>
                <Button
                    extraClasses="-mt-[0.075rem] disabled:pointer-events-none"
                    :disabled="
                        searchForm.processing || searchForm.search === ''
                    "
                >
                    <Icon icon="octicon:search-24" />
                </Button>
            </form>

            <template v-if="users.data.length > 0">
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
                                :href="
                                    route('users.show', { user: user.username })
                                "
                                class="flex flex-col"
                            >
                                <span>{{ user.name }}</span>
                                <span class="text-slate-400 text-sm">
                                    @{{ user.username }}
                                </span>
                            </Link>
                            <UserRole :role="user.role" class="ml-auto" />
                        </div>
                        <div
                            class="text-slate-400 text-sm flex max-md:flex-wrap gap-x-4 gap-y-2"
                        >
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
                            <p
                                class="text-slate-400 text-sm max-md:w-full md:ml-auto"
                            >
                                Joined {{ user.created_at }}
                            </p>
                        </div>
                    </div>
                </div>
                <Pagination :links="users.links" :pagination="users.meta" />
            </template>
            <template v-else>
                <p>Nothing to display</p>
            </template>
        </Deferred>
    </div>
</template>

<script setup>
import { Link, Deferred, useForm } from "@inertiajs/vue3";
import route from "@/Composables/Route";

import { Icon } from "@iconify/vue";

import UserImage from "@/Components/UI/UserImage.vue";
import UserRole from "@/Components/UI/UserRole.vue";
import Pagination from "@/Components/Pagination.vue";
import DeferredLoader from "@/Components/DeferredLoader.vue";
import Button from "@/Components/Form/Button.vue";
import Input from "@/Components/Form/Input.vue";

const props = defineProps({
    users: Object,
    types: Array,
    tab: String,
    search: String,
});

const searchForm = useForm({
    search: props.search,
});

const getQuery = (exclude = []) => {
    let q = {};

    if (props.tab !== "") q["type"] = props.tab;
    if (props.search !== "") q["search"] = props.search;

    exclude.forEach((e) => delete q[e]);

    return q;
};
</script>
