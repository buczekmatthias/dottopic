<template>
    <div class="flex flex-col gap-0.5">
        <label class="flex flex-col gap-1.5">
            <p v-if="label">
                {{ label }} <span v-if="required" class="text-red-600">*</span>
            </p>
            <textarea
                :disabled="isDisabled"
                class="p-1.5 rounded-md border border-solid"
                :class="{
                    'border-gray-300 focus:border-gray-600':
                        !error && !isDisabled,
                    'border-red-600 text-red-600': error,
                    'cursor-not-allowed bg-slate-100/80 text-slate-500/75':
                        isDisabled,
                }"
                v-model="model"
            ></textarea>
        </label>
        <span v-if="helpText" class="text-sm text-slate-500">
            {{ helpText }}
        </span>
        <template v-if="error">
            <template v-if="typeof error === String">
                <span class="text-sm text-red-600">{{ error }}</span>
            </template>
            <template v-else>
                <div class="flex flex-col">
                    <span
                        v-for="(err, i) in error"
                        :key="i"
                        class="text-sm text-red-600"
                    >
                        {{ err }}
                    </span>
                </div>
            </template>
        </template>
    </div>
</template>

<script setup>
defineProps({
    label: String,
    required: { type: Boolean, default: true },
    error: String | Array,
    helpText: String,
    isDisabled: { type: Boolean, default: false },
});

const model = defineModel();
</script>
