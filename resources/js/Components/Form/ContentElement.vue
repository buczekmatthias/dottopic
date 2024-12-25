<template>
    <div class="border border-solid border-slate-500 rounded-md">
        <div
            class="flex gap-1.5 items-center p-2 border-b border-solid border-b-slate-500"
        >
            <p class="text-3xl font-semibold capitalize mr-auto">{{ type }}</p>
            <Button
                type="button"
                @click="$emit('moveUp')"
                :disabled="index === 0"
            >
                <Icon icon="octicon:chevron-up-12" width="16" height="16" />
            </Button>
            <Button
                type="button"
                @click="$emit('moveDown')"
                :disabled="index === contentLength - 1"
            >
                <Icon icon="octicon:chevron-down-12" width="16" height="16" />
            </Button>
            <Button
                type="button"
                @click="$emit('removeElement')"
                extraClasses="!bg-rose-500"
            >
                <Icon icon="octicon:trash-16" width="16" height="16" />
            </Button>
        </div>
        <div class="p-2" :class="{ relative: type === 'file' }">
            <slot />
        </div>
    </div>
</template>

<script setup>
import Button from "@/Components/Form/Button.vue";

import { Icon } from "@iconify/vue";

defineProps({
    type: String,
    contentLength: Number,
    index: Number,
});

defineEmits(["removeElement", "moveUp", "moveDown"]);
</script>
