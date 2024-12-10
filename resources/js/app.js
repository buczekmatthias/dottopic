import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";

import { ZiggyVue } from "../../vendor/tightenco/ziggy";

import AdminLayout from "./Layouts/AdminLayout.vue";
import AuthLayout from "./Layouts/AuthLayout.vue";
import UserLayout from "./Layouts/UserLayout.vue";

createInertiaApp({
    resolve: (name) => {
        const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });

        const page = pages[`./Pages/${name}.vue`].default;

        if (name.startsWith("Security/")) {
            page.layout = AuthLayout;
        } else if (name.startsWith("Admin/")) {
            page.layout = AdminLayout;
        } else {
            page.layout = UserLayout;
        }
        return page;
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, props.initialPage.props.ziggy)
            .mount(el);
    },
});
