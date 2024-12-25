<template>
    <div
        class="border border-solid border-slate-500 rounded-md p-2 grid grid-cols-3 gap-2 gap-y-4"
    >
        <p class="col-span-full text-lg">Pick new content element type</p>
        <Button
            type="button"
            v-for="type in types"
            :key="type"
            @click="$emit('typePicked', type)"
            extraClasses="capitalize !p-2"
        >
            {{ type }}
        </Button>
    </div>
</template>

<script setup>
import Button from "@/Components/Form/Button.vue";

defineEmits(["typePicked"]);

const types = ["header", "text", "file"];
</script>
