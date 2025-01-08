<template>
    <div class="grid grid-cols-1 gap-4">
        <Deferred data="articles">
            <template #fallback>
                <div>Loading articles...</div>
            </template>

            <Table
                :headers="tableHeaders"
                :data="articles.data"
                :actions="tableActions"
                :hiddenData="tableHiddenData"
                :columnSizes="tableColumnSizes"
                :sortableColumns="tableSortableColumns"
            />

            <Pagination :links="articles.links" :pagination="articles.meta" />
        </Deferred>
    </div>
</template>

<script setup>
import { Deferred } from "@inertiajs/vue3";

import Pagination from "@/Components/Pagination.vue";
import Table from "@/Components/UI/Admin/Table.vue";

defineProps({
    articles: Object,
});

const tableHeaders = [
    { column: "title", header: "title", as: "text" },
    { column: "description", header: "description", as: "text" },
    {
        column: "author",
        header: "author",
        as: "link",
        link: {
            route: "users.show",
            parameterKey: "user",
            parameterValue: "username",
            textValue: "name",
        },
    },
    {
        column: "category",
        header: "category",
        as: "link",
        link: {
            route: "categories.show",
            parameterKey: "category",
            parameterValue: "slug",
            textValue: "name",
        },
    },
    { column: "reactions_count", header: "reactions", as: "text" },
    { column: "comments_count", header: "comments", as: "text" },
    { column: "tags_count", header: "tags", as: "text" },
    { column: "created_at", header: "created", as: "text" },
];

const tableActions = [
    {
        icon: "octicon:link-external-24",
        route: "articles.show",
        parameterKey: "article",
        parameterValue: "slug",
        method: "GET",
    },
    {
        icon: "octicon:trash-16",
        route: "articles.destroy",
        parameterKey: "article",
        parameterValue: "slug",
        method: "DELETE",
        color: "text-red-500",
    },
];

const tableHiddenData = ["slug"];

const tableSortableColumns = [
    "id",
    "title",
    "author",
    "category",
    "reactions_count",
    "comments_count",
    "tags_count",
    "created_at",
];

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
