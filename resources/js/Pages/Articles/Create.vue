<template>
    <div class="content">
        <form @submit.prevent="articleCreateForm.post(route('articles.store'))">
            {{ articleCreateForm.errors }}
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
            <Textarea
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
            {{ articleCreateForm.tags }}
            <div>
                <template
                    v-for="(content, i) in articleCreateForm.content"
                    :key="content.id"
                >
                    <!-- TODO: Add proper error handling -->
                    <!-- TODO: Add moving up and down content elements -->
                    <template v-if="content.type === 'header'">
                        <div>
                            <Input :error="null" v-model="content.content" />
                            <p @click="removeContentElement(content.id)">
                                Remove
                            </p>
                        </div>
                    </template>
                    <template v-else-if="content.type === 'text'">
                        <div>
                            <Textarea :error="null" v-model="content.content" />
                            <p @click="removeContentElement(content.id)">
                                Remove
                            </p>
                        </div>
                    </template>
                    <template v-else>
                        <div>
                            <File
                                :mimes="mimes"
                                :error="null"
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
            {{ articleCreateForm.content }}
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

import ArticleContentTypePicker from "@/Components/Form/ArticleContentTypePicker.vue";
import Input from "@/Components/Form/Input.vue";
import Textarea from "@/Components/Form/Textarea.vue";
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
</script>
