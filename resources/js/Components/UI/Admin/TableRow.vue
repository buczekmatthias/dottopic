<template>
    <tr class="[&>*]:px-3 [&>*]:py-2 [&>*]:whitespace-nowrap">
        <td
            v-for="element in headers"
            :key="element.column"
            :class="[
                'border border-solid border-input-default',
                sizes[element.column],
                element?.useAsClass ? entry[element.column].toLowerCase() : '',
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
                        v-if="action?.disabledKey && !entry[action.disabledKey]"
                    >
                        <Icon :icon="action.icon" class="text-slate-500" />
                    </template>
                    <template v-else>
                        <Link
                            :href="
                                action.parameterKey && action.parameterValue
                                    ? route(action.route, {
                                          [action.parameterKey]:
                                              entry[action.parameterValue],
                                      })
                                    : route(action.route)
                            "
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
