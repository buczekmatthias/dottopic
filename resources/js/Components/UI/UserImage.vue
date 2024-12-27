<template>
    <template v-if="image">
        <img
            :src="image"
            alt=""
            :class="size"
            class="rounded-full object-cover"
        />
    </template>
    <template v-else>
        <div
            class="rounded-full flex items-center justify-center font-bold bg-theme"
            :class="size"
        >
            {{ initials }}
        </div>
    </template>
</template>

<script setup>
defineProps({
    image: String,
    initials: String,
    size: { type: String, default: "h-12 w-12" },
});
</script>
