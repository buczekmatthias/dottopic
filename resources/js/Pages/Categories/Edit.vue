<template>
    <div class="flex flex-col gap-3">
        <Link
            :href="route('categories.show', { category: category.slug })"
            class="flex gap-1.5 items-center self-start hover:gap-2 duration-150"
        >
            <Icon
                icon="octicon:arrow-left-16"
                class="mt-1"
                height="16"
                width="16"
            />
            Return to category
        </Link>
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

            <MultiSelect
                label="Tags"
                :error="updateCategoryForm.errors.tags"
                v-model="updateCategoryForm.tags"
                :content="tags"
            />
            <Button
                :isProcessing="updateCategoryForm.processing"
                processingText="Updating"
            >
                Update category
            </Button>
        </form>
        <Link
            :href="
                route('admin.categories.destroy', {
                    category: category.slug,
                })
            "
            method="DELETE"
        >
            <Button extraClasses="!bg-red-500 enabled:hover:!bg-red-700 w-full">
                Delete category
            </Button>
        </Link>
    </div>
</template>

<script setup>
import { useForm, Link } from "@inertiajs/vue3";
import route from "@/Composables/Route";

import Input from "@/Components/Form/Input.vue";
import MultiSelect from "@/Components/Form/MultiSelect.vue";
import Button from "@/Components/Form/Button.vue";

import { Icon } from "@iconify/vue";

const props = defineProps({
    category: Object,
    tags: Object,
});

const updateCategoryForm = useForm({
    name: props.category.name,
    tags: props.category.tags,
});
</script>
