<template>
    <div class="flex flex-col">
        <form
            @submit.prevent="
                imageForm.post(
                    route('users.update.image', { user: user.username }),
                    {
                        onSuccess: () => imageForm.reset(),
                    }
                )
            "
            class="flex flex-col gap-3"
        >
            <p class="text-2xl font-semibold">Profile picture</p>
            <div class="grid grid-cols-2 grid-rows-1 gap-2">
                <div
                    :class="
                        user.image
                            ? 'relative'
                            : 'p-2 border border-solid border-input-default flex items-center justify-center'
                    "
                    class="rounded-md overflow-hidden"
                >
                    <template v-if="user.image">
                        <img
                            :src="user.image"
                            class="h-full w-full object-cover"
                            alt=""
                        />
                        <Link
                            :href="
                                route('users.update.image', {
                                    user: user.username,
                                })
                            "
                            method="DELETE"
                            v-if="user.image"
                            class="bg-rose-400/80 p-1.5 rounded-md absolute top-1.5 right-1.5"
                        >
                            <Icon
                                class="text-rose-800"
                                icon="octicon:trash-16"
                                height="20"
                                width="20"
                            />
                        </Link>
                    </template>
                    <template v-else>
                        <p class="text-sm">No image uploaded</p>
                    </template>
                </div>
                <File
                    :error="imageForm.errors.image"
                    @changeFile="imageForm.image = $event[0]"
                    :required="false"
                    :mimes="mimes"
                    teleportTo="#preview"
                    labelClasses="relative h-full cursor-pointer"
                >
                    <template v-if="imageForm.image">
                        <div
                            id="preview"
                            class="[&>*]:w-full [&>*]:h-full [&>*]:!object-cover relative"
                        ></div>
                    </template>
                    <template v-else>
                        <div
                            class="p-2 h-full border border-solid border-input-default hover:bg-slate-600 duration-150 flex items-center justify-center rounded-md overflow-hidden cursor-pointer"
                        >
                            <p class="text-sm">Select new image</p>
                        </div>
                    </template>
                </File>
            </div>
            <Button
                :isProcessing="imageForm.processing"
                processingText="Uploading"
            >
                Upload new image
            </Button>
        </form>
        <form
            @submit.prevent="
                editUserForm.patch(
                    route('users.update', { user: user.username }),
                    { onSuccess: () => editUserForm.reset() }
                )
            "
            class="flex flex-col gap-3 my-4 py-4 border-y border-solid border-y-input-default"
        >
            <p class="text-2xl font-semibold">Profile data</p>
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
                :helpText="`${editUserForm.bio.length} / ${limit}`"
                :limit="limit"
            />
            <Button
                :isProcessing="editUserForm.processing"
                processingText="Updating"
            >
                Update profile
            </Button>
        </form>
        <div class="flex flex-col gap-3">
            <p class="text-2xl font-semibold">Delete profile</p>
            <p class="text-sm text-slate-400">
                This action will permanently delete your account. Articles and
                comments will be orphaned.
            </p>
            <p class="uppercase font-bold">This action can't be reverted</p>
            <Link
                :href="route('users.destroy', { user: user.username })"
                method="DELETE"
            >
                <Button
                    extraClasses="!bg-red-500 enabled:hover:!bg-red-700 w-full"
                >
                    Delete account
                </Button>
            </Link>
        </div>
    </div>
</template>

<script setup>
import { Link, useForm } from "@inertiajs/vue3";
import route from "@/Composables/Route";

import Input from "@/Components/Form/Input.vue";
import Textarea from "@/Components/Form/Textarea.vue";
import File from "@/Components/Form/File.vue";
import Button from "@/Components/Form/Button.vue";

import { Icon } from "@iconify/vue";

const props = defineProps({
    user: Object,
    mimes: Array,
});

const limit = 50;

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

<style scoped lang="postcss">
#preview::after {
    content: "Select image";
    @apply h-full w-full absolute top-0 left-0 z-40 bg-slate-600/80 hidden items-center justify-center text-sm duration-150;
}
#preview:hover::after {
    @apply flex;
}
</style>
