<template>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-3">
        <div
            class="grid grid-cols-2 lg:grid-cols-4 gap-3 p-2 lg:p-4 border border-solid border-input-default rounded-md col-span-full"
        >
            <div class="box">
                <p class="header">Total categories</p>
                <p class="content">{{ stats.total }}</p>
            </div>
            <div class="box">
                <p class="header">Unused categories</p>
                <p class="content">{{ stats.unused }}</p>
            </div>
        </div>
        <div class="border border-solid border-input-default rounded-md">
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
import Table from "@/Components/UI/Table.vue";

defineProps({
    stats: Object,
});

const tableHeaders = ["name", "articles"];

const tableActions = [
    {
        icon: "octicon:link-external-24",
        route: "categories.show",
        parameterKey: "category",
        parameterValue: "slug",
        method: "GET",
    },
];

const tableHiddenData = ["slug"];

const tableColumnSizes = ["max-w-80 text-left", "text-center"];
</script>
