<template>
    <div class="flex flex-col gap-0.5">
        <label class="flex flex-col gap-1.5 relative" ref="select">
            <p v-if="label">
                {{ label }} <span v-if="required" class="text-red-500">*</span>
            </p>
            <input
                type="text"
                :disabled="isDisabled"
                class="p-1.5 rounded-md border border-solid"
                :class="{
                    'border-input-default focus:border-input-focus':
                        !error && !isDisabled,
                    'border-red-500 text-red-500': error,
                    'cursor-not-allowed bg-slate-100/80 text-slate-500/75':
                        isDisabled,
                }"
                @keyup="showSuggestions = search !== ''"
                v-model="search"
            />
            <div
                class="flex-col absolute top-[105%] left-0 w-full z-30 bg-white"
                :class="showSuggestions ? 'flex' : 'hidden'"
            >
                <div
                    @click="addNewEntry(entry.slug)"
                    v-for="entry in searchResults"
                    :key="entry"
                    class="flex gap-2 cursor-pointer p-2"
                >
                    <p>{{ entry.name }}</p>
                    <p class="text-slate-400">{{ entry.slug }}</p>
                </div>
            </div>
            <div class="" v-if="model.length > 0">
                <div class="" v-for="slug in model" :key="slug">
                    <p>{{ slug }}</p>
                    <p @click="removeEntry(slug)">Remove</p>
                </div>
            </div>
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
import { computed, ref } from "vue";
import { onClickOutside } from "@vueuse/core";

const props = defineProps({
    label: String,
    required: { type: Boolean, default: true },
    error: String | Array,
    helpText: String,
    isDisabled: { type: Boolean, default: false },
    content: Object,
});

const model = defineModel();

const select = ref(null);

const search = ref("");

const showSuggestions = ref(false);

const searchResults = computed(() => {
    if (search.value) {
        return props.content.filter(
            (d) =>
                d.name.toLowerCase().includes(search.value.toLowerCase()) ||
                d.slug.toLowerCase().includes(search.value.toLowerCase())
        );
    }
});

const addNewEntry = (slug) => {
    model.value.push(slug);
    showSuggestions.value = false;
    search.value = "";
};

const removeEntry = (slug) =>
    (model.value = model.value.filter((entry) => entry !== slug));

onClickOutside(select, () => (showSuggestions.value = false));
</script>
