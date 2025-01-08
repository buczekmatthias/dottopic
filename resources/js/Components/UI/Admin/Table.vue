<template>
    <div class="overflow-x-auto p-1">
        <table class="w-full border-collapse" v-if="data.length > 0">
            <thead>
                <tr>
                    <TableHeader
                        v-for="(header, i) in [
                            { column: 'id', header: 'id', as: 'text' },
                            ...headers,
                        ]"
                        :key="header.column"
                        :size="
                            { id: 'w-fit text-center', ...columnSizes }[
                                header.column
                            ]
                        "
                        :isSortable="sortableColumns.includes(header.column)"
                        :header="header"
                    />
                    <th
                        class="px-3 border border-solid border-input-default"
                        v-if="actions.length > 0"
                    ></th>
                </tr>
            </thead>
            <tbody>
                <TableRow
                    v-for="entry in data"
                    :key="entry.id"
                    :entry="entry"
                    :actions="actions"
                    :headers="[
                        { column: 'id', header: 'id', as: 'text' },
                        ...headers,
                    ]"
                    :sizes="{ id: 'w-fit text-center', ...columnSizes }"
                />
            </tbody>
        </table>
        <p class="p-2.5" v-else>Nothing to display</p>
    </div>
</template>

<script setup>
// TODO: Fix table everywhere
import TableHeader from "@/Components/UI/Admin/TableHeader.vue";
import TableRow from "@/Components/UI/Admin/TableRow.vue";

defineProps({
    headers: Array,
    data: Object,
    actions: { type: Array, default: [] },
    hiddenData: { type: Array, default: [] },
    columnSizes: { type: Object, default: [] },
    sortableColumns: { type: Array, default: [] },
});
</script>
