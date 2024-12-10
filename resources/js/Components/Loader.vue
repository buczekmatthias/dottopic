<template>
    <div
        class="border-4 border-t-4 border-solid rounded-full h-6 w-6 animate-spin"
        :class="[
            colors ? colors : 'border-slate-400/45 border-t-slate-700',
            size ? size : 'h-6 w-6',
        ]"
    ></div>
</template>

<script setup>
defineProps({
    colors: String,
    size: String,
});
</script>
