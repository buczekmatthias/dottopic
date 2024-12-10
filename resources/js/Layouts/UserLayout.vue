<template>
    <div>
        <UserNavigation>
            <slot />
        </UserNavigation>
    </div>
</template>

<script setup>
import UserNavigation from "@/Components/Navigation/UserNavigation.vue";
</script>
