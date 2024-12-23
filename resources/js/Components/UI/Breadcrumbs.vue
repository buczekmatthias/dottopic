<template>
    <Head :title="`${crumbs[0]} | dotTopic`" />
    <div class="content">
        <p v-html="getBreadCrumbs()"></p>
    </div>
</template>

<script setup>
import { computed } from "vue";
import { usePage, Head } from "@inertiajs/vue3";

const crumbs = computed(() => usePage().props.breadcrumbs[0]);

const getBreadCrumbs = () => {
    let str = "";
    const separator = "<span class='text-slate-300/80 font-semibold'>❯</span>";

    crumbs.value.forEach((c, i) => {
        str += c;

        if (i !== crumbs.value.length - 1) {
            str += ` ${separator} `;
        }
    });

    return str;
};
</script>
