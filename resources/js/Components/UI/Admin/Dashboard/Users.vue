<template>
    <div
        class="grid grid-cols-2 lg:grid-cols-4 gap-3 p-2 lg:p-4 border border-solid border-input-default rounded-md"
    >
        <div class="box">
            <p class="header">Total users</p>
            <p class="content">{{ stats.total }}</p>
        </div>
        <div class="box">
            <p class="header">Metrics</p>
            <p
                class="content"
                :class="{
                    'text-green-500 positive': metrics > 0,
                    'text-rose-500': metrics < 0,
                }"
            >
                {{ metrics }}
            </p>
        </div>
        <div class="box">
            <p class="header">Current month</p>
            <p class="content">{{ stats.monthly.current }}</p>
        </div>
        <div class="box">
            <p class="header">Last month</p>
            <p class="content">{{ stats.monthly.last }}</p>
        </div>
    </div>
</template>

<script setup>
import { computed } from "vue";

const props = defineProps({
    stats: Object,
});

const metrics = computed(
    () => props.stats.monthly.current - props.stats.monthly.last
);
</script>
