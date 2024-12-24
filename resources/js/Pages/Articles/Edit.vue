<template>
    <div>
        {{ articleEditForm.errors }}
        <form
            @submit.prevent="
                articleEditForm.post(
                    route('articles.update', { article: article.slug })
                )
            "
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
            />
            <MultiSelect
                label="Tags"
                :content="tags"
                :error="articleEditForm.errors.tags"
                v-model="articleEditForm.tags"
            />
            <div>
                <template
                    v-for="(content, i) in articleEditForm.content"
                    :key="content.id"
                >
                    {{ content }}
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
                                    i === articleEditForm.content.length - 1
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
                                    articleEditForm.errors.content?.[i].content
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
                                    i === articleEditForm.content.length - 1
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
                                    articleEditForm.errors.content?.[i].content
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
                                    i === articleEditForm.content.length - 1
                                "
                            >
                                <Icon
                                    icon="octicon:chevron-down-12"
                                    width="12"
                                    height="12"
                                />
                            </Button>
                            <!-- TODO: Add displaying image instead of file input in Vue form -->
                            {{ content.content }}
                            {{ typeof content.content }}
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
                                <p @click="toggleFileRemove(content.id)">
                                    Remove file
                                </p>
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
                                <p @click="removeContentElement(content.id)">
                                    Remove
                                </p>
                            </template>
                        </div>
                    </template>
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
    </div>
</template>

<script setup>
import { ref, computed } from "vue";
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
