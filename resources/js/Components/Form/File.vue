<template>
    <div class="flex flex-col gap-0.5">
        <label class="flex flex-col gap-1.5" :class="labelClasses">
            <slot>
                <p v-if="label">
                    {{ label }}
                    <span v-if="required" class="text-red-500">*</span>
                </p>
            </slot>
            <input
                type="file"
                :accept="mimes"
                :multiple="multiple"
                :disabled="isDisabled"
                class="p-1.5 rounded-md border border-solid"
                :class="{
                    hidden: $slots.default,
                    'border-gray-300 focus:border-gray-600':
                        !error && !isDisabled,
                    'border-red-500 text-red-500': error,
                    'cursor-not-allowed bg-slate-100/80 text-slate-500/75':
                        isDisabled,
                }"
                @change="handleInputChange"
            />
        </label>
        <span v-if="helpText" class="text-sm text-slate-400">
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
        <div class="flex flex-wrap" v-if="previews.length > 0">
            <template v-if="teleportTo">
                <Teleport :to="teleportTo">
                    <template v-for="item in previews" :key="item.url">
                        <img
                            :src="item.url"
                            alt=""
                            v-if="item.isImage"
                            class="h-24 w-24 rounded-md object-contain"
                        />
                        <video
                            :src="item.url"
                            v-else
                            class="h-24 w-24 rounded-md"
                        ></video>
                    </template>
                </Teleport>
            </template>
            <template v-else>
                <template v-for="item in previews" :key="item.url">
                    <img
                        :src="item.url"
                        alt=""
                        v-if="item.isImage"
                        class="h-24 w-24 rounded-md object-contain"
                    />
                    <video
                        :src="item.url"
                        v-else
                        class="h-24 w-24 rounded-md"
                    ></video>
                </template>
            </template>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";

defineProps({
    label: String,
    labelClasses: String,
    required: { type: Boolean, default: true },
    error: String | Array,
    helpText: String,
    mimes: Array,
    isDisabled: { type: Boolean, default: false },
    multiple: { type: Boolean, default: false },
    teleportTo: String,
});

const previews = ref([]);

const emit = defineEmits(["changeFile"]);

const handleInputChange = (e) => {
    emit("changeFile", e.target.files);
    filesPreviewUrls(e.target.files);
};

const filesPreviewUrls = (files) => {
    previews.value = [];

    Array.from(files).forEach((f) =>
        previews.value.push({
            url: URL.createObjectURL(f),
            isImage: f.type.includes("image"),
        })
    );
};
</script>
