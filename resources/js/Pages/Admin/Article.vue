<template>
    <div class="grid grid-cols-1 gap-4">
        <Deferred data="articles">
            <template #fallback>
                <DeferredLoader text="Loading articles" />
            </template>

            <Table
                :headers="table.headers"
                :data="articles.data"
                :actions="table.actions"
                :hiddenData="table.hidden"
                :sortableColumns="table.sortable"
                :columnSizes="tableColumnSizes"
            />

            <Pagination :links="articles.links" :pagination="articles.meta" />
        </Deferred>
    </div>
</template>

<script setup>
import { Deferred } from "@inertiajs/vue3";

import Pagination from "@/Components/Pagination.vue";
import Table from "@/Components/UI/Admin/Table.vue";
import DeferredLoader from "@/Components/DeferredLoader.vue";

defineProps({
    articles: Object,
    table: Object,
});

const tableColumnSizes = {
    title: "max-w-80 text-left truncate",
    description: "max-w-80 text-left truncate",
    author: "text-left",
    category: "text-left",
    reactions_count: "text-center",
    comments_count: "text-center",
    tags_count: "text-center",
    created_at: "text-left",
};
</script>
