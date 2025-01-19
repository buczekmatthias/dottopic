<template>
    <div class="grid grid-cols-1 gap-4">
        <Deferred data="users">
            <template #fallback>
                <DeferredLoader text="Loading users" />
            </template>

            <div class="flex gap-2">
                <Link
                    :href="route('admin.users.index')"
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
                    :href="route('admin.users.index', { type: userType })"
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

            <Table
                :headers="table.headers"
                :data="users.data"
                :actions="table.actions"
                :hiddenData="table.hidden"
                :sortableColumns="table.sortable"
                :columnSizes="tableColumnSizes"
            />

            <Pagination :links="users.links" :pagination="users.meta" />
        </Deferred>
    </div>
</template>

<script setup>
import { Deferred, Link } from "@inertiajs/vue3";
import route from "@/Composables/Route";

import Pagination from "@/Components/Pagination.vue";
import Table from "@/Components/UI/Admin/Table.vue";
import DeferredLoader from "@/Components/DeferredLoader.vue";

defineProps({
    users: Object,
    table: Object,
    types: Array,
    tab: String,
});

const tableColumnSizes = {
    name: "text-left",
    username: "text-left",
    email: "text-left",
    role: "text-center",
    articles_count: "text-center",
    comments_count: "text-center",
    created_at: "text-left",
};
</script>
