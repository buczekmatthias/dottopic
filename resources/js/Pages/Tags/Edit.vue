<template>
    <div class="flex flex-col gap-3">
        <Link
            :href="route('tags.show', { tag: tag.slug })"
            class="flex gap-1.5 items-center self-start hover:gap-2 duration-150"
        >
            <Icon
                icon="octicon:arrow-left-16"
                class="mt-1"
                height="16"
                width="16"
            />
            Return to tag
        </Link>
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

import { Icon } from "@iconify/vue";

const props = defineProps({
    tag: Object,
    categories: Object,
});

const updateTagForm = useForm({
    name: props.tag.name,
    categories: props.tag.categories,
});
</script>
