<template>
    <div>
        <form
            @submit.prevent="
                updateCategoryForm.patch(
                    route('admin.categories.update', {
                        category: category.slug,
                    })
                )
            "
            class="flex flex-col gap-3"
        >
            <Input
                label="Name"
                :error="updateCategoryForm.errors.name"
                v-model="updateCategoryForm.name"
            />
            <div class="flex flex-wrap gap-3.5">
                <!-- TODO: Create Multiselect component instead -->
                <Checkbox
                    :label="tag.name"
                    v-for="tag in tags"
                    :key="tag.name"
                    :value="updateCategoryForm.tags.includes(tag.name)"
                    @change="handleCheckboxChange(tag.name)"
                />
            </div>
            <Button
                :isProcessing="updateCategoryForm.processing"
                processingText="Updating"
            >
                Update tag
            </Button>
        </form>
        <Button
            extraClasses="!bg-red-500 enabled:hover:!bg-red-700"
            @click="
                router.delete(
                    route('admin.categories.destroy', {
                        category: category.slug,
                    })
                )
            "
        >
            Delete
        </Button>
        {{ updateCategoryForm }}
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
    category: Object,
    tags: Object,
});
// TODO: Fix all checkboxes triggering while nothing is added to array and can't remove

// const formCategories = ref(props.category.categories);

const updateCategoryForm = useForm({
    name: props.category.name,
    tags: props.category.tags,
});

const handleCheckboxChange = (name) => {
    if (updateCategoryForm.tags.includes(name)) {
        updateCategoryForm.tags = updateCategoryForm.tags.filter(
            (tag) => tag !== name
        );
    } else {
        updateCategoryForm.tags.push(name);
    }
};
</script>
