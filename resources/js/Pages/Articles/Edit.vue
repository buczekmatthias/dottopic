<template>
    <div>
        <form
            @submit.prevent="
                articleEditForm.post(
                    route('articles.update', { article: article.slug })
                )
            "
            class="flex flex-col gap-3"
        >
            <Input
                label="Title"
                :error="articleEditForm.errors.title"
                v-model="articleEditForm.title"
            />
            <Select
                label="Category"
                :content="categories"
                :error="articleEditForm.errors.category_slug"
                v-model="articleEditForm.category_slug"
            />

            <RichTextEditor
                label="Description"
                :error="articleEditForm.errors.description"
                v-model="articleEditForm.description"
                :characterLimit="100"
            />
            <MultiSelect
                label="Tags"
                :content="tags"
                :error="articleEditForm.errors.tags"
                v-model="articleEditForm.tags"
            />
            <div class="flex flex-col gap-3">
                <p class="">Content <span class="text-red-500">*</span></p>
                <template
                    v-for="(content, i) in articleEditForm.content"
                    :key="content.id"
                >
                    <ContentElement
                        :type="content.type"
                        :contentLength="articleEditForm.content.length"
                        :index="i"
                        @moveUp="swap(i, i - 1)"
                        @moveDown="swap(i, i + 1)"
                        @removeElement="
                            content.type === 'file'
                                ? toggleFileRemove(content.id)
                                : removeContentElement(content.id)
                        "
                    >
                        <template v-if="content.type === 'header'">
                            <Input
                                :error="
                                    articleEditForm.errors.content?.[i].content
                                "
                                v-model="content.content"
                            />
                        </template>
                        <template v-else-if="content.type === 'text'">
                            <RichTextEditor
                                :error="
                                    articleEditForm.errors.content?.[i].content
                                "
                                v-model="content.content"
                            />
                        </template>
                        <template v-else>
                            <template
                                v-if="typeof content.content === 'string'"
                            >
                                <img
                                    :src="content.content"
                                    alt=""
                                    v-if="content.fileMime.includes('image')"
                                    :class="{
                                        'opacity-20':
                                            articleEditForm.files_to_remove.includes(
                                                content.id
                                            ),
                                    }"
                                />
                                <video
                                    :src="content.content"
                                    v-else
                                    :class="{
                                        'opacity-20':
                                            articleEditForm.files_to_remove.includes(
                                                content.id
                                            ),
                                    }"
                                ></video>
                            </template>
                            <template v-else>
                                <File
                                    :mimes="mimes"
                                    :error="
                                        articleEditForm.errors.content?.[i]
                                            .content
                                    "
                                    @changeFile="content.content = $event[0]"
                                />
                            </template>
                        </template>
                    </ContentElement>
                </template>
            </div>
            <ArticleContentTypePicker @typePicked="handleNewPick" />
            <Button
                :isProcessing="articleEditForm.processing"
                processingText="Updating"
            >
                Update
            </Button>
        </form>
        <Link
            :href="
                route('articles.destroy', {
                    article: article.slug,
                })
            "
            method="DELETE"
        >
            <Button extraClasses="!bg-red-500 enabled:hover:!bg-red-700 w-full">
                Delete article
            </Button>
        </Link>
    </div>
</template>

<script setup>
import { ref, computed } from "vue";
import { useForm, Link } from "@inertiajs/vue3";
import route from "@/Composables/Route";

import ArticleContentTypePicker from "@/Components/Form/ArticleContentTypePicker.vue";
import Input from "@/Components/Form/Input.vue";
import RichTextEditor from "@/Components/Form/RichTextEditor.vue";
import File from "@/Components/Form/File.vue";
import Select from "@/Components/Form/Select.vue";
import MultiSelect from "@/Components/Form/MultiSelect.vue";
import Button from "@/Components/Form/Button.vue";
import ContentElement from "@/Components/Form/ContentElement.vue";

const props = defineProps({
    article: Object,
    categories: Object,
    tags: Object,
    mimes: Array,
});

const usedTags = computed(() => props.article.tags.map((t) => t.slug));

const articleEditForm = useForm({
    title: props.article.title,
    description: props.article.description,
    content: props.article.content,
    category_slug: props.article.category.slug,
    tags: usedTags.value,
    files_to_remove: [],
});

const contentItemsHighestId = ref(props.article.content.length - 1);

const handleNewPick = (type) => {
    contentItemsHighestId.value++;

    articleEditForm.content.push({
        id: contentItemsHighestId.value,
        type: type,
        content: type === "file" ? null : "",
    });
};

const removeContentElement = (id) => {
    articleEditForm.content = articleEditForm.content.filter(
        (content) => content.id !== id
    );
};

const swap = (index, newIndex) => {
    let temp = articleEditForm.content[index];
    articleEditForm.content[index] = articleEditForm.content[newIndex];
    articleEditForm.content[newIndex] = temp;
};

const toggleFileRemove = (id) => {
    if (articleEditForm.files_to_remove.includes(id))
        articleEditForm.files_to_remove =
            articleEditForm.files_to_remove.filter((f) => f !== id);
    else articleEditForm.files_to_remove.push(id);
};
</script>
