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
            <MultiSelect
                label="Categories"
                :error="createTagForm.errors.categories"
                v-model="createTagForm.categories"
                :content="categories"
            />
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
import MultiSelect from "@/Components/Form/MultiSelect.vue";
import Button from "@/Components/Form/Button.vue";

defineProps({
    categories: Object,
});

const createTagForm = useForm({
    name: "",
    categories: [],
});
</script>
