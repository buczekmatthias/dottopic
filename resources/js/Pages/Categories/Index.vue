<template>
    <div class="flex flex-col gap-4">
        <Link
            :href="route('admin.categories.create')"
            v-if="currentUser && currentUser.isStaff"
            class="md:self-start"
        >
            <Button extraClasses="w-full">Create new category</Button>
        </Link>
        <Deferred data="categories">
            <template #fallback>
                <DeferredLoader text="Loading categories" />
            </template>

            <div class="flex flex-col">
                <div
                    class="flex max-md:flex-col gap-3 md:gap-5 items-start odd:border-y border-solid border-y-input-default py-4"
                    v-for="category in categories.data"
                    :key="category.name"
                >
                    <Category :category="category" />
                </div>
            </div>
            <Pagination
                :links="categories.links"
                :pagination="categories.meta"
            />
        </Deferred>
    </div>
</template>

<script setup>
import { Link, Deferred } from "@inertiajs/vue3";
import route from "@/Composables/Route";
import currentUser from "@/Composables/User";

import Button from "@/Components/Form/Button.vue";
import Pagination from "@/Components/Pagination.vue";
import Category from "@/Components/UI/Category.vue";
import DeferredLoader from "@/Components/DeferredLoader.vue";

defineProps({
    categories: Object,
});
</script>
