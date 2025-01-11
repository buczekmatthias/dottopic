<template>
    <div class="grid grid-cols-1 gap-4">
        <Deferred data="categories">
            <template #fallback>
                <div>Loading categories...</div>
            </template>

            <Table
                :headers="table.headers"
                :data="categories.data"
                :actions="table.actions"
                :hiddenData="table.hidden"
                :sortableColumns="table.sortable"
                :columnSizes="tableColumnSizes"
            />

            <Pagination
                :links="categories.links"
                :pagination="categories.meta"
            />
        </Deferred>
    </div>
</template>

<script setup>
import { Deferred } from "@inertiajs/vue3";

import Pagination from "@/Components/Pagination.vue";
import Table from "@/Components/UI/Admin/Table.vue";

defineProps({
    categories: Object,
    table: Object,
});

const tableColumnSizes = {
    name: "text-left",
    articles_count: "text-center",
    tags_count: "text-center",
};
</script>
