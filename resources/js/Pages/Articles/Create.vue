<template>
    <div>
        <form @submit.prevent="handleFormSubmit" class="flex flex-col gap-3">
            <Input
                label="Title"
                :error="articleCreateForm.errors.title"
                v-model="articleCreateForm.title"
            />
            <Select
                label="Category"
                :content="categories"
                :error="articleCreateForm.errors.category_slug"
                v-model="articleCreateForm.category_slug"
            />

            <RichTextEditor
                label="Description"
                :error="articleCreateForm.errors.description"
                v-model="articleCreateForm.description"
            />
            <MultiSelect
                label="Tags"
                :content="tags"
                :error="articleCreateForm.errors.tags"
                v-model="articleCreateForm.tags"
            />
            <div class="flex flex-col gap-3">
                <p class="">Content <span class="text-red-500">*</span></p>
                <template
                    v-for="(content, i) in articleCreateForm.content"
                    :key="content.id"
                >
                    <ContentElement
                        :type="content.type"
                        :contentLength="articleCreateForm.content.length"
                        :index="i"
                        @moveUp="swap(i, i - 1)"
                        @moveDown="swap(i, i + 1)"
                        @removeElement="removeContentElement(content.id)"
                    >
                        <template v-if="content.type === 'header'">
                            <Input
                                :error="
                                    articleCreateForm.errors.content?.[i]
                                        .content
                                "
                                v-model="content.content"
                            />
                        </template>
                        <template v-else-if="content.type === 'text'">
                            <RichTextEditor
                                :error="
                                    articleCreateForm.errors.content?.[i]
                                        .content
                                "
                                v-model="content.content"
                            />
                        </template>
                        <template v-else>
                            <File
                                :mimes="mimes"
                                :error="
                                    articleCreateForm.errors.content?.[i]
                                        .content
                                "
                                @changeFile="content.content = $event[0]"
                            />
                        </template>
                    </ContentElement>
                </template>
            </div>
            <ArticleContentTypePicker @typePicked="handleNewPick" />
            <!-- TODO: Disable all buttons in forms until form is valid -->
            <Button
                :isProcessing="articleCreateForm.processing"
                processingText="Creating"
            >
                Create
            </Button>
        </form>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import route from "@/Composables/Route";

import { Icon } from "@iconify/vue";

import ArticleContentTypePicker from "@/Components/Form/ArticleContentTypePicker.vue";
import Input from "@/Components/Form/Input.vue";
import RichTextEditor from "@/Components/Form/RichTextEditor.vue";
import File from "@/Components/Form/File.vue";
import Select from "@/Components/Form/Select.vue";
import MultiSelect from "@/Components/Form/MultiSelect.vue";
import Button from "@/Components/Form/Button.vue";
import ContentElement from "@/Components/Form/ContentElement.vue";

defineProps({
    categories: Object,
    tags: Object,
    mimes: Array,
});

const articleCreateForm = useForm({
    title: "",
    description: "",
    content: [],
    category_slug: "",
    tags: [],
});

const contentItemsHighestId = ref(0);

const handleNewPick = (type) => {
    contentItemsHighestId.value++;

    articleCreateForm.content.push({
        id: contentItemsHighestId.value,
        type: type,
        content: type === "file" ? null : "",
    });
};

const removeContentElement = (id) => {
    articleCreateForm.content = articleCreateForm.content.filter(
        (content) => content.id !== id
    );
};

const handleFormSubmit = () => {
    articleCreateForm
        .transform((data) => ({
            ...data,
            content: data.content.map((c) => {
                delete c.id;
                return c;
            }),
        }))
        .post(route("articles.store"));
};

const swap = (index, newIndex) => {
    let temp = articleCreateForm.content[index];
    articleCreateForm.content[index] = articleCreateForm.content[newIndex];
    articleCreateForm.content[newIndex] = temp;
};
</script>
