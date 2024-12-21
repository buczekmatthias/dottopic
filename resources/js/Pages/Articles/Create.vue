<template>
    <div class="content">
        <form @submit.prevent="handleFormSubmit">
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
            <div>
                <template
                    v-for="(content, i) in articleCreateForm.content"
                    :key="content.id"
                >
                    <template v-if="content.type === 'header'">
                        <div>
                            <Button
                                type="button"
                                @click="swap(i, i - 1)"
                                :disabled="i === 0"
                            >
                                <Icon
                                    icon="octicon:chevron-up-12"
                                    width="12"
                                    height="12"
                                />
                            </Button>
                            <Button
                                type="button"
                                @click="swap(i, i + 1)"
                                :disabled="
                                    i === articleCreateForm.content.length - 1
                                "
                            >
                                <Icon
                                    icon="octicon:chevron-down-12"
                                    width="12"
                                    height="12"
                                />
                            </Button>
                            <Input
                                :error="
                                    articleCreateForm.errors.content?.[i]
                                        .content
                                "
                                v-model="content.content"
                            />
                            <p @click="removeContentElement(content.id)">
                                Remove
                            </p>
                        </div>
                    </template>
                    <template v-else-if="content.type === 'text'">
                        <div>
                            <Button
                                type="button"
                                @click="swap(i, i - 1)"
                                :disabled="i === 0"
                            >
                                <Icon
                                    icon="octicon:chevron-up-12"
                                    width="12"
                                    height="12"
                                />
                            </Button>
                            <Button
                                type="button"
                                @click="swap(i, i + 1)"
                                :disabled="
                                    i === articleCreateForm.content.length - 1
                                "
                            >
                                <Icon
                                    icon="octicon:chevron-down-12"
                                    width="12"
                                    height="12"
                                />
                            </Button>
                            <RichTextEditor
                                :error="
                                    articleCreateForm.errors.content?.[i]
                                        .content
                                "
                                v-model="content.content"
                            />
                            <p @click="removeContentElement(content.id)">
                                Remove
                            </p>
                        </div>
                    </template>
                    <template v-else>
                        <div>
                            <Button
                                type="button"
                                @click="swap(i, i - 1)"
                                :disabled="i === 0"
                            >
                                <Icon
                                    icon="octicon:chevron-up-12"
                                    width="12"
                                    height="12"
                                />
                            </Button>
                            <Button
                                type="button"
                                @click="swap(i, i + 1)"
                                :disabled="
                                    i === articleCreateForm.content.length - 1
                                "
                            >
                                <Icon
                                    icon="octicon:chevron-down-12"
                                    width="12"
                                    height="12"
                                />
                            </Button>
                            <File
                                :mimes="mimes"
                                :error="
                                    articleCreateForm.errors.content?.[i]
                                        .content
                                "
                                @changeFile="content.content = $event[0]"
                            />
                            <p @click="removeContentElement(content.id)">
                                Remove
                            </p>
                        </div>
                    </template>
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
