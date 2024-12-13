<template>
    <div class="content">
        <form
            @submit.prevent="
                createCategoryForm.post(route('admin.categories.store'))
            "
            class="flex flex-col gap-3"
        >
            <Input
                label="Name"
                :error="createCategoryForm.errors.name"
                v-model="createCategoryForm.name"
            />
            <div class="flex flex-wrap gap-3.5">
                <Checkbox
                    :label="tag.name"
                    v-for="tag in tags"
                    :key="tag.name"
                    :value="createCategoryForm.tags.includes(tag.name)"
                    @change="handleCheckboxChange(tag.name)"
                />
            </div>
            <Button
                :isProcessing="createCategoryForm.processing"
                processingText="Creating"
            >
                Create new category
            </Button>
        </form>
    </div>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
import route from "@/Composables/Route";

import Input from "@/Components/Form/Input.vue";
import Checkbox from "@/Components/Form/Checkbox.vue";
import Button from "@/Components/Form/Button.vue";

defineProps({
    tags: Object,
});

const createCategoryForm = useForm({
    name: "",
    tags: [],
});

const handleCheckboxChange = (name) => {
    if (createCategoryForm.tags.includes(name)) {
        createCategoryForm.tags = createCategoryForm.tags.filter(
            (category) => category !== name
        );
    } else {
        createCategoryForm.tags.push(name);
    }
};
</script>
