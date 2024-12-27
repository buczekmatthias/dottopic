<template>
    <div class="flex flex-col gap-3">
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
            <MultiSelect
                label="Categories"
                :error="updateTagForm.errors.categories"
                v-model="updateTagForm.categories"
                :content="categories"
            />
            <Button
                :isProcessing="updateTagForm.processing"
                processingText="Updating"
            >
                Update tag
            </Button>
        </form>
        <Link
            :href="route('admin.tags.destroy', { tag: tag.slug })"
            method="DELETE"
        >
            <Button extraClasses="!bg-red-500 enabled:hover:!bg-red-700 w-full">
                Delete tag
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

const props = defineProps({
    tag: Object,
    categories: Object,
});

const updateTagForm = useForm({
    name: props.tag.name,
    categories: props.tag.categories,
});
</script>
