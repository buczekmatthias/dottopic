<template>
    <div>
        <p v-for="type in types" :key="type" @click="$emit('typePicked', type)">
            {{ type }}
        </p>
    </div>
</template>

<script setup>
defineEmits(["typePicked"]);

const types = ["header", "text", "file"];
</script>
