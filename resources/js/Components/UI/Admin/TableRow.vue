<template>
    <tr class="[&>*]:px-3 [&>*]:py-2 [&>*]:whitespace-nowrap">
        <td
            v-for="element in headers"
            :key="element.column"
            :class="[
                'border border-solid border-input-default',
                sizes[element.column],
            ]"
        >
            <template v-if="element.as === 'text'">
                {{ entry[element.column] }}
            </template>
            <template v-else>
                <Link
                    :href="
                        route(element.link.route, {
                            [element.link.parameterKey]:
                                entry[element.column][
                                    element.link.parameterValue
                                ],
                        })
                    "
                    class="text-link font-semibold"
                >
                    {{ entry[element.column][element.link.textValue] }}
                </Link>
            </template>
        </td>
        <td
            v-if="actions.length > 0"
            class="border border-solid border-input-default"
        >
            <div class="w-min mx-auto flex gap-2">
                <template v-for="(action, j) in actions" :key="j">
                    <template
                        v-if="action.parameterKey && action.parameterValue"
                    >
                        <Link
                            :href="
                                route(action.route, {
                                    [action.parameterKey]:
                                        entry[action.parameterValue],
                                })
                            "
                            :method="action?.method || 'GET'"
                            :class="action?.color"
                        >
                            <Icon :icon="action.icon" />
                        </Link>
                    </template>
                    <template v-else>
                        <Link
                            :href="route(action.route)"
                            :method="action?.method || 'GET'"
                            :class="action?.color"
                        >
                            <Icon :icon="action.icon" />
                        </Link>
                    </template>
                </template>
            </div>
        </td>
    </tr>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import route from "@/Composables/Route";

import { Icon } from "@iconify/vue";

defineProps({
    entry: Object,
    sizes: Object,
    actions: Array,
    headers: Array,
});
</script>
