<template>
    <div class="overflow-x-auto p-1">
        <table class="w-full" v-if="data.length > 0">
            <thead>
                <tr>
                    <th class="w-fit px-3 text-center">#</th>
                    <th
                        v-for="(header, i) in headers"
                        :key="header"
                        class="capitalize px-3"
                        :class="columnSizes[i]"
                    >
                        {{ header }}
                    </th>
                    <th class="w-fit px-3" v-if="actions.length > 0"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(entry, i) in elementsWithoutHiddenData" :key="i">
                    <td class="w-fit px-3 text-center">{{ i + 1 }}</td>
                    <td
                        v-for="(element, j) in entry"
                        :key="j"
                        class="truncate px-3"
                        :class="columnSizes[Object.keys(entry).indexOf(j)]"
                    >
                        {{ element }}
                    </td>
                    <td class="w-fit px-3" v-if="actions.length > 0">
                        <template v-for="(action, j) in actions" :key="j">
                            <template
                                v-if="
                                    action.parameterKey && action.parameterValue
                                "
                            >
                                <Link
                                    :href="
                                        route(action.route, {
                                            [action.parameterKey]:
                                                data[i][action.parameterValue],
                                        })
                                    "
                                    :method="action?.method || 'GET'"
                                >
                                    <Icon :icon="action.icon" />
                                </Link>
                            </template>
                            <template v-else>
                                <Link
                                    :href="route(action.route)"
                                    :method="action?.method || 'GET'"
                                >
                                    <Icon :icon="action.icon" />
                                </Link>
                            </template>
                        </template>
                    </td>
                </tr>
            </tbody>
        </table>
        <p class="p-2.5" v-else>Nothing to display</p>
    </div>
</template>

<script setup>
import { computed } from "vue";

import { Link } from "@inertiajs/vue3";
import route from "@/Composables/Route";

import { Icon } from "@iconify/vue";

const props = defineProps({
    headers: Array,
    data: Object,
    actions: { type: Array, default: [] },
    hiddenData: { type: Array, default: [] },
    columnSizes: { type: Object, default: [] },
});

const elementsWithoutHiddenData = computed(() => {
    const v = JSON.parse(JSON.stringify(props.data));

    return v.map((entry) => {
        props.hiddenData.forEach((hd) => delete entry[hd]);

        return entry;
    });
});
</script>
