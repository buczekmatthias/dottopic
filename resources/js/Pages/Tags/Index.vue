<template>
    <div class="flex flex-col gap-4">
        <Link
            :href="route('admin.tags.create')"
            v-if="currentUser && currentUser.isStaff"
            class="md:self-start"
        >
            <Button extraClasses="w-full">Create new tag</Button>
        </Link>
        <Deferred data="tags">
            <template #fallback>
                <DeferredLoader text="Loading tags" />
            </template>

            <div class="flex flex-col">
                <div
                    class="flex flex-col gap-3 items-start odd:border-y border-solid border-y-input-default py-4"
                    v-for="tag in tags.data"
                    :key="tag.name"
                >
                    <p class="text-2xl">{{ tag.name }}</p>
                    <div class="flex gap-4">
                        <div
                            class="flex gap-1 items-center text-sm text-slate-400"
                        >
                            <Icon icon="octicon:file" height="16" width="16" />
                            <p>{{ tag.articles_count }} article(s)</p>
                        </div>
                        <div
                            class="flex gap-1 items-center text-sm text-slate-400"
                        >
                            <Icon
                                icon="octicon:file-directory-16"
                                height="16"
                                width="16"
                            />
                            <p>{{ tag.categories_count }} category(ies)</p>
                        </div>
                    </div>
                    <Link
                        :href="
                            route('tags.show', {
                                tag: tag.slug,
                            })
                        "
                        class="flex items-center gap-1.5 text-link hover:gap-2.5 duration-150"
                    >
                        Show tag
                        <Icon
                            icon="octicon:arrow-right-16"
                            height="16"
                            width="16"
                            class="mt-1"
                        />
                    </Link>
                </div>
            </div>
            <Pagination :links="tags.links" :pagination="tags.meta" />
        </Deferred>
    </div>
</template>

<script setup>
import { Link, Deferred } from "@inertiajs/vue3";
import route from "@/Composables/Route";
import currentUser from "@/Composables/User";

import Button from "@/Components/Form/Button.vue";
import Pagination from "@/Components/Pagination.vue";
import DeferredLoader from "@/Components/DeferredLoader.vue";

import { Icon } from "@iconify/vue";

defineProps({
    tags: Object,
});
</script>
