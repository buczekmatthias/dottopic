<template>
    <label class="flex gap-2 items-center">
        <div
            class="h-5 w-5 rounded-md cursor-pointer bg-btn-default border border-solid border-checkbox flex items-center justify-center"
            :class="{
                'bg-opacity-10': !model,
            }"
        >
            <svg
                class="h-[80%] fill-slate-50"
                :class="{
                    'opacity-30': !model,
                }"
                stroke-width="0"
                viewBox="0 0 16 16"
                xmlns="http://www.w3.org/2000/svg"
            >
                <path
                    fill-rule="evenodd"
                    d="M13.854 3.646a.5.5 0 010 .708l-7 7a.5.5 0 01-.708 0l-3.5-3.5a.5.5 0 11.708-.708L6.5 10.293l6.646-6.647a.5.5 0 01.708 0z"
                    clip-rule="evenodd"
                ></path>
            </svg>
        </div>
        <input
            type="checkbox"
            v-model="model"
            class="hidden"
            :required="required"
        />
        <p class="cursor-pointer">
            {{ label }} <span v-if="required" class="text-red-500">*</span>
        </p>
    </label>
</template>

<script setup>
defineProps({
    label: String,
    required: { type: Boolean, default: false },
});

const model = defineModel();
</script>
