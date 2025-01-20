<template>
    <Head :title="getTitle()" />
    <div class="font-light bg-theme/30 rounded-md px-2.5 py-3">
        <p class="truncate" v-html="getBreadCrumbs()"></p>
    </div>
</template>

<script setup>
import { computed } from "vue";
import { usePage, Head } from "@inertiajs/vue3";

const crumbs = computed(() => usePage().props.breadcrumbs);

const getBreadCrumbs = () => {
    let str = "";
    const separator =
        "<span class='text-slate-300/80 font-semibold text-sm'>❯</span>";

    crumbs.value.forEach((c, i) => {
        str += c;

        if (i !== crumbs.value.length - 1) {
            str += ` ${separator} `;
        }
    });

    return str;
};

const getTitle = () => {
    let t = crumbs.value?.[2]
        ? `${crumbs.value[0]} - ${crumbs.value[2]}`
        : crumbs.value[0];

    return `${t} | dotTopic`;
};
</script>
