<template>
    <div class="flex flex-col gap-0.5">
        <label class="flex flex-col gap-1.5">
            <p v-if="label">
                {{ label }} <span v-if="required" class="text-red-500">*</span>
            </p>
            <input
                :type="type"
                :disabled="isDisabled"
                class="p-1.5 rounded-md border border-solid"
                :class="{
                    'border-input-default focus:border-input-focus':
                        !error && !isDisabled,
                    'border-red-500 text-red-500': error,
                    'cursor-not-allowed bg-slate-100/80 text-slate-500/75':
                        isDisabled,
                }"
                v-model="model"
            />
        </label>
        <span v-if="helpText" class="text-sm text-slate-500">
            {{ helpText }}
        </span>
        <template v-if="error">
            <template v-if="typeof error === String">
                <span class="text-sm text-red-500">{{ error }}</span>
            </template>
            <template v-else>
                <div class="flex flex-col">
                    <span
                        v-for="(err, i) in error"
                        :key="i"
                        class="text-sm text-red-500"
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
    type: { type: String, default: "text" },
    isDisabled: { type: Boolean, default: false },
});

const model = defineModel();
</script>
