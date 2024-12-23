import { usePage } from "@inertiajs/vue3";
import { route } from "ziggy-js";

export default function useRoute(
    name,
    params,
    absolute,
    config = usePage().props.routes.ziggy
) {
    return route(name, params, absolute, config);
}

const currentRoute = () => usePage().props.routes.current;

const isActiveRoute = (r) => r === currentRoute();

const isCurrentRouteInGroup = (r) => currentRoute().includes(r);

export { currentRoute, isActiveRoute, isCurrentRouteInGroup };
