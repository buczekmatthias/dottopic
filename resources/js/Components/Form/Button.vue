<template>
    <button
        :disabled="isDisabled || isProcessing"
        class="enabled:bg-indigo-700 disabled:bg-indigo-800 text-indigo-50 enabled:hover:bg-indigo-600 flex items-center justify-center gap-3 rounded-md p-3 enabled:cursor-pointer disabled:cursor-not-allowed"
        :class="extraClasses"
    >
        <template v-if="isProcessing">
            <Loader :colors="loaderColors" :size="loaderSize" />
            {{ progressingText }}...
        </template>
        <template v-else>
            <slot />
        </template>
    </button>
</template>

<script setup>
import Loader from "@/Components/Loader.vue";

defineProps({
    isDisabled: { type: Boolean, default: false },
    isProcessing: { type: Boolean, default: false },
    progressingText: String,
    extraClasses: String,
    loaderColors: String,
    loaderSize: String,
});
</script>
