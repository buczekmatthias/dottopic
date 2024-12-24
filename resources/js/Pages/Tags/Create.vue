<template>
    <div>
        <form
            @submit.prevent="createTagForm.post(route('admin.tags.store'))"
            class="flex flex-col gap-3"
        >
            <Input
                label="Name"
                :error="createTagForm.errors.name"
                v-model="createTagForm.name"
            />
            <div class="flex flex-wrap gap-3.5">
                <Checkbox
                    :label="category.name"
                    v-for="category in categories"
                    :key="category.name"
                    :value="createTagForm.categories.includes(category.name)"
                    @change="handleCheckboxChange(category.name)"
                />
            </div>
            <Button
                :isProcessing="createTagForm.processing"
                processingText="Creating"
            >
                Create new tag
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
    categories: Object,
});

const createTagForm = useForm({
    name: "",
    categories: [],
});

const handleCheckboxChange = (name) => {
    if (createTagForm.categories.includes(name)) {
        createTagForm.categories = createTagForm.categories.filter(
            (category) => category !== name
        );
    } else {
        createTagForm.categories.push(name);
    }
};
</script>
