import { router } from '@inertiajs/vue3';

// Turns a Quasar button/item into an Inertia link while keeping a real href,
// so ctrl/cmd-click and middle-click still open a new tab.
// Usage: <q-btn v-bind="link_to(route('dashboard'))" label="Dashboard" />
export function link_to(url) {
    return {
        href: url,
        onClick: (event) => {
            const opens_new_tab =
                event.metaKey || event.ctrlKey || event.shiftKey || event.button === 1;

            if (opens_new_tab) {
                return;
            }

            event.preventDefault();
            router.visit(url);
        },
    };
}
