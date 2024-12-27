<template>
    <p
        class="rounded-md px-3 py-1 text-sm font-semibold"
        :class="{
            'bg-slate-400/20 text-slate-400': role === 'User',
            'bg-amber-500/20 text-amber-500': role === 'Writer',
            'bg-rose-500/20 text-rose-500': role === 'Mod',
            'bg-teal-500/20 text-teal-500': role === 'Admin',
            'bg-purple-400/20 text-purple-300': role === 'Dev',
        }"
    >
        {{ role }}
    </p>
</template>

<script setup>
defineProps({
    role: String,
});
</script>
