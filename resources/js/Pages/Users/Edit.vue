<template>
    <div>
        {{ user }}
        <form
            @submit.prevent="
                imageForm.post(
                    route('users.update.image', { user: user.username }),
                    {
                        onSuccess: () => imageForm.reset(),
                    }
                )
            "
        >
            <!-- TODO: Custom label for file upload -->
            <File
                label="Profile picture"
                :error="imageForm.errors.image"
                @changeFile="imageForm.image = $event[0]"
                :required="false"
                :mimes="mimes"
            >
            </File>
            <Button
                :isProcessing="imageForm.processing"
                processingText="Uploading"
            >
                Upload image
            </Button>
        </form>
        <Link
            :href="route('users.update.image', { user: user.username })"
            method="DELETE"
            v-if="user.image"
        >
            Delete image
        </Link>
        <form
            @submit.prevent="
                editUserForm.patch(
                    route('users.update', { user: user.username }),
                    { onSuccess: () => editUserForm.reset() }
                )
            "
        >
            <Input
                label="Name"
                :error="editUserForm.errors.name"
                v-model="editUserForm.name"
            />
            <Input
                label="E-mail"
                :error="editUserForm.errors.email"
                type="email"
                v-model="editUserForm.email"
            />
            <Input
                label="Password"
                :error="editUserForm.errors.password"
                type="password"
                v-model="editUserForm.password"
                :required="false"
                helpText="Password won't change if field is left blank"
            />
            <Textarea
                label="Bio"
                :required="false"
                :error="editUserForm.errors.bio"
                v-model="editUserForm.bio"
                :helpText="`${editUserForm.bio.length}`"
            />
            <Button
                :isProcessing="editUserForm.processing"
                processingText="Updating"
            >
                Update profile
            </Button>
            {{ editUserForm }}
            <br />
            <br />
            <Link
                :href="route('users.destroy', { user: user.username })"
                method="DELETE"
            >
                Delete account
            </Link>
        </form>
    </div>
</template>

<script setup>
import { Link, useForm } from "@inertiajs/vue3";
import route from "@/Composables/Route";

import Input from "@/Components/Form/Input.vue";
import Textarea from "@/Components/Form/Textarea.vue";
import File from "@/Components/Form/File.vue";
import Button from "@/Components/Form/Button.vue";

const props = defineProps({
    user: Object,
    mimes: Array,
});

const editUserForm = useForm({
    name: props.user.name,
    email: props.user.email,
    password: "",
    bio: props.user.bio || "",
});

const imageForm = useForm({
    image: null,
});
</script>
