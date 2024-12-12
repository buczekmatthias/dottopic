<template>
    <div class="content">
        <form
            @submit.prevent="
                updateTagForm.patch(
                    route('admin.tags.update', { tag: tag.slug })
                )
            "
            class="flex flex-col gap-3"
        >
            <Input
                label="Name"
                :error="updateTagForm.errors.name"
                v-model="updateTagForm.name"
            />
            <div class="flex flex-wrap gap-3.5">
                <Checkbox
                    :label="category.name"
                    v-for="category in categories"
                    :key="category.name"
                    :value="updateTagForm.categories.includes(category.name)"
                    @change="handleCheckboxChange(category.name)"
                />
            </div>
            <Button
                :isProcessing="updateTagForm.processing"
                processingText="Updating"
            >
                Update tag
            </Button>
        </form>
        <Button
            extraClasses="!bg-red-600 enabled:hover:!bg-red-700"
            @click="
                router.delete(route('admin.tags.destroy', { tag: tag.slug }))
            "
        >
            Delete
        </Button>
        {{ updateTagForm }}
    </div>
</template>

<script setup>
import { ref } from "vue";
import { router, useForm } from "@inertiajs/vue3";
import route from "@/Composables/Route";

import Input from "@/Components/Form/Input.vue";
import Checkbox from "@/Components/Form/Checkbox.vue";
import Button from "@/Components/Form/Button.vue";

const props = defineProps({
    tag: Object,
    categories: Object,
});
// TODO: Fix all checkboxes triggering while nothing is added to array and can't remove

// const formCategories = ref(props.tag.categories);

const updateTagForm = useForm({
    name: props.tag.name,
    categories: props.tag.categories,
});

const handleCheckboxChange = (name) => {
    if (updateTagForm.categories.includes(name)) {
        updateTagForm.categories = updateTagForm.categories.filter(
            (category) => category !== name
        );
    } else {
        updateTagForm.categories.push(name);
    }
};
</script>
