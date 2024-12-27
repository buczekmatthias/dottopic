<template>
    <div>
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
            <MultiSelect
                label="Tags"
                :error="createCategoryForm.errors.tags"
                v-model="createCategoryForm.tags"
                :content="tags"
            />
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
import MultiSelect from "@/Components/Form/MultiSelect.vue";
import Button from "@/Components/Form/Button.vue";

defineProps({
    tags: Object,
});

const createCategoryForm = useForm({
    name: "",
    tags: [],
});
</script>
