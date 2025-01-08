<template>
    <th
        :class="[
            size,
            'capitalize px-3 py-2 border border-solid border-input-default',
        ]"
    >
        <template v-if="isSortable">
            <div class="flex gap-2 items-center">
                <p>{{ header.header }}</p>
                <div class="flex mt-0.5 gap-1">
                    <Link
                        :href="getRoute('asc')"
                        :class="
                            isSortedByThisHeader && isSortedAscending
                                ? 'pointer-events-none'
                                : 'text-slate-500'
                        "
                    >
                        <Icon icon="octicon:arrow-up" />
                    </Link>
                    <Link
                        :href="getRoute('desc')"
                        :class="
                            isSortedByThisHeader && !isSortedAscending
                                ? 'pointer-events-none'
                                : 'text-slate-500'
                        "
                    >
                        <Icon icon="octicon:arrow-down" />
                    </Link>
                </div>
            </div>
        </template>
        <template v-else>
            {{ header.header }}
        </template>
    </th>
</template>

<script setup>
import { usePage, Link } from "@inertiajs/vue3";
import { computed } from "vue";
import route from "@/Composables/Route";

import { Icon } from "@iconify/vue";

const props = defineProps({
    header: Object,
    size: String,
    isSortable: Boolean,
});

const isSortedByThisHeader = computed(() => {
    const { column } = usePage().props.sorting;

    return column.toLowerCase() === props.header.column.toLowerCase();
});

const isSortedAscending = computed(() => {
    const { order } = usePage().props.sorting;

    return order.toLowerCase() === "asc";
});

const getRoute = (order) => {
    const { current } = usePage().props.routes;

    return route(current, { column: props.header.column, order: order });
};
</script>
