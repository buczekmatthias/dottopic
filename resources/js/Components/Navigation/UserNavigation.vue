<template>
    <div
        class="grid grid-rows-[auto_1fr] grid-cols-[60px_1fr] lg:grid-cols-[100px_1fr]"
    >
        <div
            class="col-span-full bg-white p-2 h-14 flex items-center justify-between"
        >
            <p class="text-2xl font-semibold">
                <span class="text-indigo-700">dot</span>Topic
            </p>
            <NavigationUserBox />
        </div>
        <div class="bg-white h-[calc(100vh-3.5rem)] flex flex-col items-center">
            Left
        </div>
        <div class="p-2.5 lg:p-5">
            <slot />
        </div>
    </div>
</template>

<script setup>
import NavigationUserBox from "@/Components/NavigationUserBox.vue";
</script>
