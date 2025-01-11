<template>
    <p
        class="rounded-md px-3 py-1 text-sm font-bold"
        :class="role.toLocaleLowerCase()"
    >
        {{ role }}
    </p>
</template>

<script setup>
defineProps({
    role: String,
});
</script>
