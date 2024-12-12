import { computed } from "vue";
import { usePage } from "@inertiajs/vue3";

const getCurrentUser = () => computed(() => usePage().props.auth.user);

export default getCurrentUser();
