<template>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-3">
        <div
            class="grid grid-cols-2 lg:grid-cols-4 gap-3 p-2 lg:p-4 border border-solid border-input-default rounded-md col-span-full"
        >
            <div class="box">
                <p class="header">Total articles</p>
                <p class="content">{{ stats.total }}</p>
            </div>
            <div class="box">
                <p class="header">Metrics</p>
                <p
                    class="content"
                    :class="{
                        'text-green-500 positive': metrics > 0,
                        'text-rose-500': metrics < 0,
                    }"
                >
                    {{ metrics }}
                </p>
            </div>
            <div class="box">
                <p class="header">Current month</p>
                <p class="content">{{ stats.monthly.current }}</p>
            </div>
            <div class="box">
                <p class="header">Last month</p>
                <p class="content">{{ stats.monthly.last }}</p>
            </div>
        </div>
        <div class="border border-solid border-input-default rounded-md w-full">
            <p
                class="text-xl font-semibold px-2.5 py-4 border-b border-solid border-b-input-default"
            >
                Popular this month
            </p>
            <Table
                :headers="tableHeaders"
                :data="stats.popular.current_month"
                :actions="tableActions"
                :hiddenData="tableHiddenData"
                :columnSizes="tableColumnSizes"
            />
        </div>
        <div class="border border-solid border-input-default rounded-md">
            <p
                class="text-xl font-semibold px-2.5 py-4 border-b border-solid border-b-input-default"
            >
                Popular last month
            </p>
            <Table
                :headers="tableHeaders"
                :data="stats.popular.last_month"
                :actions="tableActions"
                :hiddenData="tableHiddenData"
                :columnSizes="tableColumnSizes"
            />
        </div>
    </div>
</template>

<script setup>
import { computed } from "vue";

import Table from "@/Components/UI/Admin/Table.vue";

const props = defineProps({
    stats: Object,
});

const metrics = computed(
    () => props.stats.monthly.current - props.stats.monthly.last
);

const tableHeaders = [
    { column: "title", header: "title", as: "text" },
    { column: "reactions_count", header: "reactions", as: "text" },
    { column: "comments_count", header: "comments", as: "text" },
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
];

const tableHiddenData = ["slug"];

const tableColumnSizes = {
    title: "max-w-80 text-left truncate",
    reactions_count: "text-center",
    comments_count: "text-center",
    created_at: "text-left",
};
</script>
