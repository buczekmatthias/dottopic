<template>
    <div class="flex flex-col gap-8" id="dashboard">
        <Deferred data="users">
            <template #fallback>
                <div>Loading users...</div>
            </template>

            <Users :stats="users" />
        </Deferred>

        <Deferred data="articles">
            <template #fallback>
                <div>Loading articles...</div>
            </template>

            <Articles :stats="articles" />
        </Deferred>

        <Deferred data="tags">
            <template #fallback>
                <div>Loading tags...</div>
            </template>

            <Tags :stats="tags" />
        </Deferred>

        <Deferred data="categories">
            <template #fallback>
                <div>Loading categories...</div>
            </template>

            <Categories :stats="categories" />
        </Deferred>
    </div>
</template>

<script setup>
import { Deferred } from "@inertiajs/vue3";

import Articles from "@/Components/UI/Admin/Dashboard/Articles.vue";
import Categories from "@/Components/UI/Admin/Dashboard/Categories.vue";
import Tags from "@/Components/UI/Admin/Dashboard/Tags.vue";
import Users from "@/Components/UI/Admin/Dashboard/Users.vue";

defineProps({
    users: Object,
    articles: Object,
    tags: Object,
    categories: Object,
});
</script>
