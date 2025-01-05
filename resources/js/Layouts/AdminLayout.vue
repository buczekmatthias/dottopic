<template>
    <div class="bg-container">
        <AdminNavigation>
            <slot />
        </AdminNavigation>
    </div>
</template>

<script setup>
import AdminNavigation from "@/Components/Navigation/AdminNavigation.vue";
</script>
