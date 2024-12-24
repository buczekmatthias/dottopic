<template>
    <button
        :type="type"
        :disabled="isDisabled || isProcessing"
        class="enabled:bg-btn-default disabled:bg-btn-disabled duration-150 text-indigo-50 enabled:hover:bg-btn-hover flex items-center justify-center gap-3 rounded-md p-3 enabled:cursor-pointer disabled:cursor-not-allowed"
        :class="extraClasses"
    >
        <template v-if="isProcessing">
            <Loader :colors="loaderColors" :size="loaderSize" />
            {{ processingText }}...
        </template>
        <template v-else>
            <slot />
        </template>
    </button>
</template>

<script setup>
import Loader from "@/Components/Loader.vue";

defineProps({
    type: { type: String, default: "submit" },
    isDisabled: { type: Boolean, default: false },
    isProcessing: { type: Boolean, default: false },
    processingText: String,
    extraClasses: String,
    loaderColors: String,
    loaderSize: String,
});
</script>
