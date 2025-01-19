<template>
    <div class="grid grid-cols-1 gap-4">
        <Deferred data="tags">
            <template #fallback>
                <DeferredLoader text="Loading tags" />
            </template>

            <Table
                :headers="table.headers"
                :data="tags.data"
                :actions="table.actions"
                :hiddenData="table.hidden"
                :sortableColumns="table.sortable"
                :columnSizes="tableColumnSizes"
            />

            <Pagination :links="tags.links" :pagination="tags.meta" />
        </Deferred>
    </div>
</template>

<script setup>
import { Deferred } from "@inertiajs/vue3";

import Pagination from "@/Components/Pagination.vue";
import Table from "@/Components/UI/Admin/Table.vue";
import DeferredLoader from "@/Components/DeferredLoader.vue";

defineProps({
    tags: Object,
    table: Object,
});

const tableColumnSizes = {
    name: "text-left",
    articles_count: "text-center",
    categories_count: "text-center",
};
</script>
